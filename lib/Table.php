<?php
class Table
{
  #-----------------------------------------------------------------------------
  private $v_table_number;
  private $v_table_count;
  private $v_table_id;
  #-----------------------------------------------------------------------------
  public function setTableNumber ($p_value)
  {
    $this->v_table_number = abs(intval($p_value));
  }
  #-----------------------------------------------------------------------------
  public function getTableNumber ()
  {
    return $this->v_table_number;
  }
  #-----------------------------------------------------------------------------
  public function setTableCount ($p_value)
  {
    $this->v_table_count = abs(intval($p_value));
  }
  #-----------------------------------------------------------------------------
  public function getTableCount ()
  {
    return $this->v_table_count;
  }
  #-----------------------------------------------------------------------------
  public function setTableId ($p_value)
  {
    $this->v_table_id=$p_value;
  }
  #-----------------------------------------------------------------------------
  public function getTableId ()
  {
    return $this->v_table_id;
  }
  #-----------------------------------------------------------------------------
}
?>
