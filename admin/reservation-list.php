<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
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
  $FileManager->includeFile('templates/reservation-list.html');

  // Prepare SQL statment
  $statment = 'SELECT
          r.reservation_id AS "reservation_id",
          r.reservation_date AS "reservation_date",
          r.reservation_start AS "reservation_start",
          r.reservation_end AS "reservation_end",
          t.table_number AS "table_number",
          u.user_email AS "user_email"
      FROM
          reservations r
      JOIN users u ON
          u.user_id = r.reservation_user_id
      JOIN TABLES t ON
          t.table_id = r.reservation_table_id
      ORDER BY
        r.reservation_id
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
        <th>Data rezerwacji</th>
        <th>Rozpoczęcie</th>
        <th>Zakończenie</th>
        <th>Numer stolika</th>
        <th>Użytkownik</th>
        <th>Usuń</th>
      </tr>';

      while ($row = $result->fetch_assoc())
      {
        echo '<tr>
          <td>'.$row['reservation_id'].'</td>
          <td>'.$row['reservation_date'].'</td>
          <td>'.$row['reservation_start'].'</td>
          <td>'.$row['reservation_end'].'</td>
          <td>'.$row['table_number'].'</td>
          <td>'.$row['user_email'].'</td>
          <td><a href="reservation-remove.php?tid='.$row['reservation_id'].'" class="fontawesome-remove">Usuń</a></td>
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
