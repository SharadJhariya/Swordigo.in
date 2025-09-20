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

        <!-- Cart -->
        <div class="cart-container">
            <a href="#cart" class="nav-icon cart-icon" aria-label="View cart">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="badge">2</span>
            </a>
        </div>

        <!-- Notifications -->
        <div class="dropdown" data-dropdown-name="notifications">
            <button class="nav-icon notification-icon" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-controls="">
                <i class="fa fa-bell" aria-hidden="true"></i>
                <span class="badge">3</span>
            </button>

            <div class="dropdown-menu" role="menu" aria-label="Notifications menu">
                <div class="notifications-inner">
                    <div class="notif-list">
                        <div class="notif-item">
                            <img class="notif-avatar" src="assets/images/customer-images/customer-1.jpg" alt="Avatar">
                            <div class="notif-body">
                                <div class="notif-text">
                                    <strong class="notif-name">Carl Sullivan</strong>
                                    <span class="notif-action">just ordered a</span>
                                    <a href="#" class="notif-link">Premium Black Steel Katana</a>
                                </div>
                                <div class="notif-meta">
                                    <span class="notif-time">15 minutes ago</span>
                                </div>
                            </div>
                        </div>
                        <!-- repeat similar .notif-item -->
                        <div class="notif-item">
                            <img class="notif-avatar" src="assets/images/customer-images/customer-1.jpg" alt="Avatar">
                            <div class="notif-body">
                                <div class="notif-text">
                                    <strong class="notif-name">Carl Sullivan</strong>
                                    <span class="notif-action">just ordered a</span>
                                    <a href="#" class="notif-link">Premium Black Steel Katana</a>
                                </div>
                                <div class="notif-meta">
                                    <span class="notif-time">15 minutes ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="notif-item">
                            <img class="notif-avatar" src="assets/images/customer-images/customer-1.jpg" alt="Avatar">
                            <div class="notif-body">
                                <div class="notif-text">
                                    <strong class="notif-name">Carl Sullivan</strong>
                                    <span class="notif-action">just ordered a</span>
                                    <a href="#" class="notif-link">Premium Black Steel Katana</a>
                                </div>
                                <div class="notif-meta">
                                    <span class="notif-time">15 minutes ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="viewall-id" class="notif-footer">
                        <a class="view-all" href="#all">View all notifications</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile -->
        <div class="dropdown" data-dropdown-name="profile">
            <a href="#profile" class="profile-link" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-controls="">
                <img src="assets/images/customer-images/customer-1.jpg" alt="User Profile">
            </a>

            <div class="dropdown-menu" role="menu" aria-label="Profile menu">
                <div class="profile-header">
                    <img class="ph-avatar" src="assets/images/customer-images/customer-1.jpg" alt="avatar">
                    <div class="ph-info">
                        <div class="ph-name">Nishant Sisodiya</div>
                        <div class="ph-email">Administrator</div>
                    </div>
                </div>

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

<!-- Cart Sidebar (desktop only) -->
<aside id="cart-sidebar" class="cart-sidebar" role="region" aria-label="Cart" aria-hidden="true">
    <div class="cart-sidebar__inner">
        <button id="cart-close" class="cart-sidebar__close" aria-label="Close cart">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>

        <header class="cart-sidebar__header">
            <h3>Your Cart</h3>
            <div class="cart-sidebar__meta">
                <span class="cart-count">2 items</span>
                <span class="cart-total">₹ 12,499</span>
            </div>
        </header>

        <div class="cart-sidebar__content">
            <!-- sample item -->
            <div class="cart-item">
                <img src="assets/images/product-review-images/KAT-001.jpg" alt="Product" class="cart-item__img">
                <div class="cart-item__body">
                    <div class="cart-item__title">Premium Black Steel Katana</div>
                    <div class="cart-item__meta">Qty: 1 · ₹ 6,249</div>
                </div>
            </div>
        </div>

        <footer class="cart-sidebar__footer">
            <a href="?page=cart" class="btn btn-ghost">View Cart</a>
            <a href="?page=checkout" class="btn btn-primary">Checkout</a>
        </footer>
    </div>
</aside>

<!-- Backdrop -->
<div id="cart-backdrop" class="cart-backdrop" aria-hidden="true"></div>

<!-- required scripts -->
<script src="assets/js/common/navbar.js"></script>