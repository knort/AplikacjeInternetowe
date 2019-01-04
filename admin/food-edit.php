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

  $food_id = $App->clearText(@$_GET['fid']);
  $category_id = $App->clearText(@$_GET['cid']);

  $statment = 'SELECT food_pl_name, food_eng_name, food_pl_desc, food_eng_desc, food_price FROM food WHERE food_id = '.$food_id;
  $data = $DatabaseManager->query($statment);
  $data = $data->fetch_assoc();

  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->loadTemplate('templates/food-edit.html');
  $FileManager->prepareTemplate('{pl_name}', $data['food_pl_name']);
  $FileManager->prepareTemplate('{eng_name}', $data['food_eng_name']);
  $FileManager->prepareTemplate('{pl_desc}', $data['food_pl_desc']);
  $FileManager->prepareTemplate('{eng_desc}', $data['food_eng_desc']);
  $FileManager->prepareTemplate('{price}', $data['food_price']);

  $FileManager->render();

  // Handle form submit button
  if (isset($_POST['food-edit-submit']))
  {
    // Clear variables
    $Food->setFoodName('pl',  $App->clearText($_POST['pl_name']));
    $Food->setFoodName('eng', $App->clearText($_POST['eng_name']));
    $Food->setFoodDesc('pl',  $App->clearText($_POST['pl_desc']));
    $Food->setFoodDesc('eng', $App->clearText($_POST['eng_desc']));
    $Food->setPrice($App->clearText($_POST['price']));

    // Prepare SQL statment
    $statment = 'UPDATE food SET food_pl_name = "'.$Food->getFoodName('pl').'", food_eng_name = "'.$Food->getFoodName('eng').'", food_pl_desc = "'.$Food->getFoodDesc('pl').'", food_eng_desc = "'.$Food->getFoodDesc('eng').'", food_price = '.$Food->getPrice().' WHERE food_id = '.$food_id;

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      echo '<div class="message message-success">Pomyślnie Zapisano danie.</div>';
      $App->redirect('food-list.php?cid='.$category_id);
    }
    else
    {
      echo '<div class="message message-error">'.$DatabaseManager->error.'</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
