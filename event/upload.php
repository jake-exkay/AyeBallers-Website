<?php
    $UNKNOWN_ERROR = "Error: File was not uploaded, an unknown error occured. Redirecting.";
    $NOT_AN_IMAGE = "Error: File is not an image! Redirecting.";
    $FILE_NAME_ERROR = "Error: File name error, please rename your file and try again. Redirecting.";
    $FILE_TOO_LARGE = "Error: File too large. Redirecting.";
    $SUCCESS = "Your report has been submitted, someone will review it soon. Redirecting.";

    $target_dir = "../admin/event/reports/";
    $target_file = $target_dir . basename($_FILES["uploadedFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["uploadedFile"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo $NOT_AN_IMAGE;
            $uploadOk = 0;
            header("Refresh:2; url=report.php");
        }
    }

    if (file_exists($target_file)) {
        echo $FILE_NAME_ERROR;
        $uploadOk = 0;
        header("Refresh:2; url=report.php");
    }

    if ($_FILES["uploadedFile"]["size"] > 5000000) {
        echo $FILE_TOO_LARGE;
        $uploadOk = 0;
        header("Refresh:2; url=report.php");

    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo $NOT_AN_IMAGE;
        $uploadOk = 0;
        header("Refresh:2; url=report.php");
    }

    if ($uploadOk == 0) {
        echo $UNKNOWN_ERROR;
        header("Refresh:2; url=report.php");
    } else {
        if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file)) {
            echo $SUCCESS;
            header("Refresh:2; url=report.php");
        } else {
            echo $UNKNOWN_ERROR;
            header("Refresh:2; url=report.php");
        }
    }
?>