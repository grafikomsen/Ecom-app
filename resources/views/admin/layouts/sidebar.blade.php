<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">BOUTIQUE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 fw-bolder fs-4 text-uppercase active" aria-current="page" href="{{ route('admin.dashboard') }}">
                <svg class="bi"><use xlink:href="#house-fill"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2" href="{{ route('admin.categorie') }}">
                <svg class="bi"><use xlink:href="#file-earmark"/></svg>
                    CATÉGORIES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2" href="{{ route('admin.subcategorie') }}">
                <svg class="bi"><use xlink:href="#cart"/></svg>
                    SOUS CATÉGORIES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2" href="{{ route('admin.brand') }}">
                <svg class="bi"><use xlink:href="#people"/></svg>
                    MARQUES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center fs-6 fw-bold gap-2" href="{{ route('admin.product') }}">
                <svg class="bi"><use xlink:href="#graph-up"/></svg>
                    PRODUITS
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <svg class="bi"><use xlink:href="#plus-circle"/></svg>
            </a>
        </h6>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
                Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
                Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
                Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
                Year-end sale
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi"><use xlink:href="#gear-wide-connected"/></svg>
                    Paramétres
                </a>
            </li>
        </ul>
    </div>
</div>


