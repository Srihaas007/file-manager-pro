<?php
 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once 'page_fragment/define.php';
include ('page_fragment/dbConnect.php');
include ('page_fragment/dbGeneral.php');
include ('page_fragment/njGeneral.php');
require 'PHPMailer-master/PHPMailerAutoload.php';
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();
 
$mode = "";
if (isset($_POST['mode'])) {
    $mode = base64_decode($_POST['mode']);
	
    unset($_POST['mode']);
} elseif (isset($_GET['mode'])) {
    $mode = base64_decode($_GET['mode']);
    unset($_GET['mode']);
}
if ($mode == "login_client") {
    //print_r($_POST);
    unset($_SESSION['linguist_username']);
    $username = $_POST['login-email'];
    $password = $_POST['login-password'];
    $table = "ClientsLogin";
/*
    $condition = " `ClientID` = '" . $username . "'";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
	$table1 = "clients";
    $result1 = $dbComObj->viewData($conn, $table1, "*", $condition);
	*/
		
 $stmt = $conn->prepare('SELECT * FROM ClientsLogin WHERE ClientID = ?');
if (!$stmt) {
    die('Error during prepare: ' . $conn->error);
}

$stmt->bind_param('s', $username);

if (!$stmt->execute()) {
    die('Error during execute: ' . $stmt->error);
}

$result = $stmt->get_result();
    $num = $dbComObj->num_rows($result);
	 $stmt1 = $conn->prepare('SELECT * FROM clients WHERE ClientID = ?');
 
if (!$stmt1) {
    die('Error during prepare: ' . $conn->error);
}
$stmt1->bind_param('s', $username);

if (!$stmt1->execute()) {
    die('Error during execute: ' . $stmt1->error);
}
$result1 = $stmt1->get_result();
	
	
	
    $num1 = $dbComObj->num_rows($result1);
    if ($num > 0) {

        $row = $dbComObj->fetch_assoc($result);
//        echo $row['Password']; die;
        $pwd = $row['Password'];
 
        if ($password == $pwd OR md5($password) == $pwd) {
            //echo "1";die();
            $data = array();
            $data['InterpreterID'] = $row['ClientID'];
            $data['success'] = 'Success';

            $_SESSION['client_username'] = $row['ClientID'];
            $_SESSION['client_name'] = $row['Name'];
            $_SESSION['haveclientadmin'] = 0;
			$_SESSION['client_role'] = '1';

            json_encode($data);

            echo "Redirect : Logged in successfully. URL " . CLIENT_URL . "upcoming_booking.php";
        } else {
			//echo "2";die();
            if ($num1 > 0) {
                $row1 = $dbComObj->fetch_assoc($result1);
                //echo $row1['client_admin_password']; die;
                $pwd1 = $row1['client_admin_password'];
                if ($password == $pwd1 OR md5($password) == $pwd1) {
                    $data = array();
                    $data['InterpreterID'] = $row1['ClientID'];
                    $data['success'] = 'Success';

                    $_SESSION['client_username'] = $row1['ClientID'];
                    $_SESSION['client_name'] = 'Client Admin';
                    $_SESSION['haveclientadmin'] = $row1['haveclientadmin'];
                    $_SESSION['client_role'] = '2';

                    json_encode($data);

                    echo "Redirect : Logged in successfully. URL " . CLIENT_URL . "upcoming_booking.php";
                } else {
                    echo "Error : Password is incorrect."; /* .$password."==".$row['password'] */
                }
            }
	
        }
    }
	if($num == 0 && $num1 == 0 ){
		echo "Error : User not registered.";
	}
}
                                                                 //////////////linguist_pincode////////////////
if ($mode == "linguist_pincode") {
    //print_r($_POST);
 
    $pincode= $_POST['pin_code'];
  
	  $username =      isset($_SESSION["Email"])? $_SESSION["Email"]:$_POST['Email'];

 

$stmt = $conn->prepare('SELECT * FROM linguistslogin WHERE Email = ? AND OTP = ?');
 
 if (!$stmt) {
    die('Error during prepare: ' . $conn->error);
}
 
$stmt->bind_param('ss', $username,$pincode);

if (!$stmt->execute()) {
    die('Error during execute: ' . $stmt->error);
}

$result = $stmt->get_result();
    $num = $dbComObj->num_rows($result);
	
	
 
    if ($num > 0) {
		 
        $row = $dbComObj->fetch_assoc($result);

           $data = array();
            $data['InterpreterID'] = $row['InterpreterID'];
            $data['success'] = 'Success';
 $sqlUpdate = "UPDATE linguistslogin SET OTP = '$%%$£%^)&%$£' WHERE InterpreterID = ".$row['InterpreterID'];
    $conn->query($sqlUpdate);
            $_SESSION['linguist_username'] = $row['InterpreterID'];
            $_SESSION["Email"] = $row['Email'];
            $_SESSION["Name"] = $row_name['FirstName'];
            json_encode($data);
echo "Redirect : Logged in successfully. URL " . BASE_URL . "/Portal/LinguistsPortal/unreturned_timesheets.php";   
	}
	if($num == 0  ){
		echo "Error :Wrong pin code";
	}
}
																		//////////////////////////////////
if ($mode == "login_linguist") {
	
				 
    unset($_SESSION['client_username']);
    $username = $_POST['log_user_nm'];
    $password = $_POST['log_pass_nm'];
    $table = "ClientsLogin";


    $condition = " `Email` = '" . $username . "'";
   // $result_name = $dbComObj->viewData($conn, "linguistapplication", "*", $condition);
	
	$stmt = $conn->prepare('SELECT * FROM linguistapplication WHERE Email = ?');
if (!$stmt) {
    die('Error during prepare: ' . $conn->error);
}

$stmt->bind_param('s', $username);

if (!$stmt->execute()) {
    die('Error during execute: ' . $stmt->error);
}

$result_name = $stmt->get_result();
	
    $num_name = $dbComObj->num_rows($result_name);
    $row_name = $dbComObj->fetch_assoc($result_name);


   // $result = $dbComObj->viewData($conn, "LinguistsLogin", "*", $condition);
	
		$stmt1 = $conn->prepare('SELECT * FROM LinguistsLogin WHERE Email = ?');
if (!$stmt1) {
    die('Error during prepare: ' . $conn->error);
}

$stmt1->bind_param('s', $username);

if (!$stmt1->execute()) {
    die('Error during execute: ' . $stmt1->error);
}

$result = $stmt1->get_result();
	
    $num = $dbComObj->num_rows($result);
	$result = "select * from LinguistsLogin where Email = '" . $username . "'";
    $result = mysqli_query($conn, $result);
	
 
    $num = mysqli_num_rows($result);
    // $num = $dbComObj->num_rows($frgt_data);;
    if ($num > 0) {

        $row = $dbComObj->fetch_assoc($result);
      //echo $row['Password']; die;
        $pwd = $row['Password'];
			$status = $row['Status']; 
			$InterpreterID=	$row['InterpreterID'];

		if ($status == 'No') {
			//echo "Your account has been deactivated. If you are now available for booking then please email enquiries@absolute-interpreting.co.uk and ask for your acount to be reactivated.";
			echo "Welcome back!<br> 
It seems you had previously informed us that you were no longer available for Interpreting Bookings. If this has changed now then please contact us at jobs@absolute-interpreting.co.uk and notify us of your availability.
";
		}
        else if ($status == '2BAssessed/Trained'  ) {
			echo "You cannot log on to Linguists Portal until you have fully completed your registration. Please contact HR at jobs@absolute-interpreting.co.uk to help you complete your application first.";
		}
		else if ($status == ''  ) {
			echo "You can only login to Linguists Portal after you have fully completed your registration and assessment with our HR. For more information please email Jobs@absolute-interpreting.co.uk or call 0121 270 6801 ";
		}
		else if ($InterpreterID == 0  ) {
			echo "Your ID has not been allocated.Please contact us at jobs@absolute-interpreting.co.uk";
		}
             else if ($password == $pwd || md5($password) == $pwd) {
            $data = array();
            $data['InterpreterID'] = $row['InterpreterID'];
            $data['success'] = 'Success';

            $_SESSION['linguist_username'] = $row['InterpreterID'];
            $_SESSION["Email"] = $row['Email'];
            $_SESSION["Name"] = $row_name['FirstName'];
            json_encode($data);
				 
 		 
$otp = generateOTP();
  $email=$username;
  
  $msg = "<html><font face=\"verdana\" size=\"2\">Dear User,<br><br>";
        $msg .= "Your One-Time Password (OTP) for login is:<br/><br/>";
        $msg .= " $otp<br/><br/>";
        //$msg .= "Password: <b>" . $login_rows1['Password'] . "</b><br/><br/>";
        $msg .= " <b> Please use this OTP to complete your login process.

Note: Do not share your OTP with anyone. It is valid for a single use.<br/>";

        $msg .= "Regards<br/>Absolute Interpreting and Translations Ltd</font></html>";
/*
 try {
            $mail = new PHPMailer();
	    
					     $mail->Host  = 'smtp.ionos.co.uk';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@absolute-interpreting.co.uk';
        $mail->Password   = 'u63PT77!R5vEacg';
			$mail->Port = 25; // or 587
            $mail->FromName = "Absolute Interpreting";
            $mail->From = "enquiries@absolute-interpreting.co.uk";
            $mail->AddAddress($email, $email);
            $mail->IsHTML(true);                                  // set email format to HTML
          	$mail->isSMTP();
		    $mail->AddAddress($email, 'Your Login OTP');
			$mail->Body = $msg;
            $mail->Subject = "Your Login OTP";
            $mail->Send();
	 $sqlUpdate = "UPDATE linguistslogin SET OTP = '$otp' WHERE InterpreterID = ".$row['InterpreterID'];
    $conn->query($sqlUpdate);
echo 'A One-Time Password (OTP) has been sent to your email. Please enter this OTP to log in.';
        } catch (Exception $e) {
 echo 'Error Sending OTP Please try again later'; 
             
        }
 
 */
            echo "Redirect : Logged in successfully. URL " . BASE_URL . "/Portal/LinguistsPortal/unreturned_timesheets.php";
        } else {
            echo "Error : Password is incorrect."; /* .$password."==".$row['password'] */
        }
    } else {
        echo "Error : User not registered.";
    }
} elseif ($mode == "login_recruit") {
    unset($_SESSION['client_username']);
    $username = $_POST['log_user_rq'];
    $password = $_POST['log_pass_rq'];
    $table = "ClientsLogin";

    $condition = " `Email` = '" . $username . "'";
    $result = $dbComObj->viewData($conn, "LinguistsLogin", "*", $condition);
    $num = $dbComObj->num_rows($result);
	
    if ($num > 0) {

        $row = $dbComObj->fetch_assoc($result);
        $InterpreterID = $row['InterpreterID'];
        $condition_sub = " `InterpreterID` = '" . $InterpreterID . "'";
        $result_sub = $dbComObj->viewData($conn, "Bookings", "*", $condition_sub);
        $num_sub = $dbComObj->num_rows($result_sub);
        if ($num_sub > 0) {
            echo 'Your Application is Already Verified and Completed.';
        } else {
            $pwd = $row['Password'];
            if ($password == $pwd OR md5($password) == $pwd) {
                $data = array();
                $data['InterpreterID'] = $row['InterpreterID'];
                $data['success'] = 'Success';

                $_SESSION['linguist_username'] = $row['InterpreterID'];
                $_SESSION["Email"] = $row['Email'];
                $_SESSION["Name"] = $row['Name'];
                json_encode($data);
		
				
                echo "Redirect : Logged in successfully. URL " . BASE_URL . "Linguists/index.php";
            } else {
                echo "Error : Password is incorrect."; /* .$password."==".$row['password'] */
            }
        }
    } else {
        echo "Error : User not registered.";
    }
} elseif ($mode == "forgotPassword") {

    $email = $_POST["email"];

    $log_query1 = "select * from LinguistsLogin where Email = '" . $email . "'";
    $frgt_data = mysqli_query($conn, $log_query1);
    $count1 = mysqli_num_rows($frgt_data);
    $login_rows1 = mysqli_fetch_array($frgt_data);
    $password = $login_rows1['Password'];
    $subject = '';
    $json = array();

 // if ($count1 == 1) {
    if ($count1 ) {
        $token = md5($emailId).rand(10,9999);
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $update = mysqli_query($conn,"UPDATE LinguistsLogin 
                                             SET 
                                                    reset_link_token = '" . $token . "' 
                                                  , exp_date = '" . $expDate . "' 
                                             WHERE Email='" . $email . "'"
                              );

        $link = "<a href='".BASE_URL."reset-password.php?key=".$email."&amp;token=".$token."'>Click To Reset password</a>";


        $msg = "<html><font face=\"verdana\" size=\"2\">Dear User,<br><br>";
        $msg .= "Click On Below Link to Reset Password.<br/><br/>";
        $msg .= " " . $link . "<br/><br/>";
        //$msg .= "Password: <b>" . $login_rows1['Password'] . "</b><br/><br/>";
        $msg .= " <b> </b><br/><br/>";

        $msg .= "Regards<br/>Absolute Interpreting and Translations Ltd</font></html>";

        try {
                /*
                    //     $mail->Host  = 'smtp.gmail.com';
                    //  $mail->SMTPAuth   = true;
                    //  $mail->Username   = 'absoluteinterpretingpassremndr@gmail.com';
                    //  $mail->Password   = 'otti ambp sein wpaj';
                    
                    //    $mail->Host  = 'smtp.ionos.co.uk';
                    //$mail->SMTPAuth   = true;
                    //$mail->Username   = 'info@absolute-interpreting.co.uk';
                    //$mail->Password   = 'u63PT77!R5vEacg';
                    //$mail->Port = 25; // or 587
                */
            $mail = new PHPMailer();

            $mail->IsHTML(true); // set email format to HTML

            $mail->IsSMTP();
			$mail->SMTPAuth   = false;
			$mail->Host  = 'localhost';
			$mail->setFrom("enquiries@absolute-interpreting.co.uk", 'enquiries@absolute-interpreting.co.uk');
		    $mail->AddAddress($email, 'Password reset');
			$mail->Body = $msg;
            $mail->Subject = "Reset Password";
			
			 if ($mail->send()) {
                echo "Redirect forgot: Password Reset link has been sent. Please check your email and junk or spam folder. URL " . BASE_URL . "linguists-login.php#complete";
            } else {
				 echo "Error: Please try again later";
                return false; // Email sending failed
            }
         
        } catch (Exception $e) {
//            $json['success'] = $e->getMessage();
            echo "Error : Mail Not Sent";
        }
    } else {
        echo "Error : Please Enter Valid Email Address";
    }
} elseif ($mode == "logout") {
    unset($_SESSION['client_username']);
    unset($_SESSION['linguist_username']);
    unset($_SESSION['Email']);
    unset($_SESSION["Name"]);
    unset($_SESSION['client_name']);
    session_destroy();
    header('Location:' . BASE_URL);
} elseif ($mode == "change_password") {
    if (isset($_POST['InterpreterID'])) {
        if (isset($_POST['txtNewPass'])) {
            $ins = "UPDATE LinguistsLogin SET Password = '" . $_POST['txtNewPass'] . "', isPasswordChange=1 WHERE InterpreterID='" . $_POST['InterpreterID'] . "' ";
            $queryUpdate = mysqli_query($conn, $ins);
            echo "Redirect : Password updated successfully. URL " . BASE_URL . "/Portal/LinguistsPortal/unreturned_timesheets.php";
        } else {
            echo "Password is missing.";
        }
    } else {
        echo "Something went wrong, please re-try.";
    }
}else if ($mode == "reset_password_linguist"){
    if(isset($_POST['log_new_pass_nm']) AND isset($_POST['log_re_pass_nm']) AND $_POST['reset_link_token'] AND $_POST['email'])
    {
        if($_POST['log_new_pass_nm'] == $_POST['log_re_pass_nm']) {
            if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/", $_POST["log_new_pass_nm"])) {
                $emailId = $_POST['email'];
                $token = $_POST['reset_link_token'];
                $password = md5($_POST['log_new_pass_nm']);
                $get_query = "SELECT * 
                          FROM linguistslogin 
                          WHERE `reset_link_token`='" . $token . "' 
                            and `email`='" . $emailId . "'";
                //echo $get_query;
                $query = mysqli_query($conn, $get_query);
                $row = mysqli_num_rows($query);
                if ($row) {
					$sql = "UPDATE linguistslogin SET Password='" . $password . "', reset_link_token=NULL, exp_date=NULL WHERE email='" . $emailId . "'";
                    mysqli_query($conn,$sql);
                    echo 'Redirect : Congratulations! Your password has been updated successfully. URL ' . BASE_URL . 'linguists-login.php';
                } else {
                    echo "Something goes wrong. Please try again";
                }
            }
            else {
                echo "Your password must include one from each of the above criteria. Please try again";
            }
        }
        else {
            echo 'New Password and Re-New Password donot Match';
        }
    }
    else {
        echo 'Some Required Field is Missing';
    }
}

function generateOTP($length = 6) {
    $characters = '0123456789';
    $otp = '';

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $otp;
}
 