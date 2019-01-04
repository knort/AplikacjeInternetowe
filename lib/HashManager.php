<?php
class HashManager
{
  #-----------------------------------------------------------------------------
  public function passwordHash ($p_password)
  {
    return md5(sha1($p_password));
  }
  #-----------------------------------------------------------------------------
  public function createPassword ()
  {
    $v_chars = 'abcdefghijklmnoprstuwxzyqABCDEFGHIJKLMNOPRSTUWQXYZ1234567890!@#$%^&*';
    $v_result = '';

    for ($i = 0; $i < 8; $i++)
      $v_result .= $v_chars[rand(0, strlen($v_chars) - 1)];

    return $v_result;
  }
  #-----------------------------------------------------------------------------
  public function tokenHash ()
  {
    return md5(sha1(time()));
  }
  #-----------------------------------------------------------------------------
}
?>
