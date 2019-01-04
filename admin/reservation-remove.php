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
  $reservation_id = $App->clearText(@$_GET['rid']);

  // Check if cid is not empty
  if (empty($reservation_id))
  {
    $App->redirect('reservation-list.php');
  }

  // Prepare SQL statment
  $statment = 'DELETE FROM reservations WHERE reservation_id = '.$reservation_id;

  // Execute SQL statment
  $DatabaseManager->query($statment);

  $App->redirect('reservation-list.php');
?>
