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
        'Gaming' => 'category.php?category=0&subcategory=all',
        'PCs' => 'category.php?category=1&subcategory=all',
        'Mobiles' => 'category.php?category=2&subcategory=all',
        'TVs' => 'category.php?category=3&subcategory=all',
        'Music' => 'category.php?category=4&subcategory=all',
        'Photo&Video' => 'category.php?category=5&subcategory=all'
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
                 <a class="icon" id="search" href="search.php"><img class="icon" src="/images/others/search.svg"></a>
                 <a class="icon" href="sell.php"><img class="icon" src="/images/others/plus.png"></a>
                 <a class="icon" href="chat.php"><img class="icon" src="/images/others/communications.png"></a>
                 <a class="icon" href="wishlist.php"><img class="icon" src="/images/others/heart.png"></a>

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
                        <?php
                        if ($item['sold'] == true) { ?>
                        <form method="POST" action="../actions/shipping_label_action.php">
                            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                            <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                            <button id="ship-button"></button>
                        </form>
                        <?php if (isset($item['sold'])) { ?>
                            <p id="item-user-status-text">SOLD</p>
                        <?php } ?>
                        <?php } else { ?>
                            <button class="edit-button" id="edit-button-<?php echo $item['itemId']; ?>"></button>
                            <p id="item-user-status-text">EDIT</p>
                            <script>
                                document.getElementById("edit-button-<?php echo $item['itemId']; ?>").addEventListener("click", function(event) {
                                    event.preventDefault();
                                    window.location.href = "/../pages/edit_item.php?itemId=<?php echo $item['itemId']; ?>";
                                });
                            </script>
                        <?php } ?>
                    </div>
                </div>
            </a>
            <br><br>
            <?php
        }
    } else {
        echo '<p id="no-items">No items found :v </p>';
    }
}
?>

<?php
function drawItems($item, $seller, $itemId, $isAdmin, $curUser) { ?>
    <div class="background">
        <div class="grid-container">
            <div class="item-picture">
                <img src="<?php echo $item->image_url; ?>">
            </div>
            <div class="user-data">
                <img class="user-image" src="<?php echo $seller->image_url; ?>">
                <div class="sales-info">
                    <div class="user-info">
                        <p id="username"><?php echo $seller->username; ?></p>
                        <p id="sales-history"><?php echo $seller->salesNumber . ' sales completed'; ?></p>
                    </div>
                    <img class="star" src="/images/others/starbox.png">
                    <p id="star-score"><?php echo $seller->userRating; ?></p>
                    
                    <?php
                    if ($seller->userId != $curUser) { ?>
                    <div class="button-message-seller"> 
                    <a href="javascript:void(0);" onclick="sendMessageToSeller(<?php echo $seller->userId; ?>, '<?php echo $item->title; ?>', '<?php echo $item->image_url; ?>', <?php echo $itemId; ?>)"><p id="button-text">Message seller</p></a>
                    </div>
                    <?php } ?>
        
                </div>
            </div>
            <div class="item-info"> 
                <p id="item-name"><?php echo $item->title; ?></p>
                <p id="item-description"><?php echo $item->description; ?></p>
                <p id="item-state">The condition is <span id="state-lowercase"> <?php echo $item->state;?> </span></p>
                <?php
                if ($item->negotiable == true) { ?>
                    <p id="item-price"><?php echo $item->price . ' € (negotiable)'; ?></p>
                <?php } else { ?>
                    <p id="item-price"><?php echo $item->price . ' €'; ?></p>
                <?php } ?>
                <p id="shipping-price"><?php echo 'Estimated shipping cost: ' . $item->shippingCost . ' €';?></p>
                <div class="containers">
                <?php
                if ($item->sold == false && $seller->userId != $curUser) { ?>
                    <div class="button-buy-now"> 
                    <a href="<?php echo '/../pages/payment.php?itemId=' . $itemId; ?>">
                            <p id="button-text">Buy now</p>
                    </a>
                    </div>
                <?php } else if ($seller->userId != $curUser) { ?>
                    <div class="button-buy-now"> 
                        <p id="button-text">SOLD</p>
                    </div>
                <?php } ?>
                    
                    <?php
                    if ($seller->userId != $curUser) { ?>

                    <div class="button-request-new-price"> 
                        <p id="button-text">Request new price</p>
                    </div>

                    <?php }  ?>
                    
                    <?php
                    if ($isAdmin || $seller->userId == $curUser) { ?>
                        <div class="button-delete-item" id="submitForm"> 
                            <p id="button-text">Delete item</p>
                            <form action="/../actions/delete_item_action.php" method="post" id="deleteForm">
                            <input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('submitForm').addEventListener('click', function() {
        document.getElementById('deleteForm').submit();
    });

    function sendMessageToSeller(receiverId, itemTitle, itemImageUrl, itemId) {
        const messageText = `
            Hello! I am interested in your item! 
            <br>
            <img src="${itemImageUrl}" alt="${itemTitle}" style="width: 5em; height: 5em;">
        `;

        fetch('/actions/sendmessagetoseller_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                receiverId: receiverId,
                itemTitle: itemTitle,
                itemImageUrl: itemImageUrl,
                itemId: itemId,
                message: messageText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'chat.php?receiverId=' + receiverId + '&itemId=' + itemId;
            } else {
                alert('Failed to send message.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending message.');
        });
    }
</script>
<?php }
?>
