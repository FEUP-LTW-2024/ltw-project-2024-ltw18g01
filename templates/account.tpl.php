<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../db/user.class.php');

  require_once(__DIR__ . '/../sessions/session.php');
?>

<?php 
function drawEditProfile(User $user, PDO $db) {
?>  
    <form action="../actions/edit_profile_action.php" method="post" class="profile">
                <p id="username">First name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="firstName" value="<?=$user->firstName?>">
                </div>

                <p id="username">Last name</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="lastName" value="<?=$user->lastName?>">
                </div>

                <p id="username">Username</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="username" value="<?=$user->username?>">
                </div>

                <p id="username">Address</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="address" value="<?=$user->address?>">
                </div>

                <p id="username">City</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="city" value="<?=$user->city?>">
                </div>

                <p id="username">Country</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="country" value="<?=$user->country?>">
                </div>

                <p id="username">Postal code</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="postalCode" value="<?=$user->postalCode?>">
                </div>

                <p id="username">Phone number</p>
                <div class="form_rectangle">
                    <input id="input-login" type="text" name="phone" value="<?=$user->phone?>">
                </div>
                
                <button type="submit"  class="form_rectangle" id="form_button">Save</button>
            </form>
<?php 
} 
?>