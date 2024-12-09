<?php

require_once '../../page_fragment/define.php';
include ('../../page_fragment/dbConnect.php');
include ('../../page_fragment/dbGeneral.php');
include ('../../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

if (isset($_SESSION['admin_username'])) {
    if ($njGenObj->isNotLoggedInAdmin()) {
        header('Location:' . ADMIN_URL . 'admin_operations.php?mode=' . base64_encode("logout"));
    }
} else {
    header('Location:' . ADMIN_URL . '');
}

$mode = $_REQUEST['a'];

if ($mode == 'list') {
    $requestData = '';
    $requestData = $_REQUEST;
//print_r($requestData);
    $columns = array(
        0 => 'ID',
        1 => 'Content',
        2 => 'URL',
        3 => 'Added On',
        4 => 'Status',
        5 => 'Action',
    );
    $condition = "1";
    $result = $dbComObj->viewData($conn, "linguistofmonth", "*", $condition);
    $totalData = $dbComObj->num_rows($result);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) {
        $condition .= " AND ( id LIKE '" . $requestData['search']['value'] . "%' OR content LIKE '" . $requestData['search']['value'] . "%' OR url LIKE '" . $requestData['search']['value'] . "%')";
    }
    $result = $dbComObj->viewData($conn, "linguistofmonth", "*", $condition);
    $totalData = mysqli_num_rows($result);
    $condition .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
    $result = $dbComObj->viewData($conn, "linguistofmonth", "*", $condition);
    $datasp = array();
    if ($totalData > 0) {
        $i = $requestData['start'];
        while ($data = $dbComObj->fetch_assoc($result)) {
            if ($data['status'] == '1') {
                $textt = 'Active';
                $status = '<span class="label label-sm label-success">Active</span>';
            } else {
                $textt = 'Inactive';
                $status = '<span class="label label-sm label-danger">Inactive</span>';
            }

            $action = '<div class="actions"><div class="btn-group"><a class="btn green-haze btn-outline btn-circle btn-sm" href="' . ADMIN_URL . 'linguistofmonth/?a=' . $data['id'] . '&b=' . $data['status'] . '" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <i class="fa fa-cogs"></i><i class="fa fa-angle-down"></i></a><ul class="dropdown-menu" style="min-width: 100px !important;"><li><a href="' . ADMIN_URL . 'linguistofmonth/linguistofmonth.php?a=' . $data['id'] . '&mode=' . base64_encode('editlinguistofmonth') . '"><i class="fa fa-file-text-o"></i> Edit </a></li><li><a onclick="return deletelinguistofmonth(' . $data['id'] . ');"><i class="fa fa-file-text-o"></i> Delete </a></li></ul></div>';

            $nestedData = array();
            $i++;

            $nestedData[] = $data['id']; //$data['id'];
            $nestedData[] = $data['content'];
            $nestedData[] = $data['url'];
            $nestedData[] = $data['added_on'];
            $nestedData[] = $status;
            $nestedData[] = $action;

            $datasp[] = $nestedData;
        }
    }
    $datasp = ($datasp);
    $json_data = array(
        "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data" => $datasp   // total data array
    );

    echo json_encode($json_data);  // send data as json format
}