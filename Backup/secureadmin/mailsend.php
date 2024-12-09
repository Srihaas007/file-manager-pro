<?php

require_once '../page_fragment/define.php';
include ('../page_fragment/dbConnect.php');
include ('../page_fragment/dbGeneral.php');
include ('../page_fragment/njGeneral.php');
$dbConObj = new dbConnectsp();
$dbComObj = new dbGeneral();
$njGenObj = new njGeneral();
$conn = $dbConObj->dbConnect();

$InterpreterID = $_REQUEST['InterpreterID'];
$cancelbookingid = $_REQUEST['cancelbookingid'];
$fullname = $_REQUEST['fullname'];
$PersonCancelled = $_REQUEST['PersonCancelled'];
$ContactCancelled = $_REQUEST['ContactCancelled'];
$ReasonCancelled = $_REQUEST['ReasonCancelled'];
$contactno = $_REQUEST['contactno'];
$email_cancel = $_REQUEST['EmailCanceled'];

$lang = "SELECT(SELECT LanguageName FROM languages WHERE LanguageId = Bookings.Language1ID) AS LanguageName,Bookings.* FROM Bookings WHERE BookingID = '" . $_REQUEST['cancelbookingid'] . "'";

$querylang = mysqli_query($conn, $lang);

$selectlang = mysqli_fetch_array($querylang);
$Dateofjob = $selectlang['DateOfJOb'];
$TimeOfJob = $selectlang['TimeOfJob'];
$LanguageName = $selectlang['LanguageName'];
$NoOfHoursBooked = $selectlang['NoOfHoursBooked'];

$BookingAddress = $selectlang['HouseNo'] . " " . $selectlang['BookingAddress1'] . " " . $selectlang['BookingAddress2'] . " " . $selectlang['BookingAddress3'] . " " . $selectlang['BookingAddressPostCode'];

$to = 'mmfinfotech1075@gmail.com';
$subject = 'Cancel Booking ID : ' . $cancelbookingid . ' Client ID :' . $InterpreterID;
$from = 'contact@webprojects.website';

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
$headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
$message = '<html><body>';
$message .= '<p>Dear Absolute Team</p>';
$message .= '<p>The following Booking had been cancelled :</p>';
$message .= '<table>';
$message .= '<tr>';
$message .= '<td align="left"><strong>ClientID : </strong>' . $InterpreterID . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>BookingID :</strong> ' . $cancelbookingid . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Date Of Job:</strong> ' . $Dateofjob . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Time Of Job:</strong> ' . $TimeOfJob . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Language:</strong> ' . $LanguageName . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Booking Address: </strong>' . $BookingAddress . '</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td align="left"><strong>Duration/NoOfHourBooked:</strong> ' . $NoOfHoursBooked . '</td>';
$message .= '</tr>';
$message .= '<br>';
$message .= '<tr>';
$message .= '<td align="left">By:</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Full Name :</strong> ' . $fullname . '</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td align="left"><strong>Contact No.:</strong> ' . $contactno . '</td>';
$message .= '</tr>';


$message .= '<tr>';
$message .= '<td align="left"><strong>Email: </strong>' . $email_cancel . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left">--- - ------- -------- -------- ------- --- ----</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Cancellation Requested By: </strong>' . $PersonCancelled . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Telephone Number of Cancelling Person: </strong>' . $ContactCancelled . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left"><strong>Reason For Cancellation: </strong>' . $ReasonCancelled . '</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td align="left">Please cancel the booking on the System.</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left">This cancellation email sent via the Client Portal.</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="left">With regards</td>';
$message .= '</tr>';

$message .= '<tr>';
$message .= '<td align="left"><strong>Account : </strong>' . $InterpreterID . ' </td>';
$message .= '</tr>';

$message .= '<br>';

$message .= '</table>';
$message .= '</body>';
$message .= '</html>';

if (mail($to, $subject, $message, $headers)) {
    echo 'Your mail has been sent successfully.';
} else {
    echo 'Unable to send email. Please try again.';
}
?>	

