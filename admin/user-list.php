<?php  session_start();
  // Include classess
  include_once '../lib/App.php';
  include_once '../lib/FileManager.php';
  include_once '../lib/Category.php';
  include_once '../lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $Category        = new Category();
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
  $FileManager->includeFile('templates/user-list.html');

  // Prepare SQL statment
  $statment = 'SELECT
    user_id,
    user_name,
    user_lastname,
    user_phone,
    user_email,
    user_reg_date,
    CASE
    	WHEN user_account_status = 1 THEN "Aktywne"
        WHEN user_account_status = 0 THEN "Nieaktywne"
        WHEN user_account_status = 2 THEN "Zablokowane"
    END AS "user_account_status"
    FROM
        users
    ORDER BY
        user_id
    DESC';

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
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Telefon</th>
        <th>Email</th>
        <th>Data rejestracji</th>
        <th>Status konta</th>
        <th>Zablokuj</th>
        <th>Usuń</th>
      </tr>';

      while ($row = $result->fetch_assoc())
      {
        echo '<tr>
          <td>'.$row['user_id'].'</td>
          <td>'.$row['user_name'].'</td>
          <td>'.$row['user_lastname'].'</td>
          <td>'.$row['user_phone'].'</td>
          <td>'.$row['user_email'].'</td>
          <td>'.$row['user_reg_date'].'</td>
          <td>'.$row['user_account_status'].'</td>
          <td><a href="user-block.php?uid='.$row['user_id'].'" class="fontawesome-lock">Zablokuj</a></td>
          <td><a href="user-remove.php?uid='.$row['user_id'].'" class="fontawesome-remove">Usuń</a></td>
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
