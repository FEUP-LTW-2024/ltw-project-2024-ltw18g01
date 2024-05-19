<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) die(header('Location: /pages/login.php'));

  require_once(__DIR__ . '/../db/connection.db.php');
  require_once(__DIR__ . '/../db/user.class.php');
  require_once(__DIR__ . '/../db/category.class.php');
  require_once(__DIR__ . '/../db/subcategory.class.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = databaseConnect();
?>


<?php
if(isset($_POST['categoryId'])){
    $categoryId = (int)$_POST['categoryId'];
    $subcategories = Subcategory::getSubcategoriesFromCategory($db, $categoryId);
    if($subcategories){
        echo '<option value="">Select a subcategory</option>';
        foreach($subcategories as $subcategory){
            echo '<option value="'.$subcategory['subcategoryId'].'">'.$subcategory['name'].'</option>';
        }
    }else{
        echo '<option value="">No subcategories found</option>';
    }
}
?>
