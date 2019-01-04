<?php
class DatabaseManager
{
  #-----------------------------------------------------------------------------
  private $v_host;
  private $v_user;
  private $v_pass;
  private $v_name;

  private $v_handle;
  #-----------------------------------------------------------------------------
  public function __construct ()
  {
    $this->v_host = 'localhost';
    $this->v_user = 'root';
    $this->v_pass = '';
    $this->v_name = 'appin';
  }
  #-----------------------------------------------------------------------------
  public function connect ()
  {
    $this->v_handle = new mysqli($this->v_host, $this->v_user, $this->v_pass, $this->v_name);

    if ($this->v_handle->connect_error)
    {
      echo $this->v_handle->connect_error;
      exit();
    }

    return $this->v_handle;
  }
  #-----------------------------------------------------------------------------
}
?>
