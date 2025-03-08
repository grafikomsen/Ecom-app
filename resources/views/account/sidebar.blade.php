<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <a href="account.php"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false">
            <i class="fas fa-user-alt"></i> Mon profil
        </a>
    </li>
    <li class="nav-item">
        <a href="my-orders.php"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-shopping-bag"></i> Mes commandes
        </a>
    </li>
    <li class="nav-item">
        <a href="wishlist.php"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-heart"></i> Liste de souhaits
        </a>
    </li>
    <li class="nav-item">
        <a href="change-password.php"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-lock"></i> Changer le mot de passe
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.logout') }}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false">
            <i class="fas fa-sign-out-alt"></i> Déconnectez
        </a>
    </li>
</ul>
