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
$table = "menus_web";
//$dates = date("Y-m-d-H-i-s");
//echo $operation;
$operation;
if ($operation == "add_mein_menu") {
    $condition = "parent_id=0 ORDER BY position";
      $result1 = $dbComObj->viewData($conn, $table, "*",$condition);
     while($row=$dbComObj->fetch_array($result1))
     {
         $num=$row['position'];
     }
    $data = array();
    $data['menu_name'] = $_POST['menu_name'];
    $data['url'] = $_POST['menu_url'];
    $data['active'] = '1';
    $data['position'] = $num+1;
    $dbComObj->addData($conn, $table, $data);
    echo "Reload : Menu added successfully.";
} elseif ($operation == "add_sub_menu") {
    $menuid = $_POST['main_menu_id'];
    $condition="active=1 ORDER BY position";
    $result1 = $dbComObj->viewData($conn, $table, "*",$condition);
     while($row=$dbComObj->fetch_array($result1))
     {
         $num=$row['position'];
     }
    $data = array();
    $data['menu_name'] = $_POST['menu_name'];
    $data['url'] = $_POST['menu_url'];
     $data['title'] = $_POST['title'];
    $data['parent_id'] = $menuid;
    $data['active'] = '1';
     $data['position'] = $num+1;
    $dbComObj->addData($conn, $table, $data);
    echo "Reload : Menu added successfully.";
} elseif ($operation == "delete_menu") {
    $id = $_REQUEST['id'];
    $condition = "`id` = '" . $id . "'";
    $dbComObj->deleteData($conn, $table, $condition);
    echo 'Menu Removed Successfully';
} elseif ($operation == "edit_main_menu") {
    $id = $_REQUEST['mainmenuid'];
    $data['menu_name'] = $_POST['menu_name'];
    $data['url'] = $_POST['menu_url'];
    $conditions = "id=$id";
    $dbComObj->editData($conn, $table, $data, $conditions);
    echo "Reload : Menu updated successfully.";
} elseif ($operation == "edit_child_menu") {
    $id = $_REQUEST['submenuid'];
    $data['menu_name'] = $_POST['menu_name'];
     $data['title'] = $_POST['title'];
    $data['url'] = $_POST['menu_url'];
   $menuid = $_POST['main_menu_id']; 
     $data['parent_id'] = $menuid;
    $conditions = "id=$id";
    $dbComObj->editData($conn, $table, $data, $conditions);
    echo "Reload : Menu updated successfully.";
} elseif ($operation == "change_status") {
    $id = $_REQUEST['id'];
    $condition="`id` = $id";
    $result1 = $dbComObj->viewData($conn, $table, "*",$condition);
    $num = $dbComObj->num_rows($result1);
    if($num > 0) {
        $row=$dbComObj->fetch_array($result1);
        $status = $row['active'];
        if($status == '1') {
            $new_status = '0';
        }else {
            $new_status = '1';
        }
    $data['active'] = $new_status;
    $conditions = "`id` = $id";
    $dbComObj->editData($conn, $table, $data, $conditions);
    echo "Reload : Status of menu updated successfully.";
    }
}
 