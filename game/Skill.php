<?php

class Skill
{
	public $type;
	public $name;
	
	public function __construct($_type,$_name)
	{
		$this->type = $_type;
		$this->name = $_name;
	}
}

?>