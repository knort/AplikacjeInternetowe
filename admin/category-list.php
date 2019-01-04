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
  $FileManager->includeFile('templates/category-list.html');

  // Prepare SQL statment
  $statment = 'SELECT
    c.category_id,
    c.category_pl_name,
    c.category_eng_name,
    IFNULL(f.cnt, 0) as "cnt"
FROM
    categories c
LEFT OUTER JOIN (
 SELECT food_category_id, COUNT(*) as "cnt" FROM food GROUP BY food_category_id
) f ON
    c.category_id = f.food_category_id
ORDER BY
    category_id
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
        <th>Nazwa (PL)</th>
        <th>Nazwa (ENG)</th>
        <th>Lista dań</th>
        <th>Modyfikuj</th>
        <th>Usuń</th>
      </tr>';

      while ($row = $result->fetch_assoc())
      {
        echo '<tr>
          <td>'.$row['category_id'].'</td>
          <td>'.$row['category_pl_name'].'</td>
          <td>'.$row['category_eng_name'].'</td>
          <td><a href="food-list.php?cid='.$row['category_id'].'" class="fontawesome-eye-open">Pokaż ('.$row['cnt'].')</a></td>
          <td><a href="category-edit.php?cid='.$row['category_id'].'" class="fontawesome-pencil">Edytuj</a></td>
          <td><a href="category-remove.php?cid='.$row['category_id'].'" class="fontawesome-remove">Usuń</a></td>
        </tr>';
      }
      echo '</table>';
    }
  }
  else
  {
    echo '<div class="message message-error">'.$result->error.'</div>';
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
