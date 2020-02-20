<!--Main Navigation-->
<!-- affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<header>
    <!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->          
    <nav class="navbar navbar-expand-md navbar-dark static-top <?=($_SESSION['session']) ?  'bg-success' : 'bg-primary'; ?>">        
            <a class="navbar-brand" href="/index.php">
            <img src="/img/logo/messenger_logo_black_150x151.png" alt="CCI Messenger logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="w-100">
                <h1 class="align-self-center"><strong>CCI MESSENGER</strong></h1>
            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="<?= ($_SESSION['session']) ? 'visible ' : 'invisible '; ?> align-self-end mr-3">
                        <p>Bonjour&nbsp;<strong><em><?= $_SESSION['pseudo']; ?></em></strong></p>
                    </li>
                    <li>
                        <img src="/img/profil_pictures/<?= ($_SESSION['session']) ? $userAvatar : 'avatar_default.png '; ?>" alt="Avatar default" class="avatar-circle">
                    </li>
                    <li class="<?=($_SESSION['session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                        <a class="my-2 my-sm-0 ml-1" href="/logout.php"><img src="/img/switch-off.png" alt="Logout" class="logout-button"></a>
                    </li>
                </ul>     
            </div>            
    </nav>   
</header>
<!-- /affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<!--Main Navigation-->