<!--Main Navigation-->
<!-- affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<header>
    <!-- si l utilisateur n est pas logger color : blue, sinon  color : green  -->   
    <nav class="navbar navbar-expand-md navbar-dark static-top <?=($_SESSION['session']) ?  'bg-success' : 'bg-primary'; ?>">
        <a class="navbar-brand" href="/index.php">
            <img src="/img/logo/messenger_logo_black_150x151.png" alt="CCI Messenger logo">
        </a>
        <div class="container">
            <div class="d-flex flex-column">
                <h1 class="align-self-center"><strong>CCI MESSENGER</strong></h1>
                <div>
                    <ul class="navbar-nav <?=($_SESSION['session']) ? 'visible ' : 'invisible ' ?>">
                        <li class="nav-item active">
                            <a class="nav-link" href="/chat_list.php">Messagerie</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/contacts_list.php">Contacts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container align-self-end">
            <div class="col-md-auto ml-auto <?= ($_SESSION['session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                <h2 class="text-muted"><em>Bonjour</em><em>&nbsp;<strong><em><?= $_SESSION['current_Pseudo']; ?></em></strong><h2>
            </div>
            <div class="d-flex ml-2">
                <div>
                    <img src="/img/profil_pictures/<?= ($_SESSION['session']) ? $_SESSION['current_Avatar'] : 'avatar_default.png '; ?>" alt="Avatar default" class="avatar-circle">
                </div>
                    <div class="<?=($_SESSION['session']) ? 'visible ' : 'invisible '; ?> align-self-end">
                        <a class="my-2 my-sm-0 ml-1" href="/logout.php"><img src="/img/switch-off.png" alt="Logout" class="logout-button"></a>
                    </div>
            </div>
        </div>
    </nav>
</header>
<!-- /affichage du pseudo du membre connecte et un bouton pour la deconnexion vers la page index.php -->
<!--Main Navigation-->