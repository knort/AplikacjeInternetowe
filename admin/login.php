<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';
  include_once '../lib/HashManager.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $HashManager     = new HashManager();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();

  // Check if user is already signed up
  if ($App->checkAdminSession() == true)
  {
    $App->redirect('index.php');
  }

  // Include page content
  $FileManager->includeFile('templates/login.html');

  // Handle form submit button
  if (isset($_POST['login-submit']))
  {
    // Clear variables
    $email    = $App->clearText($_POST['email']);
    $password = $App->clearText($_POST['password']);

    // Prepare SQL statment
    $statment = 'SELECT admin_id FROM admins WHERE admin_email = "'.$email.'" and admin_password = "'.$HashManager->passwordHash($password).'"';

    // Execute SQL statment
    $result = $DatabaseManager->query($statment) or die ($DatabaseManager->error);

    // Check if user exist in database
    if ($result->num_rows == 0)
    {
      echo '<div class="message message-error">Niepoprawny email lub hasło.</div>';
    }
    else
    {
      // Get user ID and create a session
      $result = $result->fetch_assoc();

      $App->createAdminSession($result['admin_id']);
      $App->redirect('index.php');
    }
  }
?>
