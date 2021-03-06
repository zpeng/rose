<?php
/* this function resize the photo size */


function setup_configuration_in_session()
{
    if (!isset ($_SESSION['configuration'])) {
        $s_configManager = new ConfigurationManager();
        unset ($_SESSION['$configManager']);
        $_SESSION['configuration'] = serialize($s_configManager);

    } else {
        $str = unserialize($_SESSION['configuration']);
        $s_configManager = ConfigurationManager::cast($str);

        unset ($_SESSION['configuration']);
        $_SESSION['configuration'] = serialize($s_configManager);
    }
}

function secureRequestParameter($value)
{
    $value = trim($value);
    //$value = mysql_real_escape_string($value);
    return $value;
}


function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}


?>