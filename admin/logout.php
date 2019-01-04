<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';

  // Create instance of each class
  $App         = new App();
  $FileManager = new FileManager();

  // Logout user
  $App->sessionDestroy();
  $App->redirect('login.php');
?>
