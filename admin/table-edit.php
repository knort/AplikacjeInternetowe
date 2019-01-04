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

  // Clear variables
  $table_id = $App->clearText(@$_GET['tid']);

  $statment = 'SELECT table_number, table_count FROM tables WHERE table_id = '.$table_id;
  $data = $DatabaseManager->query($statment);
  $data = $data->fetch_assoc();

  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->loadTemplate('templates/table-edit.html');
  $FileManager->prepareTemplate('{table_number}', $data['table_number']);
  $FileManager->prepareTemplate('{table_count}', $data['table_count']);
  $FileManager->render();

  $old_number = $data['table_number'];

  // Handle form submit button
  if (isset($_POST['table-edit-submit']))
  {
    // Clear variables
    $Table->setTableId($table_id);
    $Table->setTableNumber($App->clearText($_POST['table_number']));
    $Table->setTableCount($App->clearText($_POST['table_count']));

    // Prepare SQL statment
    $statment = 'SELECT 1 FROM tables WHERE table_number = '.$Table->getTableNumber().' AND table_number <> '.$old_number;

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      if ($result->num_rows > 0)
      {
        echo '<div class="message message-error">Stolik o numerze '.$Table->getTableNumber().' jest już zajęty.</div>';
      }
      else
      {
        $statment = 'UPDATE tables SET table_number = '.$Table->getTableNumber().', table_count = '.$Table->getTableCount().' WHERE table_id = '. $Table->getTableId();

        // Execute SQL statment
        if ($result = $DatabaseManager->query($statment))
        {
          echo '<div class="message message-success">Pomyślnie zapisano stolik.</div>';
          $App->redirect('table-list.php');
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
