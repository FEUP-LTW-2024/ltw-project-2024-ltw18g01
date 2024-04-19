<?php
require_once "config.php";

//Define variables that we will use
$username=$password=$confirm_password="";
$username_err=$password_err=$confirm_password_err="";

//Processing form data when form is submitted
if($__SERVER["REQUEST_METHOD"]=="POST"){

    if(empty(trim($_POST["username"]))){
        $username_err= "Please enter a username.";
    }
    elseif(!preg_match('/[a-zA-Z0-9_]+$/',trim($_POST["username"]))){
        $username_err= "Username can only contain letters, numbers, and underscores.";
    }
    else{
        $sql = "Select id FROM users WHERE USERNAME = ?";

        if($stmt = mysqli_prepare($link,$sql)){

            mysqli_stmt_bind_param($stmt,"s",$param_username);

            $param_username=trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)==1){
                    $username_err="This username is already taken.";
                }
                else{
                    $username= trim($_POST["username"]);
                }
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    }
    elseif(strlen(trim($_POST["password"]))< 6){
        $password_err = "Password must have atleast 6 characters.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    }
    else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users (username, password) VALUES (?,?)";

        if($stmt = mysqli_prepare($link,$sql)){

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if(mysqli_stmt_execute($stmt)){

                header("location: login.php");
            }

            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

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
