<?php

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

    unset($_SESSION['linguist_username']);
    $username = $_POST['login-email'];
    $password = $_POST['login-password'];
    $table = "ClientsLogin";

    $condition = " `ClientID` = '" . $username . "'";
    $result = $dbComObj->viewData($conn, $table, "*", $condition);
    $num = $dbComObj->num_rows($result);
	
	$table1 = "clients";

    $result1 = $dbComObj->viewData($conn, $table1, "*", $condition);
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
            echo "Error : Password is incorrect123."; /* .$password."==".$row['password'] */
        }
    }
	
        }
    }
	if($num == 0 && $num1 == 0 ){
		echo "Error : User not registered.";
	}
}

if ($mode == "login_linguist") {
    unset($_SESSION['client_username']);
    $username = $_POST['log_user_nm'];
    $password = $_POST['log_pass_nm'];
    $table = "ClientsLogin";


    $condition = " `Email` = '" . $username . "'";
    $result_name = $dbComObj->viewData($conn, "linguistapplication", "*", $condition);
    $num_name = $dbComObj->num_rows($result_name);
    $row_name = $dbComObj->fetch_assoc($result_name);


    $result = $dbComObj->viewData($conn, "LinguistsLogin", "*", $condition);
    $num = $dbComObj->num_rows($result);
    if ($num > 0) {

        $row = $dbComObj->fetch_assoc($result);
      //echo $row['Password']; die;
        $pwd = $row['Password'];
	 	$status = $row['Status']; 
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
             else if ($password == $pwd OR md5($password) == $pwd) {
            $data = array();
            $data['InterpreterID'] = $row['InterpreterID'];
            $data['success'] = 'Success';

            $_SESSION['linguist_username'] = $row['InterpreterID'];
            $_SESSION["Email"] = $row['Email'];
            $_SESSION["Name"] = $row_name['FirstName'];
            json_encode($data);

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

    if ($count1 == 1) {

        $msg = "<html><font face=\"verdana\" size=\"2\">Dear User,<br><br>";
        $msg .= "Please find below your password reminder as requested.<br/><br/>";
        $msg .= "Username: <b>" . $login_rows1['Email'] . "</b><br/><br/>";
        $msg .= "Password: <b>" . $login_rows1['Password'] . "</b><br/><br/>";
        $msg .= "Regards<br/>Absolute Interpreting and Translations Ltd</font></html>";

        try {
            $mail = new PHPMailer();
            $mail->FromName = "Absolute Interpreting";
            $mail->From = "enquiries@absolute-interpreting.co.uk";
            $mail->AddAddress($email, $email);
            $mail->IsHTML(true);                                  // set email format to HTML
            $mail->Body = $msg;
            $mail->Subject = "Your Password";
            $mail->Send();
            echo "Redirect : Password sent successfully. URL " . BASE_URL . "recruitment.php#complete";
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
}