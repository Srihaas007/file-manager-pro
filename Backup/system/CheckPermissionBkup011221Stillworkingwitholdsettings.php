<?php

require_once '../../page_fragment/define.php';
include ('../../page_fragment/dbConnect.php');
include ('../../page_fragment/dbGeneral.php');
include ('../../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

if (isset($_POST['BookingID1'])) {
    $BookingID1 = $_REQUEST["BookingID1"];

    $SQL = "SELECT * FROM Clients  WHERE ClientID = $BookingID1 ";

    $result = mysqli_query($conn, $SQL);
    $count = mysqli_num_rows($result);
    $json = array();
    if ($count > 0) {
        $resultArray = mysqli_fetch_assoc($result);

        $json['success'] = 'Success';
        $json['ShowTimeSheetOnline'] = $resultArray['ShowTimeSheetOnline'];
        $json['BudgetHolderName'] = $resultArray['BudgetHolderName'];
        $json['BudgetHolderContact'] = $resultArray['BudgetHolderContact'];
        $json['BudgetHolderEmail'] = $resultArray['BudgetHolderEmail'];
        $json['ClientJobReferenceNumber'] = $resultArray['ClientJobReferenceNumber'];
        $json['DeptOrTypeofCase'] = $resultArray['DeptOrTypeofCase'];
		$json['contactPersonEmail'] = $resultArray['contactPersonEmail'];
        $json['haveclientadmin'] = $resultArray['haveclientadmin'];
		$json['CostCentreCode'] = $resultArray['CostCentreCode'];
		$json['approved_booking'] = $resultArray['approved_booking'];
		$json['reject_booking'] = $resultArray['reject_booking'];
		$json['show_review_inclient'] = $resultArray['show_review_inclient'];
		$json['show_review_inclient_admin'] = $resultArray['show_review_inclient_admin'];
		if($resultArray['haveclientadmin']==1)
		{
		$json['client_admin_password'] = $resultArray['client_admin_password'];
		}
        echo json_encode($json);
    } else {
        $json['success'] = 'Fail';
        echo json_encode($json);
    }
}

if (isset($_POST['ClientId'])) {
    $ClientId = $_REQUEST["ClientId"];
    $ShowTimeSheetOnline = $_REQUEST["ShowTimeSheetOnline"];
    $BudgetHolderName = $_REQUEST["BudgetHolderName"];
    $BudgetHolderContact = $_REQUEST["BudgetHolderContact"];
    $BudgetHolderEmail = $_REQUEST["BudgetHolderEmail"];
    $ClientJobReferenceNumber = $_REQUEST["ClientJobReferenceNumber"];
	 $contactPersonEmail = $_REQUEST["contactPersonEmail"];
    $DeptOrTypeofCase = $_REQUEST["DeptOrTypeofCase"];
    $CostCentreCode = $_REQUEST["CostCentreCode"];
	$haveclientadmin = $_REQUEST["haveclientadmin"];
	$approved_booking = $_REQUEST["approved_booking"];
	$reject_booking = $_REQUEST["reject_booking"];
	$show_review_inclient = $_REQUEST["show_review_inclient"];
	$show_review_inclient_admin = $_REQUEST["show_review_inclient_admin"];
	if($haveclientadmin==1)
	{
		$client_admin_password = $_REQUEST["client_admin_password"];
	}
	else
	{
		$client_admin_password = '';
	}

    $SQL = "UPDATE Clients SET ShowTimeSheetOnline ='$ShowTimeSheetOnline', BudgetHolderName ='$BudgetHolderName', contactPersonEmail ='$contactPersonEmail',BudgetHolderContact ='$BudgetHolderContact',BudgetHolderEmail ='$BudgetHolderEmail',ClientJobReferenceNumber ='$ClientJobReferenceNumber',DeptOrTypeofCase ='$DeptOrTypeofCase',CostCentreCode ='$CostCentreCode',haveclientadmin ='$haveclientadmin',approved_booking ='$approved_booking',reject_booking ='$reject_booking',client_admin_password ='$client_admin_password',show_review_inclient ='$show_review_inclient',show_review_inclient_admin ='$show_review_inclient_admin'  WHERE ClientID = $ClientId ";

    $result = mysqli_query($conn, $SQL);
    $json['success'] = 'Permission set successfully';
    echo json_encode($json);
}
?>