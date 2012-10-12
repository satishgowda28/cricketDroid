<?php
/** 
 * FirePHP setup.
 * This code should only be found ONCE on your site, Add it to an include file.
 * If site has single index.php (Magento, Drupal, etc.), call the include file once (there)
 * using require_once(...);
 *
 * If you need this to be global, please replace $firephp with $GLOBALS['firephp'] everywhere!
 * so: $GLOBALS['firebug'] = FirePHP::getInstance(true);
 * and in your php code: $GLOBALS['firephp']->log('test of global firephp');
 */
require_once('../firephp/FirePHP.class.php');
$GLOBALS['firebug'] = FirePHP::getInstance(true); //non-global
 
// Add allowed ip addresses below, comma-separated
$allowedIpArr = array('127.0.0.1', 'XX.XX.XX.XX');
 
if (in_array($_SERVER['REMOTE_ADDR'], $allowedIpArr)) {
    $GLOBALS['firebug']->setEnabled(true);
}
else { 
    $GLOBALS['firebug']->setEnabled(false);
}
 
// Log all errors, exceptions, and assertion errors to Firebug 
// NOTE! these may cause problems... use them with caution!
$GLOBALS['firebug']->registerErrorHandler($throwErrorExceptions=true);
$GLOBALS['firebug']->registerExceptionHandler();
$GLOBALS['firebug']->registerAssertionHandler($convertAssertionErrorsToExceptions=true, $throwAssertionExceptions=false);
?>