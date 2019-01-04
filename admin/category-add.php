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
  $FileManager->includeFile('templates/category-add.html');

  // Handle form submit button
  if (isset($_POST['category-add-submit']))
  {
    // Clear variables
    $Category->setCategoryName('pl',  $App->clearText($_POST['pl_name']));
    $Category->setCategoryName('eng', $App->clearText($_POST['eng_name']));

    // Prepare SQL statment
    $statment = 'INSERT INTO categories (category_pl_name, category_eng_name) VALUES ("'.$Category->getCategoryName('pl').'", "'.$Category->getCategoryName('eng').'")';

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      echo '<div class="message message-success">Pomyślnie dodano kategorie.</div>';
    }
    else
    {
      echo '<div class="message message-error">'.$result->error.'</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
