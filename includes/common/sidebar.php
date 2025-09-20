<?php
// includes/common/sidebar.php
?>
<!-- Sidebar trigger button -->
<button id="sidebar-toggle" class="sidebar-toggle" aria-label="Open Menu" aria-controls="comp-sidebar">
    <span class="material-icons" aria-hidden="true">menu</span>
</button>

<!-- Sidebar -->
<aside id="comp-sidebar" class="sidebar" role="navigation" aria-label="Main Sidebar" aria-hidden="true">
    <div class="sidebar__inner">
        <button id="sidebar-close" class="sidebar__close" aria-label="Close Menu">
            <span class="material-icons" aria-hidden="true">close</span>
        </button>

        <nav class="sidebar__nav" role="menu" aria-label="Primary">
            <a role="menuitem" href="?page=home">
                <span class="material-icons" aria-hidden="true">home</span>
                <span>Home</span>
            </a>

            <a role="menuitem" href="?page=profile">
                <span class="material-icons" aria-hidden="true">person</span>
                <span>Profile</span>
            </a>

            <a role="menuitem" href="?page=orders">
                <span class="material-icons" aria-hidden="true">shopping_bag</span>
                <span>Orders</span>
            </a>

            <a role="menuitem" href="?page=support">
                <span class="material-icons" aria-hidden="true">support_agent</span>
                <span>Support</span>
            </a>


            <a role="menuitem" href="?action=logout" class="sidebar-item--danger">
                <span class="material-icons" aria-hidden="true">logout</span>
                <span>Logout</span>
            </a>
        </nav>
    </div>
</aside>

<!-- Backdrop (click to close) -->
<div id="sidebar-backdrop" class="sidebar-backdrop" aria-hidden="true"></div>

<!-- Sidebar JS -->
<script src="assets/js/common/sidebar.js" defer></script>