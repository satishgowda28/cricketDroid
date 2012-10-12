<?php
require_once('../include/firephp_include.php');
include("Player.php");


$bowler = new Player("Sumeet");
$bowler->level["bt"] = 1;
$bowler->level["bo"] = 1;
$bowler->addSkill("legSpin","bo");
$bowler->addSkill("fielder","g");

$batsman = new Player("Satish");
$batsman->name = "Satish";
$batsman->level["bt"] = 1;
$batsman->level["bo"] = 1;
$batsman->addSkill("defence","bt");
$batsman->addSkill("fielding","g");

$performanceResultArr = array("0:100"=>"6",
						   "10:90"=>"6",
						   "20:80"=>"4",
						   "30:70"=>"4",
						   "40:60"=>"3",
						   "50:50"=>"2",
						   "60:40"=>"1",
						   "70:30"=>"0",
						   "80:20"=>"W",
						   "90:10"=>"W",
						   "100:0"=>"W",
							);
$advantageArr = array("offSpin"=>array("coverDrive",
										"squareCut",
										"straightDrive",
										"lateCut"),
						"legSpin"=>array("onDrive",
										"pull",
										"straightDrive",
										"legGlance"),
						"topSpin"=>array("pull",
										"squareCut",
										"legGlance",
										"defence"),
						"slow"=>array("onDrive",
										"defence",
										"straightDrive",
										"lateCut"),
						"inSwing"=>array("coverDrive",
										"squareCut",
										"defence",
										"lateCut"),
						"outSwing"=>array("onDrive",
										"pull",
										"legGlance",
										"defence"),
						"bouncer"=>array("onDrive",
										"coverDrive",
										"straightDrive",
										"legGlance"),
						"yorker"=>array("pull",
										"coverDrive",
										"squareCut",
										"lateCut"),
					);

function init()
{
	global $bowler, $batsman;
	checkPlayerAdvantages($bowler, $batsman);
}

function checkPlayerAdvantages($bowler, $batsman)
{
	$btSkill = getSkill("bt", $batsman);
	$boSkill = getSkill("bo", $bowler);
	
	if(!$btSkill)
	{
		$btSkillName = "noSkill";
	}else
	{
		$btSkillName = $btSkill->name;
	}
	if(!$boSkill)
	{
		$boSkillName = "noSkill";
	}else{
		$boSkillName = $boSkill->name;
	}
	
	if($boSkillName != $btSkillName)
	{
		if(checkForBowlerAdvantage($boSkillName, $btSkillName) || $btSkillName == "noSkill")
		{
			// bowlers advantage
			reducePlayerLevel($batsman, 'bt', 0.5);
		}else
		{
			// batsmans advantage
			reducePlayerLevel($bowler, 'bo', 0.5);
		}
	}
	echo $bowler->level['bo']." | ".$batsman->level['bt']."<br>";
	computePerformance($bowler->level['bo'], $batsman->level['bt']);
}

function getSkill($key, $player)
{
	if(array_key_exists($key,$player->skill))
	{
		return $player->skill[$key];
	}else
	{
		return false;
	}
}

function reducePlayerLevel($player, $leveltype, $fraction)
{
	echo "reduce ".$player->name." ".$leveltype." ".$fraction."<br>";
	$player->level[$leveltype] = $player->level[$leveltype] * $fraction;
}

function checkForBowlerAdvantage($boSkillName, $btSkillName)
{
	global $advantageArr;
	if($boSkillName != "noSkill")
	{
		return in_array($btSkillName,$advantageArr[$boSkillName]);
	}else{
		return false;
	}
}



function computePerformance($boLevel, $btLevel)
{
//	global $btLevel,$boLevel;
	$crudePerformanceRatio = computePerformanceRatio($boLevel,$btLevel);
	$performanceResult = getBallResult($crudePerformanceRatio);
	echo $performanceResult;
}

function computePerformanceRatio($boLevel,$btLevel)
{
	echo "<br><br>bo: $boLevel | bt: $btLevel<br>";
	$boPerformance =round(($boLevel/($boLevel+$btLevel))*100);
	$btPerformance =round(($btLevel/($boLevel+$btLevel))*100);
	echo $boPerformance.":".$btPerformance."<br>";
	return prepareRatiosForPerformanceComparision($boPerformance,$btPerformance);
}

function getBallResult($crudePerformanceRatio)
{
	global $performanceResultArr;
	return $performanceResultArr[$crudePerformanceRatio];

}
function prepareRatiosForPerformanceComparision($boPerformance,$btPerformance)
{
	if($boPerformance != $btPerformance)
	{
		$boPerformance = getRoundedRatio($boPerformance);
		$btPerformance = getRoundedRatio($btPerformance);
	}
	echo $boPerformance.":".$btPerformance."<br>";
	if($boPerformance + $btPerformance > 100)
	{
		if($boPerformance < $btPerformance)
		{
			$boPerformance = 100 - $btPerformance;
		}else{
			$btPerformance = 100 - $boPerformance;
		}
		$result = $boPerformance.":".$btPerformance;
	}else{
		$result = $boPerformance.":".$btPerformance;
	}
	return $result;
}

function  getRoundedRatio($performanceValue)
{	
	$rounded = round($performanceValue/10)*10;
	echo "round $performanceValue to $rounded"."<br>";
	return $rounded;
}

init();
?>