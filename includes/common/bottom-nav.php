<!-- includes/bottom-navbar.php -->
<nav id="bottom-navbar" class="bottom-navbar" role="navigation" aria-label="Mobile bottom navigation">
    <a class="bn-item" href="?page=home" aria-label="Home">
        <span class="material-icons" aria-hidden="true">home</span>
    </a>

    <a class="bn-item" href="?page=orders" aria-label="Orders">
        <span class="material-icons" aria-hidden="true">shopping_bag</span>
    </a>

    <!-- Toggle: opens sidebar as bottom drawer on small screens -->
    <button id="bn-toggle" class="bn-item bn-toggle" aria-label="Open menu" aria-controls="comp-sidebar" aria-expanded="false">
        <span class="material-icons" aria-hidden="true">menu</span>
    </button>

    <!-- Search: opens centered search modal -->
    <button id="bn-search" class="bn-item" aria-label="Search">
        <span class="material-icons" aria-hidden="true">search</span>
    </button>

    <a class="bn-item" href="?action=logout" aria-label="Logout">
        <span class="material-icons" aria-hidden="true">logout</span>
    </a>
</nav>

<!-- Centered search modal -->
<div id="mobile-search" class="mobile-search" aria-hidden="true" role="dialog" aria-label="Search">
    <div class="mobile-search__panel" role="document">
        <button id="mobile-search-close" class="mobile-search__close" aria-label="Close search">
            <span class="material-icons" aria-hidden="true">close</span>
        </button>
        <form id="mobile-search-form" class="mobile-search__form" action="?page=search" method="get" role="search">
            <input name="q" type="search" placeholder="Search..." aria-label="Search" />
            <button type="submit" class="mobile-search__submit" aria-label="Submit search">
                <span class="material-icons" aria-hidden="true">search</span>
            </button>
        </form>
    </div>
</div>
<script src="assets/js/common/bottom-nav.js"></script>