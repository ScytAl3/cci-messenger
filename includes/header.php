<!--Main Navigation-->
<!-- affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<header>
    <!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->          
    <nav class="navbar navbar-expand-md navbar-dark static-top justify-content-between <?=($_SESSION['session'])?  'bg-success' : 'bg-primary'; ?>">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
            <img src="/img/logo/messenger_logo_black_150x151.png" alt="CCI Messenger logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1><strong>CCI MESSENGER</strong></h1>
            <div class="d-flex hidden">
                <ul class="navbar-nav mr-3 mt-3 <?= ($_SESSION['session'])? 'visible ' : 'invisible '; ?>" style="border: solid red;">
                    <li class="">
                        <p>Numéro de création [ <strong><em><?= $_SESSION['idCreate']; ?></em></strong> ]</p>
                    </li>
                    <li>
                        <p>Bonjour&nbsp;<strong><em><?= $_SESSION['pseudo']; ?></em></strong></p>
                    </li>
                </ul>
                <div class="form-inline mt-2 mt-md-0  <?=($_SESSION['session'])? 'visible ' : 'invisible '; ?>">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="/user_profil.php">- Profil -</a>
                    <a class="btn btn-outline-success my-2 my-sm-0 ml-1" href="/logout.php">Logout</a>
                </div>         
            </div>
        </div>
    </nav>   
</header>
<!-- /affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<!--Main Navigation-->