<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();
?>

<?php
function drawTopBar(Session $session, $db)
{
    $pages = array(
        'Home' => 'index.php',
        'Gaming' => 'gaming.php',
        'PCs' => 'pcs.php',
        'Mobiles' => 'mobile.php',
        'TVs' => 'tvs.php',
        'Music' => 'music.php',
        'Photo&Video' => 'photo_video.php'
    );

    $currentPage = basename($_SERVER['PHP_SELF']);
?>

    <!DOCTYPE html>
    <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
            <title>Techie</title>
            <link rel="stylesheet" href="/css/index_style.css">
        </head>

        <body>
            <header class="navbar" id="navbar-text">
                <a class="logo" href="index.php"><img src="/images/logo/logo_techie.png" alt="logo"></a>

                <?php
                foreach ($pages as $page => $url) {

                    $activeClass = ($currentPage == $url) ? 'active' : '';

                    echo '<a class="desktop ' . $activeClass . '" href="' . $url . '">' . $page . '</a>';
                }
                ?>
                 <a class="icon" href="sell.php"><img class="icon" src="/images/plus.png"></a>
                <?php
                if ($session->isLoggedIn()) {

                    $profilePictureRelativePath = $session->getUserProfilePictureUrl();
                    $user = User::getUser($db, $session->getId());
                ?>
                    <a class="avatar" href="account.php"><img class="avatar" src="<?php echo $user->image_url; ?>" alt="user"></a>
                <?php
                } else {
                ?>
                    <a class="avatar" href="login.php"><img class="avatar" src="/images/others/guesticon.png" alt="guest"></a>
                <?php
                }
                ?>

                <div class="mobile-menu">
                    <button onclick="toggleDesktopMenu()">
                        <img src="/images/others/icon-list.png" alt="Menu-Icon">
                    </button>
                    <div class="desktop-menu">
                        <?php foreach ($pages as $page => $url) {
                            echo '<a class="desktop" href="' . $url . '">' . $page . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="categories-navbar">
                    <?php foreach ($pages as $page => $url) {
                        echo '<a class="desktop" href="' . $url . '">' . $page . '</a>';
                    }
                    ?>
                </div>
            </header>
        </body>
    </html>
<?php } ?>
