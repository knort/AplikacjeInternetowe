<?php  session_start();
  // Include classess
  include_once 'lib/App.php';
  include_once 'lib/FileManager.php';
  include_once 'lib/DatabaseManager.php';

  // Create instance of each class
  $App             = new App();
  $FileManager     = new FileManager();
  $DatabaseManager =  new DatabaseManager();
  $DatabaseManager = $DatabaseManager->connect();

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

  $categoryButton = '';
  $categoryList = '';

  // Prepare SQL statment
  if ($App->getLanguage() == 'pl')
  {
    $statment = 'SELECT category_id, category_pl_name as "cname" FROM categories';
    $categoryButton = '<button class="fontawesome-angle-right" data-id="0">Wszystkie</button>';
  }
  else
  {
    $statment = 'SELECT category_id, category_eng_name as "cname" FROM categories';
    $categoryButton = '<button class="fontawesome-angle-right" data-id="0">All</button>';
  }

  // Execute SQL statment
  if ($result = $DatabaseManager->query($statment))
  {
    if ($result->num_rows > 0)
    {
      while ($row = $result->fetch_assoc())
      {
        $categoryButton .= '<button class="fontawesome-angle-right" data-id="'.$row['category_id'].'">'.$row['cname'].'</button>';

        if ($App->getLanguage() == 'pl')
          $statment2 = 'SELECT food_pl_name as "name", food_pl_desc as "desc", food_price FROM food where food_category_id = '.$row['category_id'];
        else
          $statment2 = 'SELECT food_eng_name as "name", food_eng_desc as "desc", food_price FROM food where food_category_id = '.$row['category_id'];

        $tmpHtml = '';

        if ($result2 = $DatabaseManager->query($statment2))
        {
          if ($result2->num_rows > 0)
          {
            while ($row2 = $result2->fetch_assoc())
            {
              $tmpHtml .= '<div class="menu-item">
                              '.$row2['name'].' <span class="price">'.(number_format(round($row2['food_price'] / $App->getEuroCurrency(),2), 2, '.', '')).' &euro;</span> <span class="price">'.number_format($row2['food_price'], 2, '.', '').' PLN</span>
                              <p class="menu-item-description">
                              '.$row2['desc'].'
                              </p>
                          </div>';
            }
          }
        }
        else
        {
          echo $DatabaseManager->error;
        }

        $categoryList .= '<div class="menu-box" data-id="'.$row['category_id'].'">
          <h2>'.$row['cname'].'</h2>
          <div class="menu-list">
            '.$tmpHtml.'
            <div class="clearfix"></div>
          </div>
        </div>';
      }
    }
  }
  else
  {
    echo $DatabaseManager->error;
  }

  // Include page content
  $FileManager->loadTemplate('templates/'.$App->getLanguage().'/menu.html');
  $FileManager->prepareTemplate('{buttons}', $categoryButton);
  $FileManager->prepareTemplate('{list}', $categoryList);

  $FileManager->render();

  // Include footer
  $FileManager->includeFile('includes/'.$App->getLanguage().'/footer.html');
?>
