<?
use Mercury\Helper\Application;
use Mercury\Helper\Profiler;

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Autoload
require('vendor/autoload.php');

// Init the profiler
$go_profiler = new Profiler();

// Create the application
$go_app = new Application();

// Run the application
$go_app->runapp();

// Show the profiling result
$go_profiler->showresult();
?>