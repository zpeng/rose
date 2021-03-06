<?php
/** define the database **/
define('DB_HOST', "localhost");
define('DB_NAME', "rose");
define('DB_USER', "root");
define('DB_PASSWORD', "");

/** define server and project location - used to load css and js files **/
define('SERVER_URL', "http://localhost/rose/");
define('PROJECT_FOLDER', "/rose"); // in case the project folder is sub-folder of the root folder

/** define base path - used for loading php files */
if (!defined('BASE_PATH'))
    define('BASE_PATH', str_replace('\\', '/', realpath($_SERVER["DOCUMENT_ROOT"]) . PROJECT_FOLDER . '/'));


//disable error display
ini_set('display_errors', '1');


$GLOBAL_DEPS = array();

// loading the core deps
include_once(BASE_PATH . "includes/global_deps.php");

// now loads all the required php files for all the available modules
foreach ($GLOBAL_DEPS as $module_key => $module_deps_config) {
    foreach ($GLOBAL_DEPS[$module_key]["php"] as $php_deps) {
        include_once(BASE_PATH . $php_deps);
        //echo BASE_PATH . $php_file . "<br/>";
    }
}


//print_r($GLOBAL_DEPS);


// Or, using an anonymous function as of PHP 5.3.0
// auto loader register for auto loading php classes
spl_autoload_register(function ($class) {
    // get full name of file containing the required class
    $file = BASE_PATH.str_replace('\\', '/', $class) . '.php';
    // get file if it is readable
    if (is_readable($file))
        require_once $file;
});

?>