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

if ($mode == 'clientlist') {
    $requestData = '';
    $requestData = $_REQUEST;
	//echo '<pre>';
//print_r($requestData);
    $columns = array(
        0 => 'ClientID',
        1 => 'Name'
    );
	$condition = "";
	$SQL = "SELECT `ClientID`, `Name` FROM `clientslogin`";
	$result = mysqli_query($conn, $SQL);
	//$resultArray = mysqli_fetch_assoc($result);
	$totalData = mysqli_num_rows($result);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) {
        $condition .= " WHERE ( ClientID LIKE '" . $requestData['search']['value'] . "%' OR Name LIKE '" . $requestData['search']['value'] . "%')";
    }
    
	$result = mysqli_query($conn, $SQL.' '.$condition);
    $totalData = mysqli_num_rows($result);
    $condition .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
    //echo $SQL.' '.$condition;
	$result = mysqli_query($conn, $SQL.' '.$condition);
    $datasp = array();
    if ($totalData > 0) {
        $i = $requestData['start'];
        while ($data = $dbComObj->fetch_assoc($result)) {
			$permission = '<input type="button" class="btn-warning" name="persmission_button" style="cursor:pointer;" id="persmission_button" onclick="persmission_page('.$data['ClientID'].');" value="View page permission">';
			$nestedData = array();
			
            $nestedData[] = $data['ClientID'];
			$nestedData[] = $data['Name'];
			$nestedData[] = $permission;
            $datasp[] = $nestedData;
			$i++;
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

if ($mode == 'pagelist') {
    $requestData = '';
    $requestData = $_REQUEST;
	//echo '<pre>';
//print_r($requestData);
    $columns = array(
        0 => 'Id',
        1 => 'PageName'
    );
	$condition = "";
	$type = '';
	$typeval = '';
	foreach($_REQUEST as $key=>$value)
	{
		$type =  base64_decode($key);
		$typeval =  base64_decode($value);
		if($type=='cid')
		{
			$clientid = $typeval;
		}
	}

	
	$SQL = "SELECT `Id`, `PageName` FROM `pages_list`";
	$result = mysqli_query($conn, $SQL);
	//$resultArray = mysqli_fetch_assoc($result);
	$totalData = mysqli_num_rows($result);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) {
        $condition .= " WHERE ( Id LIKE '" . $requestData['search']['value'] . "%' OR PageName LIKE '" . $requestData['search']['value'] . "%')";
    }
    
	$result = mysqli_query($conn, $SQL.' '.$condition);
    $totalData = mysqli_num_rows($result);
    $condition .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
    //echo $SQL.' '.$condition;
	$result = mysqli_query($conn, $SQL.' '.$condition);
    $datasp = array();
    if ($totalData > 0) {
        $i = $requestData['start'];
        while ($data = $dbComObj->fetch_assoc($result)) {
			
			
			 $SQL1 = "SELECT `Permission`,`User_Client` FROM `user_page_restrictions` WHERE `User_ID` = ".$clientid." AND `User_Client` = '0' AND `User_Type` = '1' AND `Page_ID` = ".$data['Id'];
			 
			 $result1 = mysqli_query($conn, $SQL1);
			$resultArray = mysqli_fetch_assoc($result1);
			$admclnt=$resultArray['User_Client'];
			$selected='';
			  if($admclnt==0){
								if($resultArray['Permission']==1)
									{
										$selected = 'checked';
								    } 
							 }
			 
			 $permission = '<label><input type="checkbox" name="persmission_button" id="persmission_button_'.$data['Id'].'" onchange="showhidePage('.$data['Id'].','.$clientid.',0)" '.$selected.' value="1"> Show</label>';
			
			 
			 
			 
			 
			 
			 
			 
			  
			  
			  
			  $SQL2 = "SELECT `Permission`,`User_Client` FROM `user_page_restrictions` WHERE `User_ID` = ".$clientid." AND `User_Type` = '1'   AND `User_Client` = '1' AND `Page_ID` = ".$data['Id'];
			 ////query for client
			$result2 = mysqli_query($conn, $SQL2);
			$resultArray2 = mysqli_fetch_assoc($result2);
			$selectedclnt='';
			//echo $resultArray['User_Client'];
			//echo $SQL1;
			$uclnt=$resultArray2['User_Client'];
			//echo ' ^'.$uclnt."*<br>";
			//if(in_array(5,$pageids))
		
			  if($uclnt ==1){
				
						if($resultArray2['Permission']==1)
									{
										$selectedclnt = 'checked';
								    }
			            }
			
			$clientpermission = '<label><input type="checkbox" name="clientpersmission_button" id="clntpersmission_button_'.$data['Id'].'" onchange="showhidePageClient('.$data['Id'].','.$clientid.',1)" '.$selectedclnt.' value="1"> Show</label>';
			
			
			$nestedData = array();
			
            $nestedData[] = $data['Id'];
			$nestedData[] = $data['PageName'];
			$nestedData[] = $permission;
			$nestedData[] = $clientpermission;
            $datasp[] = $nestedData;
			$i++;
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
if(isset($_POST['permission']))
{
	$SQL = "SELECT `PageName` FROM `pages_list` WHERE `Id`= '".$_POST['pageId']."'";
	$result = mysqli_query($conn, $SQL);
	$resultArray = mysqli_fetch_assoc($result);
	         
			// echo "<pre>"; 
			// print_r($_POST);
			// echo "</pre>";
			// die('stop');
			/////////for client
			if($_POST['ucLnt']==1){
				
			 $updatsql = "UPDATE `user_page_restrictions` SET `Permission`='".$_POST['permission']."',`User_Client`='".$_POST['ucLnt']."' WHERE User_ID='".$_POST['clientId']."' AND User_Client='1'  AND Page_ID= '".$_POST['pageId']."'";
			
			$insertsql = "INSERT INTO `user_page_restrictions`(`User_ID`, `User_Type`, `Page_ID`, `Page_Name`, `Permission`,`User_Client`, `Date`) VALUES ('".$_POST['clientId']."','1','".$_POST['pageId']."','".$resultArray['PageName']."','".$_POST['permission']."','".$_POST['ucLnt']."',NOW())";
			
			$SQL1 = "SELECT `Permission` FROM `user_page_restrictions` WHERE User_ID='".$_POST['clientId']."' AND User_Client='1'  AND Page_ID= '".$_POST['pageId']."'";
			$result1 = mysqli_query($conn, $SQL1);
			$resultArray1 = mysqli_num_rows($result1);
				
			
									$res = 0;
								if($resultArray1>0)
								{
									
									$resultsql = mysqli_query($conn, $updatsql);
									$res = 1;
								}
								else
								{
									
									$resultsql = mysqli_query($conn, $insertsql);
									$res = 2;
								}
								
								echo $res;			
				
			}
	
	
	//////////////////for adminclient
	if($_POST['ucLnt']==0){
	 $updatsql = "UPDATE `user_page_restrictions` SET `Permission`='".$_POST['permission']."' WHERE User_ID='".$_POST['clientId']."' AND User_Client='0' AND Page_ID= '".$_POST['pageId']."'";
	
	$insertsql = "INSERT INTO `user_page_restrictions`(`User_ID`, `User_Type`, `Page_ID`, `Page_Name`, `Permission`,`Date`) VALUES ('".$_POST['clientId']."','1','".$_POST['pageId']."','".$resultArray['PageName']."','".$_POST['permission']."',NOW())";
	
	
	$SQL1 = "SELECT `Permission` FROM `user_page_restrictions` WHERE User_ID='".$_POST['clientId']."' AND User_Client='0' AND Page_ID= '".$_POST['pageId']."'";
	$result1 = mysqli_query($conn, $SQL1);
	$resultArray1 = mysqli_num_rows($result1);
	
						$res = 0;
								if($resultArray1>0)
								{
									
									$resultsql = mysqli_query($conn, $updatsql);
									$res = 1;
								}
								else
								{
									
									
									$resultsql = mysqli_query($conn, $insertsql);
									$res = 2;
								}
								
								echo $res;			
	
	
	
	}
	
	
	
}