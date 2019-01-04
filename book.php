<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/DatabaseManager.php';
  include_once 'lib/MailManager.php';
  include_once 'lib/Reservation.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $DatabaseManager = new DatabaseManager();
  $MailManager     = new MailManager();
  $Reservation     = new Reservation();
  $DatabaseManager = $DatabaseManager->connect();

  // Set application language
  $App->setLanguage(@$_GET['lang']);

  // Check user session
  if ($App->checkSession() == false)
  {
    $App->redirect('login.php?lang='.$App->getLanguage());
  }

  $statment = 'SELECT table_id, table_number, table_count FROM tables ORDER BY table_number ASC';
  $output = '';

  // Execute SQL statment
  if ($result = $DatabaseManager->query($statment))
  {
    while ($row = $result->fetch_assoc())
    {
      if ($App->getLanguage() == 'pl')
      {
        $output .= '<option value="'.$row['table_id'].'">Stolik numer '.$row['table_number'].' ('.$row['table_count'].' osobowy)</option>';
      }
      else
      {
        $output .= '<option value="'.$row['table_id'].'">Table number '.$row['table_number'].' ('.$row['table_count'].' person)</option>';
      }
    }
  }
  else
  {
    echo $DatabaseManager->error;
  }

  // Include header
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header_signed.html');

  // Include page content
  $FileManager->loadTemplate('templates/'.$App->getLanguage().'/book.html');
  $FileManager->prepareTemplate('{table_list}', $output);
  $FileManager->render();

  if (isset($_POST['book-submit']))
  {
    $date  = date('Y-m-d', strtotime($App->clearText($_POST['date'])));
    $start = date('H:i', strtotime($App->clearText($_POST['start'])));
    $end   = date('H:i', strtotime($App->clearText($_POST['end'])));
    $table = $App->clearText($_POST['table']);

    $now = date('Y-m-d');
    $flag = true;

    if ($date == $now)
    {
      if ($start < date('H:i'))
      {
        if ($App->getLanguage() == 'pl')
        {
          echo '<div class="message message-error">Podaj prawidłowy zakres czasu.</div>';
        }
        else
        {
          echo '<div class="message message-error">Type correct date interval.</div>';
        }
        $flag = false;
      }
    }

    if ($date < $now && $flag == true)
    {
      if ($App->getLanguage() == 'pl')
      {
        echo '<div class="message message-error">Podaj prawidłową datę.</div>';
      }
      else
      {
        echo '<div class="message message-error">Type correct date.</div>';
      }
      $flag = false;
    }

    if ($start > $end && $flag == true)
    {
      if ($App->getLanguage() == 'pl')
      {
        echo '<div class="message message-error">Podaj prawidłowy zakres czasu.</div>';
      }
      else
      {
        echo '<div class="message message-error">Type correct time interval.</div>';
      }
      $flag = false;
    }

    if ($flag == true)
    {
      $Reservation->setDate($date);
      $Reservation->setStart($start);
      $Reservation->setEnd($end);
      $Reservation->setTable($table);

      $statment = 'INSERT INTO reservations VALUES (null, "'.$Reservation->getDate().'", "'.$Reservation->getStart().'", "'.$Reservation->getEnd().'", '.$Reservation->getTable().', '.$_SESSION['uid'].')';

      if ($DatabaseManager->query($statment))
      {
        if ($App->getLanguage() == 'pl')
        {
          echo '<div class="message message-success">Rezerwacja przebiegła pomyślnie. Sprawdź szczegóły na Twoim profilu.</div>';
        }
        else
        {
          echo '<div class="message message-success">Reservation has been created successfully. Check details on your profile.</div>';
        }

        $statment = 'SELECT user_email FROM users WHERE user_id = '.$_SESSION['uid'];

        $result = $DatabaseManager->query($statment);
        $result = $result->fetch_assoc();

        $MailManager->reservationMail($result['user_email'], $Reservation->getTable(), $Reservation->getDate(), $Reservation->getStart(), $Reservation->getEnd());
      }
      else
      {
        echo '<div class="message message-error">'.$DatabaseManager->error.'</div>';
      }
    }
  }

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
