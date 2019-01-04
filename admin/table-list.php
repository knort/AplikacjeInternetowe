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
  $FileManager->includeFile('templates/table-list.html');

  // Prepare SQL statment
  $statment = 'SELECT
    table_id,
    table_number,
    table_count
    FROM
        tables
    ORDER BY
        table_id
    DESC
        ';

  // Execute SQL statment
  if ($result = $DatabaseManager->query($statment))
  {
    if ($result->num_rows == 0)
    {
      echo '<div class="message message-error">Brak danych do wyświetlenia</div>';
    }
    else
    {
      echo '<table>';
      echo '<tr>
        <th>Identyfikator</th>
        <th>Numer stolika</th>
        <th>Liczba miejsc</th>
        <th>Edytuj</th>
        <th>Usuń</th>
      </tr>';

      while ($row = $result->fetch_assoc())
      {
        echo '<tr>
          <td>'.$row['table_id'].'</td>
          <td>'.$row['table_number'].'</td>
          <td>'.$row['table_count'].'</td>
          <td><a href="table-edit.php?tid='.$row['table_id'].'" class="fontawesome-pencil">Edytuj</a></td>
          <td><a href="table-remove.php?tid='.$row['table_id'].'" class="fontawesome-remove">Usuń</a></td>
        </tr>';
      }
      echo '</table>';
    }
  }
  else
  {
    echo '<div class="message message-error">'.$DatabaseManager->error.'</div>';
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
