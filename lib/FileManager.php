<?php
class FileManager
{
  #-----------------------------------------------------------------------------
  private $v_template;
  #-----------------------------------------------------------------------------
  public function includeFile ($p_source)
  {
    if (file_exists($p_source))
      include $p_source;
    else
      echo 'Failed to load file: '.$p_source;
  }
  #-----------------------------------------------------------------------------
  public function loadTemplate ($p_source)
  {
    if (file_exists($p_source))
      $this->v_template = file_get_contents($p_source);
    else
      echo 'Failed to load file: '.$p_source;
  }
  #-----------------------------------------------------------------------------
  public function prepareTemplate ($p_string, $p_value)
  {
    $this->v_template = str_replace($p_string, $p_value, $this->v_template);
  }
  #-----------------------------------------------------------------------------
  public function render()
  {
    echo $this->v_template;
  }
  #-----------------------------------------------------------------------------
}
?>
