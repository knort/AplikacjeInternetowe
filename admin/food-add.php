<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';
  include_once '../lib/Food.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $Food            = new Food();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();
  
  // Include header
  if ($App->checkAdminSession() == false)
  {
    $App->redirect('login.php');
  }

  $category_id = $App->clearText(@$_GET['cid']);

  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->includeFile('templates/food-add.html');

  // Handle form submit button
  if (isset($_POST['food-add-submit']))
  {
    // Clear variables
    $Food->setFoodName('pl',  $App->clearText($_POST['pl_name']));
    $Food->setFoodName('eng', $App->clearText($_POST['eng_name']));
    $Food->setFoodDesc('pl',  $App->clearText($_POST['pl_desc']));
    $Food->setFoodDesc('eng', $App->clearText($_POST['eng_desc']));
    $Food->setPrice( $App->clearText($_POST['price']));

    // Prepare SQL statment
    $statment = 'INSERT INTO food (food_pl_name, food_eng_name, food_pl_desc, food_eng_desc, food_price, food_category_id)
    VALUES (
      "'.$Food->getFoodName('pl').'", "'.$Food->getFoodName('eng').'",
      "'.$Food->getFoodDesc('pl').'", "'.$Food->getFoodDesc('eng').'",
      '.$Food->getPrice().', '.$category_id.'
    )';

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      echo '<div class="message message-success">Pomyślnie dodano danie.</div>';
    }
    else
    {
      echo '<div class="message message-error">'.$DatabaseManager->error.'</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
