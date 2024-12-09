<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../page_fragment/define.php';
include ('../../page_fragment/dbConnect.php');
include ('../../page_fragment/dbGeneral.php');
include ('../../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

$ServiceID=$_POST['ServiceID'];
$SrNo=$_POST['SrNo'];
$LanguageID=$_POST['LanguageID'];
$Speciality=$_POST['Speciality'];
$GenderOfInterpreter=$_POST['GenderOfInterpreter'];
$BookingAddressPostCode=$_POST['BookingAddressPostCode'];

 

	function getLatLongFromPostalCode($postalCode) {
		$postalCode = str_replace(' ', '', $postalCode);
  $url = 'https://api.postcodes.io/postcodes/' .$postalCode;
 
$response = file_get_contents($url);

if ($response === false) {
    // Handle error
   // echo "Error fetching data";
} else {
    // Process the response
  //  echo $response;
}

 
    if (!empty($response)) {
        $data = json_decode($response);
        if (isset($data->result->latitude) && isset($data->result->longitude)) {
            return array(
                'lat' => $data->result->latitude,
                'lon' => $data->result->longitude
            );
        } else {
            return null;
        }
    } else {
        return null;
    }
		
		
}
	
	function calculateDistance($coords1, $coords2) {
 
 
 
	 
	$lat1=	$coords1['lat'] ;
		$lon1= $coords1['lon'];
		$lat2=$coords2['lat'];
		$lon2= $coords2['lon'];
    $earthRadius = 6371;  
		 
    $dLat = deg2rad($lat2 - $lat1);
 
    $dLon = deg2rad($lon2 - $lon1);
	//	 echo   "  ".$coords1 ."  " .$coords2 ;
		//echo "\n";
 //echo   "  ".$dLat ."  " .$dLat ;
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c; 
       $distance=    $distance * 0.621371;
		
	 
		return $distance*1.2  ;   ///1.2 is buffere ratio
}
	
	
	   function getServiceid($name){
	if ($name=="Interpret"){
		return 1;
	}
		if ($name=="TelephoneInterpreting" || $name=="TeleInterpreting" ){
		return 6;
	}	
					if ($name=="RemoteVideoInterpret"){
		return 8;
	}	
					
				}


  $Specialty = $_POST['Speciality'];
		 
			  $serviceid = getServiceid($_POST['ServiceID']);
 
			 $lngid =   $_POST["LanguageID"];
  $serviceidquery = "
    SELECT linguistservices.*, linguistslogin.PostCode 
    FROM linguistservices
    JOIN linguistslogin ON linguistservices.InterpreterID = linguistslogin.InterpreterID
    WHERE linguistservices.ServiceID = $serviceid 
    AND linguistservices.LanguageID = $lngid
	      
    AND linguistslogin.fullName NOT LIKE 'x-%'
    AND (linguistslogin.PoliceCheck = 'yes' OR linguistslogin.PoliceCheck = 'Yes')
    AND (linguistslogin.Status = 'yes' OR linguistslogin.Status = 'Yes')
    " . ($GenderOfInterpreter === 'Either' ? '' : "AND linguistslogin.GenderofInterpreter = '$GenderOfInterpreter'");
      
 // Append the specialty-specific conditions
if ($Specialty == "1") {
    $serviceidquery .= " AND Medical = -1";
} elseif ($Specialty == "2") {
    $serviceidquery .= " AND Court = -1";
} elseif ($Specialty == "6") {
    $serviceidquery .= " AND MentalHealth = -1";
} elseif ($Specialty == "5") {
    $serviceidquery .= " AND SocialServices = -1";
} elseif ($Specialty == "31") {
    $serviceidquery .= " AND ChildProtection = -1";
} elseif ($Specialty == "33") {
    $serviceidquery .= " AND Business = -1";
}
			  
 //echo $serviceidquery;
$timesheetfire = mysqli_query($conn, $serviceidquery);
 //	echo "....\n";

$totalData = mysqli_num_rows($timesheetfire);

$available_linguists =array();
//echo $totalData;
	if ($totalData > 0) {
	 
$available_linguists ='';
		
		  $counter =0;
		
		$coords1 = getLatLongFromPostalCode($BookingAddressPostCode);

		 
	while ($select_timesheet_row = mysqli_fetch_array($timesheetfire)) {
		//print_r($select_timesheet_row);
	
		//echo "....\n";
	   // echo $counter;
	//	$counter=$counter+1;
		$total_milage1 =0;
		
		$usedExiting = false;
		$fromadd = $BookingAddressPostCode;
	 
	 	
		$InterpreterID  = $select_timesheet_row['InterpreterID'];
		$toadd   = $select_timesheet_row['PostCode'];
 if ($serviceid==1){ 
	 $coords2 = getLatLongFromPostalCode($toadd);
	 

	
	 if ($coords1 !== null && $coords2 !== null) {
			$total_milage1 = calculateDistance($coords1,$coords2);

//echo $total_milage1." ___  ".$toadd ." __  ".$InterpreterID."\n";

			  
if ((!empty($total_milage1) || $total_milage1 == 0) && $total_milage1 < 51) {
	             $available_linguists .= $InterpreterID . ',';
 
	        }	
	 }
	
	  }
			else {
			 $available_linguists .= $InterpreterID . ',';

			}
		}
		// echo "available_linguists".$available_linguists;
 
			   $queryinsert ="UPDATE bookings
	SET available_linguists = '$available_linguists'
	WHERE SrNo = $SrNo";
	$queryinsert = mysqli_query($conn, $queryinsert);
if($queryinsert){
 echo "updated";
}
		else {
		  echo "fail";
		}
 
		}


		$dbConObj->dbClose($conn);	
?>