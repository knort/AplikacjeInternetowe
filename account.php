<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $DatabaseManager =  new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();

  // Set application language
  $App->setLanguage(@$_GET['lang']);

  // Check user session
  if ($App->checkSession() == false)
  {
    $App->redirect('login.php?lang='.$App->getLanguage());
  }

  // Include header
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header_signed.html');

  // Prepare SQL statment
  $statment = 'SELECT
    user_name,
    user_lastname,
    user_phone,
    user_email,
    user_reg_date
    FROM
        users
    WHERE
      user_id = '.$_SESSION['uid'].'
    ORDER BY
        user_id
    DESC';

  $outupt = '';

  // Execute SQL statment
  if ($result = $DatabaseManager->query($statment))
  {
    if ($result->num_rows == 0)
    {
      $outupt .= '<div class="message message-error">Brak danych do wyświetlenia</div>';
    }
    else
    {
      $outupt .= '<table>';

      $row = $result->fetch_assoc();

      if ($App->getLanguage() == 'pl')
      {
        $outupt .= '<tr><td>Imię</td><td>'.$row['user_name'].'</td></tr>
               <tr><td>Nazwisko</td><td>'.$row['user_lastname'].'</td></tr>
               <tr><td>Telefon</td><td>'.$row['user_phone'].'</td></tr>
               <tr><td>Email</td><td>'.$row['user_email'].'</td></tr>
               <tr><td>Data rejestracji</td><td>'.$row['user_reg_date'].'</td></tr>';
      }
      else
      {
        $outupt .= '<tr><td>Name</td><td>'.$row['user_name'].'</td></tr>
               <tr><td>Lastname</td><td>'.$row['user_lastname'].'</td></tr>
               <tr><td>Phone</td><td>'.$row['user_phone'].'</td></tr>
               <tr><td>Email</td><td>'.$row['user_email'].'</td></tr>
               <tr><td>Registration date</td><td>'.$row['user_reg_date'].'</td></tr>';
      }

      $outupt .= '</table>';
    }
  }
  else
  {
    $outupt = '<div class="message message-error">'.$DatabaseManager->error.'</div>';
  }

  // Include page content
  $FileManager->loadTemplate('templates/'.$App->getLanguage().'/account.html');
  $FileManager->prepareTemplate('{data}', $outupt);
  $FileManager->render();

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
