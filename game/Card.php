<?php

class Card
{
	public $name;
	public $type;
	private $ballReferenceArr = array();
	
	public function __construct($_name, $_type)
	{
		$this->name = $_name;
		$this->type = $_type;
	}
	
	public function setBallDeliveryEvent($ballNumber, $event)
	{
		$this->ballReferenceArr['$ballNumber'] = $event;
	}
	
	public function getBallDeliveryEvent($ballNumber)
	{
		return $this->ballReferenceArr['$ballNumber'];
	}
	
}

?>