<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
require_once 'page_fragment/define.php';
include ('page_fragment/dbConnect.php');
include ('page_fragment/dbGeneral.php');
include ('page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

if (isset($_POST['BookingID2'])) {
//    print_r($_POST); die;
    $isProceed = false;
    $ClientID = $_POST['ClientID'];
    $selecct = mysqli_query($conn, "select ShowTimeSheetOnline from Clients where ClientID ='$ClientID' ");
    $client_data = mysqli_fetch_array($selecct);
    $ShowTimeSheetOnline = $client_data['ShowTimeSheetOnline'];
    $showTimesheetName = '';
    $file_name = $_FILES['uploadTimesheet']['name'];
    if (isset($file_name)) {
        $file_size = $_FILES['uploadTimesheet']['size'];
        $file_tmp = $_FILES['uploadTimesheet']['tmp_name'];
        $file_type = $_FILES['uploadTimesheet']['type'];
        $string = $_FILES["uploadTimesheet"]["name"];
        $lastDot = strrpos($string, ".");
        $string = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);
        $temp = explode(".", $string);
        if (isset($temp[1])) {
            $file_name = $_POST['BookingID2'] . "." . $temp[1];
            UploadFile($file_name, $file_size, $file_tmp, $file_type);
            $showTimesheetName = "uploads/timesheet/" . $file_name;
            $files2 = array("uploads/timesheet/" . $file_name);
        }
    }

    if (isset($_FILES['uploadReceipt'])) {
        $file_name = $_FILES['uploadReceipt']['name'];
        $file_size = $_FILES['uploadReceipt']['size'];
        $file_tmp = $_FILES['uploadReceipt']['tmp_name'];
        $file_type = $_FILES['uploadReceipt']['type'];

        $temp = explode(".", $_FILES["uploadReceipt"]["name"]);
        if (isset($temp[1])) {

            $file_name = $_POST['BookingID2'] . "_" . "Receipt" . "." . $temp[1];

            UploadFile($file_name, $file_size, $file_tmp, $file_type);

            array_push($files2, "uploads/timesheet/" . $file_name);
        }
        $temp = "";
    }

    // if($isProceed)
    // {
    $from_time = strtotime($_POST['starttime']);  // 2012-12-06 23:56
    $to_time = strtotime($_POST['FinishTime']);  // 2012-12-06 00:21
    $NoOfHoursBooked = ($to_time - $from_time) / 60;


    $start_time = strtotime($_POST['WHStartTime']);  // 2012-12-06 23:56
    $end_time = strtotime($_POST['WHFinishTime']);  // 2012-12-06 00:21
    $HoursWorked = ($end_time - $start_time) / 60;

    // to, from, subject, message body, attachment filename, etc.
//    $to = "finance@absolute-interpreting.co.uk";
    $to = "finance@absolute-interpreting.co.uk";
	// $to = "mmfinfotech1075@gmail.com";
    //$to = "enquiries@absolute-interpreting.co.uk";
    // $to = "kp.sandy007@gmail.com";
    $from = "bookings@absolute-interpreting.co.uk";
    $subject = "TimeSheet Form";
    //$message = $message;
    // $filename="Upload/".$file_name;
    // $fname=$file_name;
    //$files2=array(Upload."/".$file_name);
    $message = "<html><body>";
    $message .= "
					 <b>InterpreterID</b>=>" . $_POST['InterpreterID'] . "<br/><br/>
					 <b>ClientID</b>=>" . $_POST['ClientID'] . "<br/><br/>
					 <b>BookingID</b>=>" . $_POST['BookingID2'] . "<br/><br/>
					 <b>DateOfJOb</b>=>" . $_POST['DateOfJObVal'] . "<br/><br/>
					 <b>TimeOfJob</b>=>" . $_POST['TimeOfJob'] . "<br/><br/> 
					 <b>ArrivalTime</b>=>" . $_POST['ArrivalTime'] . "<br/><br/>
					 <b>TimeStart</b>=>" . $_POST['starttime'] . "<br/><br/>
					 <b>FinishTime</b>=>" . $_POST['FinishTime'] . "<br/><br/>
					 <b>WorkHours</b>=>" . $HoursWorked . "<br/><br/>
					 <b>NoOfHoursBooked</b>=>" . $_POST['NoOfHoursBooked'] . "<br/><br/>";

    if (isset($_POST['paid_distance_client'])) {
        $message .= "<b>JournyMilesClient</b>=>" . $_POST['paid_distance_client'] . "<br/><br/>";
    }
    if (isset($_POST['paid_duration_client'])) {
        $message .= "<b>JourneyHours</b>=>" . $_POST['paid_duration_client'] . "<br/><br/>";
    }

    if (isset($_POST['JourneyMiles'])) {
        $message .= "<b>JourneyMiles</b>=>" . $_POST['JourneyMiles'] . "<br/><br/>";
    }
    if (isset($_POST['InterpreterExpenses'])) {
        $message .= "<b>InterpreterExpenses</b>=>" . $_POST['InterpreterExpenses'] . "<br/><br/>";
    }
    if (isset($_POST['TrvlTim4Inter'])) {
        $message .= "<b>TrvlTim4Inter</b>=>" . $_POST['TrvlTim4Inter'] . "<br/><br/>";
    }




    // Added on 23 Dec
    $message .= "
					 <b>QualityOfWork</b>=>" . $_POST['hdnQow'] . "<br/><br/>
					 <b>Attitude</b>=>" . $_POST['hdnAttitude'] . "<br/><br/>
					 <b>Attendance</b>=>" . $_POST['hdnAttendance'] . "<br/><br/>
					 <b>DressCode</b>=>" . $_POST['hdnDresscode'] . "<br/><br/>
					 <b>NoCommentsWasGiven</b>=>" . $_POST['hdnComment'] . "<br/><br/>";


    $message .= "</body></html>";

    multi_attach_mail($to, $subject, $files2, $from, $message, $showTimesheetName);

    $return_milage1 = $_POST['return_milage1'];
    $return_time1   = $_POST['return_time1'];
    $return_milage2 = $_POST['return_milage2'];
    $return_time2   = $_POST['return_time2'];
    $return_milage3 = $_POST['return_milage3'];
    $return_time3   = $_POST['return_time3'];

    $goomiles = round($return_milage2);
    $gootime = round($return_time2);

    $ParkingFee = $_POST['InterpreterExpenses'];

    $Mileage_Client = 0;
    $Duration_Client = 0;

    $Mileage_Linguist = 0;
    $Duration_Linguist = 0;

    if($_POST['IsClientInclusive']){
        $Mileage_Client = 0;
        $Duration_Client = 0;

        $Mileage_Linguist = 0;
        $Duration_Linguist = 0;
    }
    else {
        if($goomiles >= $_POST['AfterHowManyMilesToChargeMileage'] OR is_null($_POST['AfterHowManyMilesToChargeMileage'])){
            //echo "AfterHowManyMilesToChargeMileage = ".$_POST['AfterHowManyMilesToChargeMileage']."<br/>";
            if($_POST['TypeOfTransport']=='Drive'){
                //echo "TypeOfTransport = ".$_POST['TypeOfTransport']."<br/>";
                if(is_null($_POST['AfterHowManyMilesToChargeMileage'])){
                    $Mileage_Client = $goomiles;
                } else {
                    $Mileage_Client = $goomiles-$_POST['AfterHowManyMilesToChargeMileage'];
                }

            } else {
                //echo "Else TypeOfTransport = ".$_POST['TypeOfTransport']."<br/>";
                $Mileage_Client = 0;
            }
        } else {
            //echo "Else AfterHowManyMilesToChargeMileage = ".$_POST['AfterHowManyMilesToChargeMileage']."<br/>";
            $Mileage_Client = 0;
        }
        if($goomiles >= $_POST['ChargeTravelTimeToClientAfter'] OR is_null($_POST['ChargeTravelTimeToClientAfter'])){
            if($_POST['DontChargeTravelTime']) {
                $Duration_Client = 0;
            } else {
                $Duration_Client = $gootime;
            }
        } else {
            $Duration_Client = 0;
        }

        if($_POST['IsInclusiveForInterpreters'])
        {
            $Mileage_Linguist = 0;
            $Duration_Linguist = 0;
        }
        else {

            if($_POST['IsInterpreterPaidInclusive']) {
                $Mileage_Linguist = 0;
                $Duration_Linguist = 0;
            }
            else {
                if ($goomiles >= $_POST['AfterHowManyMilesToPayMileageToLinguist'] OR is_null($_POST['AfterHowManyMilesToPayMileageToLinguist'])) {
                    if($_POST['TypeOfTransport']=='Drive'){
                        if(is_null($_POST['AfterHowManyMilesToPayMileageToLinguist'])){
                            $Mileage_Linguist = $goomiles;
                        } else {
                            $Mileage_Linguist = $goomiles - $_POST['AfterHowManyMilesToPayMileageToLinguist'];
                        }

                    } else {
                        $Mileage_Linguist = 0;
                    }
                } else {
                    $Mileage_Linguist = 0;
                }
                //echo $goomiles .' '. (int)$_POST['PayTravelTimeToInterpreterAfter'];
                if ($goomiles >= (int)$_POST['PayTravelTimeToInterpreterAfter'] OR is_null($_POST['PayTravelTimeToInterpreterAfter'])) {
                    if($_POST['DontChargeTravelTime']) {
                        $Duration_Linguist = 0;
                    } else {
                        $Duration_Linguist = $gootime;
                    }
                } else {
                    $Duration_Linguist = 0;
                }
            }
        }
    }

    // UPDATE RECORD IN DATABASE:
    $sql = "UPDATE Bookings SET TimeOfArrival = '" . $_POST['ArrivalTime'] . "',
				   StartTime = '" . $_POST['starttime'] . "',
				   FinishTime = '" . $_POST['FinishTime'] . "',
				   JourneyMilesTotal = '".$goomiles."',
				   JourneyHours = '" . $Duration_Client . "',
				   JournyMilesClient = '" . $Mileage_Client . "',				   
				   
				   Mileage = '" . $Mileage_Linguist . "',
				   ParkingFee = '" . $ParkingFee . "',
				   TrvlTim4Inter = '" . $Duration_Linguist . "',
				   TimeSheetUploadedOn = '" . date("Y-m-d") . "',
				   QualityOfWork = '" . $_POST['hdnQow'] . "',
				   Attitude = '" . $_POST['hdnAttitude'] . "',
				   Attendance = '" . $_POST['hdnAttendance'] . "',
				   DressCode = '" . $_POST['hdnDresscode'] . "',
				   NoCommentsWasGiven = '" . $_POST['hdnComment'] . "',
				   JSReturned = '-1',
                   PayInterpreter = '-1',TimesheetPath ='" . $showTimesheetName . "'
			WHERE BookingID='" . $_POST['BookingID2'] . "'";
    //echo $sql;
    //exit();
    if (mysqli_query($conn, $sql)) {
        $message = "Your timesheet is submitted sucessfully.";
        header('Content-Type: application/json');
        echo json_encode(array(
           "Status" => "Success",
            "Message" => $message
        ));
    }
//
//
//    $message = "Your timesheet is submitted sucessfully.";
//    //echo "<script type='text/javascript'>alert('$message');</script>";
//    echo $message;
//    //}
}

function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return"";
    }$l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function UploadFile($file_name, $file_size, $file_tmp, $file_type) {
    $formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
    // $name = $_FILES['uploadTimesheet']['name'];
    // $size = $_FILES['uploadTimesheet']['size'];
    // $tmp  = $_FILES['uploadTimesheet']['tmp_name'];
    if (strlen($file_name)) {
        $ext = getExtension($file_name);
        if (is_array($formats) && in_array($ext, $formats)) {
            if ($file_size < (3 * 1024 * 1024)) {
                $imgn = time() . "." . $ext;
                if (move_uploaded_file($file_tmp, "uploads/timesheet/" . $file_name)) {

                    compress_image("uploads/timesheet/" . $file_name, "uploads/timesheet/" . $file_name, 10);

                    $isProceed = true;
                    //echo "File Name : ".$_FILES['uploadTimesheet']['tmp_name'];
                    // echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
                    // echo "<br/>File Size : ".$_FILES['file']['size'];
                    // echo "<br/>File Type : ".$_FILES['file']['type'];
                    // echo "<br/>Image : <img style='margin-left:10px;' src='uploads/timesheet/".$imgn."'>";
                } else {
                    echo "Uploading Failed.";
                    $isProceed = false;
                    exit;
                }
            } else {
                echo "Image File Size is Max 1 MB";
                $isProceed = false;
                exit;
            }
        } else {
            echo "Invalid Image file format.";
            $isProceed = false;
            exit;
        }
    } else {
        echo "Please select an image.";
        $isProceed = false;
        exit;
    }
}

function multi_attach_mail($to, $subject, $files, $sendermail, $message, $showTimesheetName) {
    //this function use for multiple invoice sending
    // email fields: to, from, subject, and so on
    $from = $sendermail;
    $headers = "From: Absolute Interpreting & Translations Ltd<" . $from . ">";
    // boundary 
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
    // multipart boundary 
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"utf-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
    // preparing attachments
    for ($i = 0; $i < count($files); $i++) {
        if (is_file($files[$i])) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($files[$i], "rb");
            $data = @fread($fp, filesize($files[$i]));
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($files[$i]) . "\"\n" .
                    "Content-Description: " . basename($files[$i]) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($files[$i]) . "\"; size=" . filesize($files[$i]) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";

            if ($showTimesheetName != $files[$i]) {
                unlink($files[$i]);
            }
            if($ShowTimeSheetOnline == -1) {
                 unlink($files[$i]);
            }
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $sendermail;
    $ok = mail($to, $subject, $message, $headers, $returnpath);
    if ($ok) {
        return $i;
    } else {
        return 0;
    }
}

function compress_image($source_url, $destination_url, $quality) {
    $info = getimagesize($source_url);
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);
    imagejpeg($image, $destination_url, $quality);
//return $destination_url; 
}
?>
