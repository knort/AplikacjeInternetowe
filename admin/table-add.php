<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';
  include_once '../lib/Table.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $Table           = new Table();
  $DatabaseManager = new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();
  
  // Include header
  if ($App->checkAdminSession() == false)
  {
    $App->redirect('login.php');
  }

  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->includeFile('templates/table-add.html');

  // Handle form submit button
  if (isset($_POST['table-add-submit']))
  {
    // Clear variables
    $Table->setTableNumber($App->clearText($_POST['table_number']));
    $Table->setTableCount($App->clearText($_POST['table_count']));

    // Prepare SQL statment
    $statment = 'SELECT 1 FROM tables WHERE table_number = '.$Table->getTableNumber();

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      if ($result->num_rows > 0)
      {
        echo '<div class="message message-error">Stolik o numerze '.$Table->getTableNumber().' jest już zajęty.</div>';
      }
      else
      {
        $statment = 'INSERT INTO tables (table_number, table_count) VALUES ('.$Table->getTableNumber().', '.$Table->getTableCount().')';

        // Execute SQL statment
        if ($result = $DatabaseManager->query($statment))
        {
          echo '<div class="message message-success">Pomyślnie dodano stolik.</div>';
        }
        else
        {
          echo '<div class="message message-error">'.$result->error.'</div>';
        }
      }
    }
    else
    {
      echo '<div class="message message-error">'.$result->error.'</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
