<?php
class App
{
  #-----------------------------------------------------------------------------
  private $v_lang;
  #-----------------------------------------------------------------------------
  public function setLanguage ($p_lang)
  {
    $this->v_lang = $p_lang;

    if (empty($this->v_lang))
      $this->v_lang = 'pl';

    if ($this->v_lang != 'pl' && $this->v_lang != 'en')
      $this->v_lang = 'pl';
  }
  #-----------------------------------------------------------------------------
  public function getLanguage ()
  {
    return $this->v_lang;
  }
  #-----------------------------------------------------------------------------
  public function clearText ($p_text)
  {
    return strip_tags(trim($p_text));
  }
  #-----------------------------------------------------------------------------
  public function createSession($p_id)
  {
    $_SESSION['uid'] = $p_id;
    $_SESSION['uauth'] = true;
  }
  #-----------------------------------------------------------------------------
  public function checkSession ()
  {
    if (empty($_SESSION['uid'] ) || $_SESSION['uauth'] == false)
    {
      return false;
    }

    return true;
  }
  #-----------------------------------------------------------------------------
  public function createAdminSession($p_id)
  {
    $_SESSION['aid'] = $p_id;
    $_SESSION['aauth'] = true;
  }
  #-----------------------------------------------------------------------------
  public function checkAdminSession ()
  {
    if (empty($_SESSION['aid'] ) || $_SESSION['aauth'] == false)
    {
      return false;
    }

    return true;
  }
  #-----------------------------------------------------------------------------
  public function sessionDestroy ()
  {
    session_unset();
    session_destroy();
  }
  #-----------------------------------------------------------------------------
  public function redirect ($p_url)
  {
    die ('<meta http-equiv="Refresh" content="0; url='.$p_url.'" />');
  }
  #-----------------------------------------------------------------------------
  public function getEuroCurrency ()
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/rates/a/eur/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    $output = json_decode($output);
    $output = round($output->rates[0]->mid, 2);

    curl_close($ch);

    return $output;
  }
  #-----------------------------------------------------------------------------
}
?>
