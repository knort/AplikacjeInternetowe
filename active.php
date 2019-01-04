<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();

  // Set application language
  $App->setLanguage(@$_GET['lang']);

  // Include header
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header.html');

  // Get activation token
  $token = $App->clearText($_GET['token']);

  // Prepare SQL statment
  $statment = 'SELECT token_email FROM email_tokens WHERE token_value = "'.$token.'"';

  // Execute SQL statment
  $result = $DatabaseManager->query($statment) or die ($DatabaseManager->error);

  // Check if token exists in database
  if ($result->num_rows > 0)
  {
    $result = $result->fetch_assoc();

    $statment = 'UPDATE users SET user_account_status = 1 WHERE user_account_status = 0 AND user_email = "'.$result['token_email'].'"';

    $DatabaseManager->query($statment) or die ($DatabaseManager->error);

    if ($App->getLanguage() == 'pl')
    {
      echo '<div class="message message-success">Twoje konto zostało pomyślnie aktywowane! Możesz teraz się zalogowac.</div>';
    }
    else
    {
      echo '<div class="message message-success">Your account has been activated. You can sign in now.</div>';
    }
  }
  else
  {
    if ($App->getLanguage() == 'pl')
    {
      echo '<div class="message message-error">Niepoprawny token aktywacyjny.</div>';
    }
    else
    {
      echo '<div class="message message-error">Invalid token</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
