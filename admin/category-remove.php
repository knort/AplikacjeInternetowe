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
  $category_id = $App->clearText(@$_GET['cid']);

  // Check if cid is not empty
  if (empty($category_id))
  {
    $App->redirect('category-list.php');
  }

  // Prepare SQL statment
  $statment = 'DELETE FROM categories WHERE category_id = '.$category_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  // Prepare SQL statment
  $statment = 'DELETE FROM food WHERE food_category_id = '.$category_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  $App->redirect('category-list.php');
?>
