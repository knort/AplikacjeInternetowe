<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();
  
  // Include header
  if ($App->checkAdminSession() == false)
  {
    $App->redirect('login.php');
  }

  // Clear variables
  $food_id = $App->clearText(@$_GET['fid']);
  $category_id = $App->clearText(@$_GET['cid']);

  // Check if cid is not empty
  if (empty($food_id))
  {
    $App->redirect('food-list.php?cid='.$category_id);
  }

  // Prepare SQL statment
  $statment = 'DELETE FROM food WHERE food_id = '.$food_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  $App->redirect('food-list.php?cid='.$category_id);
?>
