<?php
require_once('../include/firephp_include.php');
include("Player.php");
$GLOBALS['firebug']->info('Debugging using FirePHP');

$bowler = new Player("Sumeet");
$bowler->level["bt"] = 1;
$bowler->level["bo"] = 1;
$bowler->addSkill("offSpin","bo");
$bowler->addSkill("fielder","g");

$batsman = new Player("Satish");
$batsman->name = "Satish";
$batsman->level["bt"] = 1;
$batsman->level["bo"] = 1;
$batsman->addSkill("onDrive","bt");
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
										"lateCut",
										"noSkill"),
						"legSpin"=>array("onDrive",
										"pull",
										"straightDrive",
										"legGlance",
										"noSkill"),
						"topSpin"=>array("pull",
										"squareCut",
										"legGlance",
										"defence",
										"noSkill"),
						"slow"=>array("onDrive",
										"defence",
										"straightDrive",
										"lateCut",
										"noSkill"),
						"inSwing"=>array("coverDrive",
										"squareCut",
										"defence",
										"lateCut",
										"noSkill"),
						"outSwing"=>array("onDrive",
										"pull",
										"legGlance",
										"defence",
										"noSkill"),
						"bouncer"=>array("onDrive",
										"coverDrive",
										"straightDrive",
										"legGlance",
										"noSkill"),
						"yorker"=>array("pull",
										"coverDrive",
										"squareCut",
										"lateCut",
										"noSkill"),
						"noSkill"=>array()
					);

function init()
{
	global $bowler, $batsman;
	
	checkPlayerAdvantages($bowler, $batsman);
	$GLOBALS['firebug']->log("match Started");
}

function checkPlayerAdvantages($bowler, $batsman)
{	
	$btSkill = getSkill("bt", $batsman);
	$boSkill = getSkill("bo", $bowler);
	
	$GLOBALS['firebug']->log("bowlingSkill--".$boSkill);
	$GLOBALS['firebug']->log("batingSkill--".$btSkill);
	
	if($boSkill != $btSkill)
	{
		if(checkForBowlerAdvantage($boSkill, $btSkill))
		{
			// bowlers advantage
			reducePlayerLevel($batsman, 'bt', 0.5);
		}else
		{
			// batsmans advantage
			reducePlayerLevel($bowler, 'bo', 0.5);
		}
	}
	else
	{
		$GLOBALS['firebug']->log("both have no skill");
	}
	echo $bowler->level['bo']." | ".$batsman->level['bt']."<br>";
	computePerformance($bowler->level['bo'], $batsman->level['bt']);
}

function getSkill($key, $player)
{
	if(array_key_exists($key,$player->skill))
	{
		return $player->skill[$key]->name;
	}else
	{
		return "noSkill";
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
	
	$GLOBALS['firebug']->log($advantageArr[$boSkillName]);
	$GLOBALS['firebug']->log(in_array($btSkillName,$advantageArr[$boSkillName])?"true":"false");
	return in_array($btSkillName,$advantageArr[$boSkillName]);
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