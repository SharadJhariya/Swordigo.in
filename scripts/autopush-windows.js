const chokidar = require('chokidar');
const simpleGit = require('simple-git');
const path = require('path');
const fs = require('fs');

const repoDir = process.argv[2] || path.resolve('.');
const branch = process.argv[3] || 'main';  // change to 'auto-sync' if you want a safe branch
const debounceMs = parseInt(process.env.DEBOUNCE_MS || '3000', 10);

const git = simpleGit(repoDir);
let timer = null;

function log(msg) {
  const line = `[${new Date().toISOString()}] ${msg}`;
  console.log(line);
  try { fs.appendFileSync(path.join(repoDir, 'autopush.log'), line + '\n'); } catch(e) {}
}

(async () => {
  log(`autopush starting in ${repoDir} branch=${branch}`);
  const watcher = chokidar.watch(repoDir, {
    ignored: /(^|[\/\\])(\.git|node_modules|vendor|\.cache)/,
    persistent: true,
    ignoreInitial: true,
    depth: 6
  });

  const work = async () => {
    try {
      const status = await git.status();
      if (status.files.length === 0) return;

      log('Changes detected: ' + status.files.map(f => f.path).join(', '));
      await git.add('.');
      const staged = (await git.diffSummary(['--cached'])).files.length;
      if (!staged) return;

      const commitMsg = `auto: workspace changes ${new Date().toISOString()}`;
      await git.commit(commitMsg);
      log('Committed: ' + commitMsg);

      try {
        await git.push('origin', branch);
        log('Pushed to origin/' + branch);
      } catch (e) {
        log('Push failed: ' + (e && e.message ? e.message : e));
      }
    } catch (err) {
      log('Watcher error: ' + (err && err.message ? err.message : err));
    }
  };

  const scheduleWork = () => {
    clearTimeout(timer);
    timer = setTimeout(work, debounceMs);
  };

  watcher.on('all', scheduleWork);
})();
