<?php

class PhotoController
{

    public function __construct()
    {
    }

    public function processRequest($pkey, $type, $number = null)
    {
        $fileName = 'fileToUpload';
        if(!is_null($number))
            $fileName = $fileName . $number;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES[$fileName])) {
            if($type === 'visitor') {
                $target_dir = "uploads/visitors/";
            } else if($type === 'inmate') {
                $target_dir = "uploads/inmates/";
            } else if($type === "user"){
                $target_dir = "uploads/users/";
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid type.']);
                exit;
            }

            $target_file = $target_dir . $pkey. '.' . strtolower(pathinfo($_FILES[$fileName]["name"], PATHINFO_EXTENSION));
            echo $target_file;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES[$fileName]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                http_response_code(400);
                echo json_encode(['error' => 'File is not an image.']);
                exit;
            }

//            if (file_exists($target_file)) {
//                $uploadOk = 0;
//                http_response_code(400);
//                echo json_encode(['error' => 'Sorry, file already exists.']);
//                exit;
//            }

            if ($_FILES[$fileName]["size"] > 5000000) {
                $uploadOk = 0;
                http_response_code(400);
                echo json_encode(['error' => 'Sorry, your file is too large.']);
                exit;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
                $uploadOk = 0;
                http_response_code(400);
                echo json_encode(['error' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
                exit;
            }

            if ($uploadOk == 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Sorry, your file was not uploaded.']);
                exit;
            } else {
                if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $target_file)) {
                    http_response_code(200);
                    echo json_encode(['message' => 'The file ' . htmlspecialchars(basename($_FILES[$fileName]["name"])) . ' has been uploaded.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Sorry, there was an error uploading your file.']);
                }
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'No file was uploaded.']);
        }


    }

}