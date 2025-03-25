<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <a href="{{ route('account.profile') }}"  class="btn btn-default w-100 text-start rounded-1 mb-2 font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false">
            <i class="fas fa-user-alt text-white"></i> Mon profil
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.orders') }}"  class="btn btn-default w-100 text-start rounded-1 mb-2 font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-shopping-bag text-white"></i> Mes commandes
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.wishlist') }}"  class="btn btn-default w-100 text-start rounded-1 mb-2 font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-heart text-white"></i> Liste de souhaits
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.showChangePassword') }}"  class="btn btn-default w-100 text-start rounded-1 mb-2 font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-lock text-white"></i> Changer le mot de passe
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.logout') }}" class="btn btn-default w-100 text-start rounded-1 mb-2 font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-sign-out-alt text-white"></i> Déconnectez
        </a>
    </li>
</ul>
