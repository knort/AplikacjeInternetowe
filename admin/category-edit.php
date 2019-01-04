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

  $statment = 'SELECT category_pl_name, category_eng_name FROM categories WHERE category_id = '.$category_id;
  $data = $DatabaseManager->query($statment);
  $data = $data->fetch_assoc();


  // Include footer
  $FileManager->includeFile('includes/header.html');

  // Include page content
  $FileManager->loadTemplate('templates/category-edit.html');
  $FileManager->prepareTemplate('{pl_name}', $data['category_pl_name']);
  $FileManager->prepareTemplate('{eng_name}', $data['category_eng_name']);
  $FileManager->render();

  // Handle form submit button
  if (isset($_POST['category-edit-submit']))
  {
    // Clear variables
    $Category->setCategoryId($category_id);
    $Category->setCategoryName('pl',  $App->clearText($_POST['pl_name']));
    $Category->setCategoryName('eng', $App->clearText($_POST['eng_name']));

    // Prepare SQL statment
    $statment = 'UPDATE categories SET category_pl_name = "'.$Category->getCategoryName('pl').'", category_eng_name = "'.$Category->getCategoryName('eng').'" WHERE category_id = '. $Category->getCategoryId();

    // Execute SQL statment
    if ($result = $DatabaseManager->query($statment))
    {
      echo '<div class="message message-success">Pomyślnie zapisano kategorie.</div>';
      $App->redirect('category-list.php');
    }
    else
    {
      echo '<div class="message message-error">'.$result->error.'</div>';
    }
  }

  // Include footer
  $FileManager->includeFile('includes/footer.html');
?>
