<?php

class BallDeliveryEvent
{
	private $affects; // values = "o" for opponent or "s" for self
	private $operator; // values = '+' or "-" or "/" or "*" or "="
	private $withValue; // value = any integer in positive range
	
	// send a delimetered string of the above values
	//	e.g.	s,*,1.3
	//			o,*,0.5
	public function __construct($_program)
	{
		
		$all_exp = explode($_program,",");
		$this->affects = $all_exp[0];
		$this->operator = $all_exp[1];
		$this->withValue = $all_exp[2];
	}
}

?>