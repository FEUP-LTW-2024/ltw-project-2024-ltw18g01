<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/item.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
  if (!$session->isLoggedIn()) {
    header('Location: /pages/login.php');
    exit;
  }
  $itemId = (int)$_GET['itemId']; 
  $item = Item::getItem($db,$itemId);
  $seller = User::getUser($db,$item -> seller);

  if ($item->sold == true) {
    header('Location: /pages/index.php');
    exit;
  }
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
        <link rel="stylesheet" href="/css/item.css"> 
        <link rel="stylesheet" href="/css/account.css"> 
        <link rel="stylesheet" href="/css/login_reg.css">
        <link rel="stylesheet" href="/css/payment.css">

        <script src="/js/limit_input.js"></script>
   </head>
    <body>
        <?php
         drawTopBar($session, $db);
        ?>      
        <br>

        <?php
          $sentences = [
              "Coldplay once sang about this, 'The Hardest Part'.",
              "They say money talks, but mine just says goodbye.",
              "Time for all the burocracy.",
              "Debit or credit?",
              "Do you also need a bag?",
              "Thank you for supporting Techie - made with <3 in Portugal"
          ];
          $randomIndex = rand(0, count($sentences) - 1);
          $sentence = $sentences[$randomIndex];
        ?>


        <p class="user-profile"><?php echo "Proceed to payment of " . $item->title?></p>
        <p class="catch-phrase"><?php echo $sentence; ?></p>
        <br>
        <p class="catch-phrase"><?php echo "Buying item from @" . $seller->username; ?></p>
        <br>
        <p class="catch-phrase"><?php echo "Total cost: " . $item->price + $item->shippingCost . "€ (includes shipping cost of " . $item->shippingCost . "€)"; ?></p>
        <section id="payment-form">
          <form action="../actions/payment_action.php">
            <p id="username">Credit or debit card number</p>
            <div class="form_rectangle">
              <span id="card-icon" class="card-icon default-icon"></span>
              <input id="input-login" type="number" oninput="limitInputLength(this, 16)">
            </div>
            <br>
            <p id="username">Expiration date</p>
            <div class="form_rectangle">
              <input id="input-login" type="date">
            </div>
            <br>
            <p id="username">CVV</p>
            <div class="form_rectangle">
              <input id="input-login" type="number" oninput="limitInputLength(this, 3)">
            </div>
            <br>
            <br>
            <br>
            <p class="catch-phrase">Using the address from your profile data.</p>
            <br>
            <p class="catch-phrase">If you wish to change your shipping address, please edit your profile.</p>
            <input type="hidden" name="itemId" value="<?php echo $itemId; ?>"; ?>">
            <button type="submit">Pay</button>
          </form>
        </section>
    </body>
</html>