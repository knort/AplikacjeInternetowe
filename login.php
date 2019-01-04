<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/HashManager.php';
  include_once 'lib/MailManager.php';
  include_once 'lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $HashManager     = new HashManager();
  $MailManager     = new MailManager();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();
  
  // Set application language
  $App->setLanguage(@$_GET['lang']);

  // Check if user is already signed up
  if ($App->checkSession() == true)
  {
    $App->redirect('index.php?lang='.$App->getLanguage());
  }

  // Include header
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header.html');

  // Include page content
  $FileManager->includeFile('templates/'.$App->getLanguage().'/login.html');

  // Handle form submit button
  if (isset($_POST['login-submit']))
  {
    // Clear variables
    $email    = $App->clearText($_POST['email']);
    $password = $App->clearText($_POST['password']);

    // Prepare SQL statment
    $statment = 'SELECT user_id, user_account_status FROM users WHERE user_email = "'.$email.'" and user_password = "'.$HashManager->passwordHash($password).'"';

    // Execute SQL statment
    $result = $DatabaseManager->query($statment) or die ($DatabaseManager->error);

    // Check if user exist in database
    if ($result->num_rows == 0)
    {
      // Return message about incorrect data
      if ($App->getLanguage() == 'pl')
      {
        echo '<div class="message message-error">Niepoprawny email lub hasło.</div>';
      }
      else
      {
        echo '<div class="message message-error">Incorrect email or password.</div>';
      }
    }
    else
    {
      // Get user ID and create a session
      $result = $result->fetch_assoc();

      // Check if user account has been activated

      if ($result['user_account_status'] == 1)
      {
        $MailManager->loginMail($email);
        $App->createSession($result['user_id']);
        $App->redirect('index.php?lang='.$App->getLanguage());
      }
      else
      {
        if ($App->getLanguage() == 'pl')
        {
          echo '<div class="message message-error">Twoje konto nie zostało jeszcze aktywowane lub zostało zablokowane.</div>';
        }
        else
        {
          echo '<div class="message message-error">Your account has not been activated yet or account is banned.</div>';
        }
      }
    }
  }

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
