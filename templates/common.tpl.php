<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
?>

<?php function drawTopBar(Session $session, $db) { ?>
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
        <a class="active desktop" href="index.php">Home</a>
        <a class="desktop" href="gaming.php">Gaming</a>
        <a class="desktop" href="pcs.php">PCs</a>
        <a class="desktop" href="mobile.php">Mobiles</a>
        <a class="desktop" href="tvs.php">TVs</a>
        <a class="desktop" href="music.php">Music</a>
        <a class="desktop" href="photo_video.php">Photo&Video</a>
        <a class="icon" href="sell.php"><img class="icon" src="/images/plus.png"></a>


        <?php
            if ($session->isLoggedIn()) {
                // If user is logged in, get the URL of their profile picture from db
                $profilePictureRelativePath = $session->getUserProfilePictureUrl();
                $user = User::getUser($db, $session->getId());
        ?>
            <a class="avatar" href="account.php"><img class="avatar" src="<?php echo $user->image_url; ?>" alt="user"></a>
        <?php
        } else {
            // If user is not logged in, use the guest icon
        ?>
            <a class="avatar" href="login.php"><img class="avatar" src="/images/guesticon.png" alt="guest"></a>
        <?php
        }
        ?>
        <div class="mobile-menu">
            <button onclick="toggleDesktopMenu()"> 
                <img src="/images/icon-list.png" alt="Menu-Icon">
            </button>
            <div class="desktop-menu">
                <a class="desktop" href="index.php">Home</a>
                <a class="desktop" href="gaming.php">Gaming</a>
                <a class="desktop" href="pcs.php">PC's</a>
                <a class="desktop" href="mobile.php">Mobiles</a>
                <a class="desktop" href="tvs.php">TV's</a>
                <a class="desktop" href="music.php">Music</a>
            </div>
        </div>
        <div class="categories-navbar">
            <a class="desktop" href="index.php">Home</a>
            <a class="desktop" href="gaming.php">Gaming</a>
            <a class="desktop" href="pcs.php">PC's</a>
            <a class="desktop" href="mobile.php">Mobiles</a>
            <a class="desktop" href="tvs.php">TV's</a>
            <a class="desktop" href="music.php">Music</a>
        </div>
    </header>

<?php } ?>
