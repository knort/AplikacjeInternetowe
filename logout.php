<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';

  // Create instance of each class
  $App         = new App();
  $FileManager = new FileManager();

  // Set application language
  $App->setLanguage(@$_GET['lang']);

  // Include header
  $FileManager->includeFile('includes/'.$App->getLanguage().'/header.html');

  // Check user session
  if ($App->checkSession() == false)
  {
    $App->redirect('login.php?lang='.$App->getLanguage());
  }

  // Logout user
  $App->sessionDestroy();

  if ($App->getLanguage() == 'pl')
  {
    echo '<div class="message message-success">Zostałeś pomyślnie wylogowany.</div>';
  }
  else
  {
    echo '<div class="message message-error">You have been logged out.</div>';
  }

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
