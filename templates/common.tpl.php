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
            <link rel="stylesheet" href="/css/listings.css">
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
                 <a class="icon" href="sell.php"><img class="icon" src="/images/others/plus.png"></a>
                 <a class="icon" href="chat.php"><img class="icon" src="/images/others/communications.png"></a>

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

<?php
function drawMyItems($db, $userId) {
    $items = Item::getItemsByUser($db, $userId);

    if ($items) {
        foreach ($items as $item) {
            ?>
            <a href="/../pages/item.php?itemId=<?=$item['itemId']?>">
                <div id="item-card">
                    <img src="<?php echo $item['image_url']; ?>"></img>
                    <div id="item-things">
                        <p id="item-title"><?php echo $item['title']; ?></p>
                        <br>
                        <?php if (isset($item['status'])) { ?>
                            <p id="item-status"><?php echo $item['status']; ?></p>
                            <br>
                        <?php } ?>
                        <p id="item-price"><?php echo $item['price']; ?>€</p>
                    </div>
                    <div id="item-user-status">
                        <form method="POST" action="../actions/shipping_label_action.php">
                            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                            <input type="hidden" name="title" value="<?php echo $item['title']; ?>">
                            <button>Ship</button>
                        </form>
                        <img id="printer-img" src="/../images/others/printer.png">
                        <?php if (isset($item['user_status'])) { ?>
                            <p id="item-user-status-text"><?php echo $item['user_status']; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </a>
            <br><br>
            <?php
        }
    } else {
        echo 'No items found.';
    }
}
?>

<?php
function drawItems($item, $seller) {
    echo '
    <div class="background">
        <div class="grid-container">
            <div class="item-picture">
                <img src="' . $item->image_url . '">
            </div>
            <div class="user-data">
                <img class="user-image" src="' . $seller->image_url . '">
                <div class="sales-info">
                    <div class="user-info">
                        <p id="username">' . $seller->username . '</p>
                        <p id="sales-history">' . $seller->salesNumber . ' sales completed</p>
                    </div>
                    <img class="star" src="/images/others/starbox.png">
                    <p id="star-score">' . $seller->userRating . '</p>
                    <div class="button-message-seller"> 
                        <p id="button-text">Message seller</p>
                    </div>
                </div>
            </div>
            <div class="item-info"> 
                <p id="item-name">' . $item->title . '</p>
                <p id="item-description">' . $item->description . '</p>
                <p id="item-price">' . $item->price . ' €</p>
                <p id="shipping-price">Estimated shipping cost: ' . $item->shippingCost . ' €</p>
                <div class="containers">
                    <div class="button-buy-now"> 
                        <p id="button-text">Buy now</p>
                    </div>
                    <div class="button-request-new-price"> 
                        <p id="button-text">Request new price</p>
                    </div>
                </div>    
            </div>
        </div>
    </div>';
}
?>
