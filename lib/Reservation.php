<?php
class Reservation
{
  #-----------------------------------------------------------------------------
  private $v_date;
  private $v_start;
  private $v_end;
  private $v_table;
  #-----------------------------------------------------------------------------
  public function setDate ($p_value)
  {
    $this->v_date = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function setStart ($p_value)
  {
    $this->v_start = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function setEnd ($p_value)
  {
    $this->v_end = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function setTable ($p_value)
  {
    $this->v_table = $p_value;
  }
  #-----------------------------------------------------------------------------
  public function getDate ()
  {
    return $this->v_date;
  }
  #-----------------------------------------------------------------------------
  public function getStart ()
  {
    return $this->v_start;
  }
  #-----------------------------------------------------------------------------
  public function getEnd ()
  {
    return $this->v_end;
  }
  #-----------------------------------------------------------------------------
  public function getTable ()
  {
    return $this->v_table;
  }
  #-----------------------------------------------------------------------------
}
?>
