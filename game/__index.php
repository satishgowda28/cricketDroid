<?php
// Load Firephp from the include file in this site's root
require_once('../include/firephp_include.php');
 
// Make sure we know FirePHP is running by logging a message to the FirePHP
$GLOBALS['firebug']->info('Debugging using FirePHP');
$GLOBALS['test'] = "wasssup"; 
$myvar1 = array(
    array('test' => 'test1-value'),
    array('test2' => 'test2-value'),
);
 
$GLOBALS['firebug']->fb($myvar1);
$GLOBALS['firebug']->log('This is a normal log message');
$GLOBALS['firebug']->warn('This is a warning message', 'My Warning Label');
//$firephp->error('This is a error message');
function  testfunction()
{
	echo $GLOBALS['test'];
}
testfunction();
class TestClass
{
 	
	function test()
	{
		$GLOBALS['firebug']->log('called from class function ');
	}
}
$testObj = new TestClass();
$testObj->test();
?>