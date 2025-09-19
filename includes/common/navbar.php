<nav id="main-navbar" role="navigation" aria-label="Main">
    <div class="nav-left"></div>

    <div class="nav-center">
        <a class="logo-link" href="#home" aria-label="Homepage">
            <img src="assets/images/logos/logo-black.svg" alt="Katana Logo">
        </a>
    </div>

    <div class="nav-right">
        <!-- Search (desktop only) -->
        <div class="search-container">
            <input type="search" class="search-input" placeholder="Search...">
            <button class="nav-icon search-icon" aria-label="Open search">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Notifications (toggle button + dropdown content) -->
        <div class="dropdown" data-dropdown-name="notifications">
            <button class="nav-icon notification-icon" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-controls="">
                <i class="fa fa-bell" aria-hidden="true"></i>
                <span class="badge">3</span>
            </button>

            <!-- notifications dropdown content (replace dropdown-menu for notifications) -->
            <div class="dropdown-menu" role="menu" aria-label="Notifications menu">
                <div class="notifications-inner">

                    <div class="notif-list">

                        <div class="notif-item">
                            <img class="notif-avatar" src="assets/images/customer-images/customer-1.jpg" alt="Avatar">
                            <div class="notif-body">
                                <div class="notif-text">
                                    <strong class="notif-name">Carl Sullivan</strong>
                                    <span class="notif-action">just Ordered</span>
                                    <a href="#" class="notif-link">He purchased a Katana.</a>
                                </div>
                                <div class="notif-meta">
                                    <span class="notif-time">15 minutes ago</span>
                                </div>
                            </div>
                            <div class="notif-actions">
                                <button class="notif-btn" aria-label="mark as read"><i class="fa fa-circle-notch"></i></button>
                            </div>
                        </div>

                        <!-- repeat similar .notif-item blocks -->
                        <div class="notif-item">
                            <img class="notif-avatar" src="assets/images/customer-images/customer-1.jpg" alt="Avatar">
                            <div class="notif-body">
                                <div class="notif-text">
                                    <strong class="notif-name">Carl Sullivan</strong>
                                    <span class="notif-action">just Ordered</span>
                                    <a href="#" class="notif-link">He purchased a Katana.</a>
                                </div>
                                <div class="notif-meta">
                                    <span class="notif-time">15 minutes ago</span>
                                </div>
                            </div>
                            <div class="notif-actions">
                                <button class="notif-btn" aria-label="dismiss"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <!-- ... more items ... -->
                    </div>

                    <div class="notif-footer">
                        <a class="view-all" href="#all">View all notifications</a>
                        <div class="notif-footer-actions">
                            <button class="footer-btn" aria-label="mark all read"><i class="fa fa-check"></i></button>
                            <button class="footer-btn" aria-label="settings"><i class="fa fa-cog"></i></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Profile -->
        <div class="dropdown" data-dropdown-name="profile">
            <a href="#profile" class="profile-link" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-controls="">
                <img src="assets/images/customer-images/customer-1.jpg" alt="User Profile">
            </a>

            <!-- will be moved to body by JS -->
            <div class="dropdown-menu" role="menu" aria-label="Profile menu">
                <!-- Profile header -->
                <div class="profile-header">
                    <img class="ph-avatar" src="assets/images/customer-images/customer-1.jpg" alt="avatar">
                    <div class="ph-info">
                        <div class="ph-name">Nishant Sisodiya</div>
                        <div class="ph-email">Administrator</div>
                    </div>
                </div>

                <!-- Menu items -->
                <div class="profile-items">
                    <a href="#profile-settings" role="menuitem"><i class="fa fa-user-cog"></i> Profile Settings</a>
                    <a href="#help" role="menuitem"><i class="fa fa-question-circle"></i> Help Center</a>
                    <a href="#light-mode" role="menuitem" class="toggle-light"><i class="fa fa-lightbulb"></i> Light Mode</a>
                    <a href="#upgrade" role="menuitem"><i class="fa fa-arrow-up-right-from-square"></i> Upgrade Plan</a>
                </div>

                <div class="profile-footer">
                    <a href="#signout" role="menuitem" class="sign-out"><i class="fa fa-sign-out-alt"></i> Log Out</a>
                </div>
            </div>
        </div>

    </div>
</nav>

<!-- required scripts -->
<script src="assets/js/common/navbar.js"></script>