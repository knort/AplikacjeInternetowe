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
  if ($App->checkSession() == true)
  {
    $FileManager->includeFile('includes/'.$App->getLanguage().'/header_signed.html');
  }
  else
  {
    $FileManager->includeFile('includes/'.$App->getLanguage().'/header.html');
  }

  // Include page content
  $FileManager->includeFile('templates/'.$App->getLanguage().'/index.html');

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
