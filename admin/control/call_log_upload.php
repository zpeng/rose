<?php
require_once('../../includes/bootstrap.php');
use includes\utils\FileUploader;

$url_error = SERVER_URL . "admin/index.php?view=call_log_list"; // target of the redirect
$url_ok = SERVER_URL . "admin/index.php?view=call_log_upload_staging"; // target of the redirect
$client_id = $_REQUEST['client_dropdown'];

if (!empty($_FILES['csv_uploaded']) && $_FILES['csv_uploaded']['size'] > 0) {
    $new_name = time() . "_log";
    $destination_path = BASE_PATH . "temp/";
    $fileUploader = new FileUploader($_FILES['csv_uploaded'], $destination_path, $new_name, array("csv", "CSV"), "2097152");
    $result = $fileUploader->upload();

    if ($result["state"] == "success") {
        $csvFile = $destination_path . $result["file_name"];
        $url_ok = $url_ok . "&client_id=" . $client_id."&csv_file=$csvFile";
        header("Location: " . $url_ok);
    } else {
        $url_error = $url_error . "&error=" . $result["message"];
        header("Location: " . $url_error);
    }
} else {
    $url_error = $url_error . "&error=No file is loaded!";
    header("Location: " . $url_error);
}



?>