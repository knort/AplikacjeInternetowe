<?php
class Food
{
  #-----------------------------------------------------------------------------
  private $v_name_pl;
  private $v_name_eng;
  private $v_desc_pl;
  private $v_desc_eng;
  private $v_price;
  private $v_id;
  #-----------------------------------------------------------------------------
  public function setFoodName ($p_lang, $p_value)
  {
    if ($p_lang == 'pl')
      $this->v_name_pl = $p_value;
    else
      $this->v_name_eng = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function getFoodName ($p_lang)
  {
    if ($p_lang == 'pl')
      return $this->v_name_pl;
    else
      return $this->v_name_eng;
  }
  #-----------------------------------------------------------------------------
  public function setFoodDesc ($p_lang, $p_value)
  {
    if ($p_lang == 'pl')
      $this->v_desc_pl = $p_value;
    else
      $this->v_desc_eng = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function getFoodDesc ($p_lang)
  {
    if ($p_lang == 'pl')
      return $this->v_desc_pl;
    else
      return $this->v_desc_eng;
  }
  #-----------------------------------------------------------------------------
  public function setPrice ($p_value)
  {
    $this->price = doubleval($p_value);
  }
  #-----------------------------------------------------------------------------
  public function getPrice ()
  {
    return $this->price;
  }
  #-----------------------------------------------------------------------------
  public function setFoodId ($p_id)
  {
    $this->v_id = $p_id;
  }
  #-----------------------------------------------------------------------------
  public function getFoodId ()
  {
    return $this->v_id;
  }
  #-----------------------------------------------------------------------------
}
?>
