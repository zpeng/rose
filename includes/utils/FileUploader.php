<?php
namespace includes\utils;

class FileUploader
{
    private $uploading_file;

    private $destination_path;
    private $max_size = 2097152; // 2 mb

    private $new_file_name = ""; // this value is set to provide a new name to replace the original name after file is uploaded
    private $file_name;

    private $operation_result = array(
        "state" => "success",
        "message" => "Upload Successful!");


    public function __construct($_uploading_file, $_destination_path, $_new_file_name = "", $_allow_file_type = "", $_max_size = "")
    {
        $this->uploading_file = $_uploading_file;
        $this->file_name = $this->uploading_file["name"];

        $this->destination_path = $_destination_path;

        if (!is_null($_new_file_name)) {
            $this->new_file_name = $_new_file_name;
        }

        if (!is_null($_allow_file_type)) {
            $this->allow_file_type = $_allow_file_type;
        }

        if (!is_null($_max_size)) {
            $this->max_size = $_max_size;
        }
    }

    public function upload()
    {
        // check if the uploading file is empty
        if ($this->uploading_file['tmp_name'] == null) {
            $this->operation_result = array(
                "state" => "fail",
                "message" => "The uploading file is not found!");
            return $this->operation_result;
        }

        // check if the uploading file type is supported
        if (!in_array($this->getFileExistence($this->file_name), $this->allow_file_type)) {
            $this->operation_result = array(
                "state" => "fail",
                "message" => "The uploading file type is not supported!");
            return $this->operation_result;
        }

        // check the file size
        if (filesize($this->uploading_file['tmp_name']) > $this->max_size) {
            $this->operation_result = array(
                "state" => "fail",
                "message" => "The uploaded file exceeds the server's maximum allowed size!");
            return $this->operation_result;
        }

        // check the destination folder I/O permission
        if (!is_writable($this->destination_path)) {
            $this->operation_result = array(
                "state" => "fail",
                "message" => "You cannot upload to the specified directory, please CHMOD it to 777!");
            return $this->operation_result;
        }


        // check if we need to replace the file name
        if ($this->new_file_name != "") {
            $this->file_name = $this->new_file_name . "." . $this->getFileExistence($this->file_name);
        }

        // if there is a same named file on the server, delete it!
        $this->deleteFileFromServer($this->destination_path . $this->file_name);

        // looks like everything is ok so far, lets do the loading
        if (move_uploaded_file($this->uploading_file['tmp_name'], $this->destination_path . $this->file_name)) {
            $this->operation_result = array(
                "state" => "success",
                "file_name" => $this->file_name,
                "message" => "The file has been successfully uploaded!");
            return $this->operation_result;
        } else {
            $this->operation_result = array(
                "state" => "fail",
                "message" => "Failed to upload the file!");
            return $this->operation_result;
        }
    }

    private function getFileExistence($filename)
    {
        $ext = substr($filename, strpos($filename, '.') + 1, strlen($filename) - 1);
        return $ext;
    }

    public function deleteFileFromServer($targetFile)
    {
        if (is_file($targetFile)) {
            unlink($targetFile);
        }
    }
}

?>