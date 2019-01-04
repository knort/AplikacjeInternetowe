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

  // Clear variables
  $category_id = $App->clearText(@$_GET['cid']);

  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->includeFile('templates/food-list.html');

  echo '<a href="food-add.php?cid='.$category_id.'" class="button">Dodaj</a>';

  // Prepare SQL statment
  $statment = 'SELECT food_id, food_pl_name, food_eng_name, food_pl_desc, food_eng_desc, food_price FROM food WHERE food_category_id = '.$category_id.' ORDER BY food_id DESC';

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
        <th>Nazwa (PL)</th>
        <th>Nazwa (ENG)</th>
        <th>Opis (PL)</th>
        <th>Opis (ENG)</th>
        <th>Cena</th>
        <th>Modyfikuj</th>
        <th>Usuń</th>
      </tr>';

      while ($row = $result->fetch_assoc())
      {
        echo '<tr>
          <td>'.$row['food_id'].'</td>
          <td>'.$row['food_pl_name'].'</td>
          <td>'.$row['food_eng_name'].'</td>
          <td>'.$row['food_pl_desc'].'</td>
          <td>'.$row['food_eng_desc'].'</td>
          <td>'.$row['food_price'].'</td>
          <td><a href="food-edit.php?fid='.$row['food_id'].'&cid='.$category_id.'" class="fontawesome-pencil">Edytuj</a></td>
          <td><a href="food-remove.php?fid='.$row['food_id'].'&cid='.$category_id.'" class="fontawesome-remove">Usuń</a></td>
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
