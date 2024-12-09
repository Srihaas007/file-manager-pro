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
$table = "page_content";
//echo $operation;
if ($operation == "addPage") {
//    print_r($_REQUEST); die;
    $condition = " `url`='" . $_POST['url'] . "'";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
    if ($num == 0) {
        $dates = date("Y-m-d-H-i-s");
        $data = array();
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $name = preg_replace('/[^a-zA-Z0-9_]/', '-', $_POST['title']);
            $filename = $name . "-" . $dates;
            $pathToSave = "../images/page/";
            $thumbPathToSave = "../images/page/thumb/";
            $main_logo = $njFileObj->uploadImage($image, $filename, $pathToSave);
            $image_source = "../images/page/" . $main_logo;
            $thumb_logo = $njFileObj->resizeImage($image_source, $filename, $thumbPathToSave);
            $data['image'] = $main_logo;
        }
        $data['title'] = $_POST['title'];
        $data['description'] = $_POST['description'];
        
        $data['meta_title'] = $_POST['meta_title'];
        $data['meta_description'] = $_POST['meta_description'];
        $data['alt_text'] = $_POST['alt_text'];
        // $data['url'] = $_POST['url'];
        $url = trim($_POST['url']);
        $custom_url = explode(" ", $url);
        $custom_url = implode("-", $custom_url);
        $data['url'] = strtolower($custom_url);
        $data['status'] = '1';
        $data['added_on'] = $dates; 
        $dbComObj->addData($conn, $table, $data);
        echo "Redirect : Page added successfully. URL " . ADMIN_URL . "page/page_list.php";
    } else {
        echo "Error : URL already exist.";
    }
} elseif ($operation == "editPage") {
    $condition = " `id`=" . base64_decode($_POST['id']) . "";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
    if ($num > 0) {
        $data = array();
        $dates = date("Y-m-d-H-i-s");
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $name = preg_replace('/[^a-zA-Z0-9_]/', '-', $_POST['title']);
            $filename = $name . "-" . $dates;
            $pathToSave = "../images/page/";
            $thumbPathToSave = "../images/page/thumb/";
            $main_logo = $njFileObj->uploadImage($image, $filename, $pathToSave);
            $image_source = "../images/page/" . $main_logo;
            $thumb_logo = $njFileObj->resizeImage($image_source, $filename, $thumbPathToSave);
            $data['image'] = $main_logo;
        }
        $data['title'] = $_POST['title'];
       $data['description'] = $_POST['description'];  
        $data['meta_title'] = $_POST['meta_title'];
        $data['meta_description'] = $_POST['meta_description'];
        $data['alt_text'] = $_POST['alt_text'];
        $url = trim($_POST['url']);
        $custom_url = explode(" ", $url);
        $custom_url = implode("-", $custom_url);
        $data['url'] = strtolower($custom_url);
        $data['status'] = '1';
        $data['added_on'] = $dates;
        $conditions = " `id`='" . base64_decode($_POST['id']) . "'";
        unset($_POST['id']);
        $dbComObj->editData($conn, $table, $data, $conditions);
        echo "Redirect : Page updated successfully. URL " . ADMIN_URL . "page/page_list.php";
    } else {
        echo "Error : Page already exist.";
    }
}



if ($_POST['todo_delete_page']) {
    $id = $_REQUEST['todo_delete_page'];
    $sql2 = "SELECT *  FROM page_content where id = '$id'";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        $rowU = mysqli_fetch_array($result2);
        $condition = "`id` = '" . $id . "'";
        $dbComObj->deleteData($conn, $table, $condition);
        echo 'Page Removed Successfully';
    } else {
        echo 'Error';
    }
}
?>