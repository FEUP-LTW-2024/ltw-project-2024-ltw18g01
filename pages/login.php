<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
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
                <p id="First-text">Login to Techie</p>
                <p id="Second-text">New to Techie? Register your account <a href="register.php" class="register_button">here!</a></p>
                <?php if(!empty($login_err)){echo '<div class="alert alert-danger">' . $login_err . '</div>';}?>
            </div>
        </section>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <label id="username">Username</label>
            <div class="form_rectangle">
                <input id="input-login" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>

            <label id="username">Password</label>
            <div class="form_rectangle">
                <input id="input-login" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <br><br>
            <div class="form_button" id="form button-text">
                <a id="form-button-hover" >    
                    <input type="submit" class="btn btn-primary" value="Login">
                </a>
            </div>  
        </form>
    </body>
</html>
