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
  $FileManager->includeFile('templates/'.$App->getLanguage().'/forgot.html');

  // Handle form submit button
  if (isset($_POST['forgot-submit']))
  {
    // Clear variables
    $email    = $App->clearText($_POST['email']);

    $statment = 'SELECT 1 FROM users WHERE user_email = "'.$email.'"';

    if ($result = $DatabaseManager->query($statment))
    {
      if ($result->num_rows > 0)
      {
        $password = $HashManager->createPassword();

        $MailManager->forgotMail($email, $password);

        $password = $HashManager->passwordHash($password);

        $statment = 'UPDATE users SET user_password = "'.$password.'" WHERE user_email = "'.$email.'"';

        if ($result = $DatabaseManager->query($statment))
        {
          if ($App->getLanguage() == 'pl')
          {
            echo '<div class="message message-success">Sprawdź swoją skrzynke pocztową.</div>';
          }
          else
          {
            echo '<div class="message message-success">Check your email inbox</div>';
          }
        }
        else
        {
          $DatabaseManager->error;
        }
      }
      else
      {
        if ($App->getLanguage() == 'pl')
        {
          echo '<div class="message message-error">Adres email nie istnieje w naszej bazie danych.</div>';
        }
        else
        {
          echo '<div class="message message-error">Email address does not exists in our database.</div>';
        }
      }
    }
    else
    {
      $DatabaseManager->error;
    }
  }

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
