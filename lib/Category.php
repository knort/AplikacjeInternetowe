<?php
class Category
{
  #-----------------------------------------------------------------------------
  private $v_category_pl_name;
  private $v_category_eng_name;
  private $v_id;
  #-----------------------------------------------------------------------------
  public function setCategoryName ($p_lang, $p_value)
  {
    if ($p_lang == 'pl')
      $this->v_category_pl_name = $p_value;
    else
      $this->v_category_eng_name = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function getCategoryName ($p_lang)
  {
    if ($p_lang == 'pl')
      return $this->v_category_pl_name;
    else
      return $this->v_category_eng_name;
  }
  #-----------------------------------------------------------------------------
  public function setCategoryId ($p_id)
  {
    $this->v_id = $p_id;
  }
  #-----------------------------------------------------------------------------
  public function getCategoryId ()
  {
    return $this->v_id;
  }
  #-----------------------------------------------------------------------------
}
?>
