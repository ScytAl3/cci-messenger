<!--Main Navigation-->
<!-- affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<header>
    <!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->   
    <nav class="navbar navbar-expand-md navbar-dark static-top <?=($_SESSION['session']) ?  'bg-success' : 'bg-primary'; ?>">
        <a class="navbar-brand" href="/index.php">
            <img src="/img/logo/messenger_logo_black_150x151.png" alt="CCI Messenger logo">
        </a>
        <h1 class="align-self-center"><strong>CCI MESSENGER</strong></h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto <?= ($_SESSION['session']) ? 'visible ' : 'invisible '; ?>">
                <li class="nav-item active">
                    <a class="nav-link" href="/chat_list.php">Messagerie</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/contacts_list.php">Contacts
                </li>
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav ml-auto">
                        <li class="<?= ($_SESSION['session']) ? 'visible ' : 'invisible '; ?> mr-3">
                            <p>Bonjour&nbsp;<strong><em><?= $_SESSION['current_Pseudo']; ?></em></strong></p>
                        </li>
                        <li>
                            <img src="/img/profil_pictures/<?= ($_SESSION['session']) ? $_SESSION['current_Avatar'] : 'avatar_default.png '; ?>" alt="Avatar default" class="avatar-circle">
                        </li>
                        <li class="<?=($_SESSION['session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                            <a class="my-2 my-sm-0 ml-1" href="/logout.php"><img src="/img/switch-off.png" alt="Logout" class="logout-button"></a>
                        </li>
                    </ul> 
            </span>
        </div>
    </nav>
</header>
<!-- /affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<!--Main Navigation-->