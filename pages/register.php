<!DOCTYPE html>
<html>
   <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        
        <title>Techie</title>

        <link rel="stylesheet" href="/css/index_style.css">
        <link rel="stylesheet" href="/css/login_reg.css"> 
   </head>
    <body>
        <header  id="navbar-text" class="navbar">
            <img class="logo" src="/images/logo/logo_techie.png" alt="logo" /> 
            <a class="active" href="index.php">Home</a>
            <a href="gaming.php">Gaming</a>
            <a href="pcs.php">PC's</a>
            <a href="mobile.php">Mobiles</a>
            <a href="tvs.php">TV's</a>
            <a href="music.php">Music</a>
            <a href="photo_video.php">Photo&Video</a>
            <a class="avatar" href="login.php"> <img class="avatar" src="/images/guesticon.png" alt="guest"/></a>
        </header>

        <!-- Section of quotes-->
        <section>
            <div class="login-text">
                <p id="First-text">Register to Techie</p>
                <p id="Second-text">Already have an account? Login <a href="login.php" class="register_button">here!</a></p>
            </div>
        </section>

        <section>
            <p id="username">Name</p>
            <div class="form_rectangle">
                <input id="input-login" type="text" name="username" required>
            </div>
            <p id="username">Username</p>
            <div class="form_rectangle">
                <input id="input-login" type="text" name="username" required>
            </div>
            <p id="username">Password</p>
            <div class="form_rectangle">
                <input id="input-login" type="password" name="password" required>
            </div>
            <p id="username">Confirm password</p>
            <div class="form_rectangle">
                <input id="input-login" type="password" name="password" required>
            </div>
            <br><br>
            <div class="form_button">
                <a id="form-button-hover" href="index.php">    
                    <p id="form-button-text">Register</p>
                </a>
            </div>  
        </section>
    </body>
</html>