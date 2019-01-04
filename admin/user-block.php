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
  $user_id = $App->clearText(@$_GET['uid']);

  // Check if cid is not empty
  if (empty($user_id))
  {
    $App->redirect('user-list.php');
  }

  // Prepare SQL statment
  $statment = 'UPDATE users SET user_account_status = 2 WHERE user_id = '.$user_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  $App->redirect('user-list.php');
?>
