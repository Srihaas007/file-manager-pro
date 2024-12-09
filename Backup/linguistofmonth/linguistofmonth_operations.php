<?php

require_once '../../page_fragment/define.php';

include ('../../page_fragment/dbConnect.php');

include ('../../page_fragment/dbGeneral.php');

include ('../../page_fragment/njGeneral.php');

include ('../../page_fragment/njFile.php');

include ('../../page_fragment/njEncription.php');

$dbConObj = new dbConnectsp();

$dbComObj = new dbGeneral();

$njGenObj = new njGeneral();

$conn = $dbConObj->dbConnect();

$njEncryptionObj = new njEncryption();

$njFileObj = new njFile();

$operation = "";

if (isset($_POST['todo'])) {
    $operation = base64_decode($_POST['todo']);
    unset($_POST['todo']);
} elseif (isset($_GET['todo'])) {
    $operation = base64_decode($_GET['todo']);
    unset($_GET['todo']);
}
$table = "linguistofmonth";
//echo $operation;
if ($operation == "addlinguistofmonth") {
    $dates = date("Y-m-d-H-i-s");
    $data = array();
    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $name = preg_replace('/[^a-zA-Z0-9_]/', '-', $_POST['title']);
        $filename = $image . "-" . $dates;
        $pathToSave = "../images/linguistofmonth/";
        $thumbPathToSave = "../images/linguistofmonth/thumb/";
        $main_logo = $njFileObj->uploadImage($image, $filename, $pathToSave);
        $image_source = "../images/linguistofmonth/" . $main_logo;
        $thumb_logo = $njFileObj->resizeImage($image_source, $filename, $thumbPathToSave);
        $data['image'] = $main_logo;
    }
    $time = $_POST['publish_date'];
//    $date = DateTime::createFromFormat('d/m/Y', $time);
//    $date = $date->format('Y-m-d');
    $show_date = DateTime::createFromFormat('d/m/Y', $time)->format('Y-m-d');
  $data['display_date'] = $show_date;
    $data['content'] = $_POST['content'];
    $data['url'] = $_POST['url'];
    $data['status'] = '1';
    $data['added_on'] = $dates;
    $dbComObj->addData($conn, $table, $data);
    echo "Reload : Linguistofmonth added successfully.";
} elseif ($operation == "editlinguistofmonth") {
    $condition = " `id`=" . base64_decode($_POST['id']) . "";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
    if ($num > 0) {
        $data = array();
        $dates = date("Y-m-d-H-i-s");
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $name = preg_replace('/[^a-zA-Z0-9_]/', '-', $_POST['title']);
            $filename = $image . "-" . $dates;
            $pathToSave = "../images/linguistofmonth/";
            $thumbPathToSave = "../images/linguistofmonth/thumb/";
            $main_logo = $njFileObj->uploadImage($image, $filename, $pathToSave);
            $image_source = "../images/linguistofmonth/" . $main_logo;
            $thumb_logo = $njFileObj->resizeImage($image_source, $filename, $thumbPathToSave);
            $data['image'] = $main_logo;
        }
        $time = $_POST['publish_date'];
        $show_date = DateTime::createFromFormat('d/m/Y', $time)->format('Y-m-d');
        $data['display_date'] = $show_date;
        $data['content'] = $_POST['content'];
        $data['url'] = $_POST['url'];
        $data['status'] = '1';
        $data['added_on'] = $dates;
        $conditions = " `id`='" . base64_decode($_POST['id']) . "'";
        unset($_POST['id']);
        $dbComObj->editData($conn, $table, $data, $conditions);
        echo "Reload : Linguistofmonth updated successfully.";
    } else {
        echo "Error : Linguistofmonth already exist.";
    }
} elseif ($operation == "deletelinguistofmonth") {
    $id = $_REQUEST['id'];
    $sql2 = "SELECT *  FROM linguistofmonth where id = '$id'";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        $rowU = mysqli_fetch_array($result2);
        $condition = "`id` = '" . $id . "'";
        $dbComObj->deleteData($conn, $table, $condition);
        echo 'Linguistofmonth Removed Successfully';
    } else {
        echo 'Error';
    }
}