<?php

require_once('../../includes/bootstrap.php');

use includes\classes\RateManager;
use includes\utils\FileUploader;

$url = SERVER_URL . "admin/index.php?view=rate_list"; // target of the redirect


if (!empty($_FILES['csv_uploaded']) && $_FILES['csv_uploaded']['size'] > 0) {
    $new_name = time();
    $destination_path = BASE_PATH . "temp/";
    $fileUploader = new FileUploader($_FILES['csv_uploaded'], $destination_path, $new_name, array("csv", "CSV"), "2097152");
    $result = $fileUploader->upload();

    if ($result["state"] == "success") {
        $csvFile = $destination_path . $result["file_name"];
        $csv_array = readCSV($csvFile);
        $rateManager = new RateManager();
        $rateManager->reloadNewRate($csv_array);

        $msg = "Rate list has been updated";
        $url = $url . "&info=" . $msg;

    } else {
        $url = $url . "&error=" . $result["message"];
    }
} else {
    $url = $url . "&error=No file is loaded!";
}




header("Location: " . $url);

?>