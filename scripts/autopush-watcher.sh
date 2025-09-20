#!/usr/bin/env bash
# scripts/autopush-watcher.sh
# Watch the repository for file changes and auto-commit + push.
# Usage: ./scripts/autopush-watcher.sh [watch-dir] [branch]
# Example: ./scripts/autopush-watcher.sh . main

set -euo pipefail

WATCH_DIR="${1:-.}"
BRANCH="${2:-$(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo main)}"
DEBOUNCE="${DEBOUNCE:-3}"   # seconds to wait to batch events
MAX_LOOP="${MAX_LOOP:-0}"   # 0 = unlimited

# Files/patterns to ignore (basic)
IGNORE_REGEX='(^|/)(\.git|node_modules|\.cache|tmp|vendor)(/|$)'

# Ensure inside a git repo
git rev-parse --is-inside-work-tree >/dev/null 2>&1 || { echo "Not a git repository. Exiting."; exit 1; }

echo "[autopush] watching '${WATCH_DIR}' on branch '${BRANCH}' (debounce=${DEBOUNCE}s)"

count=0
while true; do
  # Wait for events (modify/create/delete/move) recursively
  EVENT_FILE="$(inotifywait -r -e modify,create,delete,move --format '%w%f' "${WATCH_DIR}" 2>/dev/null || true)"
  if [ -z "$EVENT_FILE" ]; then
    # inotifywait exited unexpectedly; small sleep and continue
    sleep 1
    continue
  fi

  # Skip ignored paths quickly
  if echo "$EVENT_FILE" | grep -Eq "${IGNORE_REGEX}"; then
    # ignored event
    continue
  fi

  # debounce: wait to batch multiple quick changes
  sleep "${DEBOUNCE}"

  # Check again for changes; if nothing to add, continue
  # Avoid touching .git
  if ! git status --porcelain | grep -q .; then
    # nothing changed
    continue
  fi

  # Stage everything
  git add -A

  # If no staged changes after add, continue
  if git diff --cached --quiet; then
    continue
  fi

  # Configure author if not set (safe default)
  git config user.name >/dev/null 2>&1 || git config user.name "Workspace AutoCommit"
  git config user.email >/dev/null 2>&1 || git config user.email "autocommit@users.noreply.github.com"

  COMMIT_MSG="auto: workspace changes $(date -u +'%Y-%m-%dT%H:%M:%SZ')"
  echo "[autopush] committing: ${COMMIT_MSG}"
  # Create commit
  if git commit -m "${COMMIT_MSG}"; then
    echo "[autopush] commit created, pushing to origin/${BRANCH} ..."
    # Try to pull/rebase to avoid simple conflicts (optional)
    # git pull --rebase origin "${BRANCH}" || true
    if git push origin "${BRANCH}"; then
      echo "[autopush] pushed successfully."
    else
      echo "[autopush] push failed. You may need to resolve conflicts or authenticate."
    fi
  else
    echo "[autopush] commit failed (no changes?)"
  fi

  # Optional loop limit to aid testing
  count=$((count+1))
  if [ "${MAX_LOOP}" -gt 0 ] && [ "${count}" -ge "${MAX_LOOP}" ]; then
    echo "[autopush] reached MAX_LOOP=${MAX_LOOP}, exiting."
    break
  fi
done
