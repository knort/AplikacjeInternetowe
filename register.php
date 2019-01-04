<?php  session_start();

  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/DatabaseManager.php';
  include_once 'lib/HashManager.php';
  include_once 'lib/MailManager.php';

  $App = new App();
  $FileManager = new FileManager();

  $App->setLanguage(@$_GET['lang']);
  
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header.html');
  $FileManager->includeFile('templates/'.$App->getLanguage().'/register.html');

  if (isset($_POST['register-submit']))
  {
    $DatabaseManager = new DatabaseManager();
    $DatabaseManager = $DatabaseManager->connect();

    $HashManager = new HashManager();
    $MailManager = new MailManager();

    $name       = $App->clearText($_POST['name']);
    $lastname   = $App->clearText($_POST['lastname']);
    $phone      = $App->clearText($_POST['phone']);
    $email      = $App->clearText($_POST['email']);
    $password   = $App->clearText($_POST['password']);
    $r_password = $App->clearText($_POST['r_password']);

    $statment = 'SELECT 1 FROM users WHERE user_email = "'.$email.'"';

    $result = $DatabaseManager->query($statment) or die ($DatabaseManager->error);

    if ($result->num_rows == 0)
    {
      $statment = 'INSERT INTO users (
        user_name,
        user_lastname,
        user_phone,
        user_email,
        user_password,
        user_reg_date,
        user_account_status
      ) VALUES (
        "'.$name.'",
        "'.$lastname.'",
        "'.$phone.'",
        "'.$email.'",
        "'.$HashManager->passwordHash($password).'",
        "'.date('Y-m-d H:i:s').'",
        0
      )';

      $DatabaseManager->query($statment) or die ($DatabaseManager->error);

      $token = $HashManager->tokenHash();

      $statment = 'INSERT INTO email_tokens (
        token_email,
        token_value
      ) VALUES (
        "'.$email.'",
        "'.$token.'"
      )';

      $DatabaseManager->query($statment) or die ($DatabaseManager->error);

      $MailManager->registrationMail($email, $name, $token);

      if ($App->getLanguage() == 'pl')
      {
        echo '<div class="message message-success">Rejestracja przebiegła pomyślnie. Sprawdź swoja skrzynke pocztową w celu aktywacji konta.</div>';
      }
      else
      {
        echo '<div class="message message-success">Your account has been successfully created. Check your email to active an account.</div>';
      }
    }
    else
    {
      if ($App->getLanguage() == 'pl')
      {
        echo '<div class="message message-error">Podany adres email istnieje w naszej bazie danych.</div>';
      }
      else
      {
        echo '<div class="message message-error">Email already exists in our database.</div>';
      }
    }
  }

  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
