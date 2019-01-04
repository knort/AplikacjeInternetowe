<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/DatabaseManager.php';
  include_once '../lib/MailManager.php';

  // Create instance of each class
  $App             = new App();
  $MailManager     = new MailManager();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();

  // Include header
  if ($App->checkAdminSession() == false)
  {
    $App->redirect('login.php');
  }

  // Clear variables
  $table_id = $App->clearText(@$_GET['tid']);

  // Check if cid is not empty
  if (empty($table_id))
  {
    $App->redirect('table-list.php');
  }

  // Prepare SQL statment
  $statment = 'DELETE FROM tables WHERE table_id = '.$table_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  // Prepare SQL statment
  $statment = 'DELETE FROM reservations WHERE reservation_table_id = '.$table_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  $App->redirect('table-list.php');
?>
