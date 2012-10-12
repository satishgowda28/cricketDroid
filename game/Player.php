<?php

include("Skill.php");

class Player
{
	public $level = array();
	public $skill = array();
	public $name;
	
	public function __construct($_name)
	{
		$this->name = $_name;

	}
	
	public function addSkill($skillName, $skillType)
	{
		if(count($this->skill)<2)
		{
			$_skill = new Skill($skillType,$skillName);
			$this->skill[$skillType] = $_skill;
		}
	}
	
	public function getSkill($atPosition)
	{
		$skill =  $this->skill[$atPosition];
		return $skill;
	}
	
	
}
?>