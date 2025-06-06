<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">BOUTIQUE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 fw-bolder fs-4 {{ (Session::get('page') == 'dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    DASHBOARD
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'categorie') ? 'active' : '' }}" href="{{ route('admin.categorie') }}">
                    <i class="fa-solid fa-stapler"></i>
                    CATÉGORIES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'subcategorie') ? 'active' : '' }}" href="{{ route('admin.subcategorie') }}">
                    <i class="fa-solid fa-paper-plane"></i>
                    SOUS CATÉGORIES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'brand') ? 'active' : '' }}" href="{{ route('admin.brand') }}">
                    <i class="fa-solid fa-ticket"></i>
                    MARQUES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'product') ? 'active' : '' }}" href="{{ route('admin.product') }}">
                    <i class="fa-solid fa-layer-group"></i>
                    PRODUITS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'banner') ? 'active' : '' }}" href="{{ route('admin.banners') }}">
                    <i class="fa-solid fa-image"></i>
                    BANNIÉRES
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
            <span class="fw-bold">INFORMAYION DE COMMANDES</span>
        </h6>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'create') ? 'active' : '' }}" href="{{ route('admin.shipping.create') }}">
                    <i class="fa-solid fa-truck-fast"></i>
                    LIVRAISON
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'discount') ? 'active' : '' }}" href="{{ route('admin.discount') }}">
                    <i class="fa-solid fa-clipboard"></i>
                    CODE COUPON
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'order') ? 'active' : '' }}" href="{{ route('admin.order') }}">
                    <i class="fa-solid fa-money-bill"></i>
                    COMMANDES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="fa-solid fa-users"></i>
                    CLIENTS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'pages') ? 'active' : '' }}" href="{{ route('admin.pages') }}">
                    <i class="fa-solid fa-blog"></i>
                    PAGES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2 {{ (Session::get('page') == 'settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                    <i class="fa-solid fa-gears"></i>
                    PARAMETRES
                </a>
            </li>
        </ul>
    </div>
</div>


