<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 0 0 10px;
        }
        .content ul {
            list-style-type: none;
            padding: 0;
        }
        .content ul li {
            background-color: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $booking->ClientClientName }},</p>
            <p>Your booking has been successfully created with the following details:</p>
            <ul>
                <li><strong>Client ID:</strong> {{ $ClientID }}</li>
                <li><strong>Booking ID:</strong> {{ $Booking_id }}</li>
                <li><strong>Date of Job:</strong> {{ $booking->DateOfJOb }}</li>
                <li><strong>Time of Job:</strong> {{ $booking->TimeOfJob }}</li>
                <li><strong>Start Time:</strong> {{ $booking->StartTime }}</li>
                <li><strong>Finish Time:</strong> {{ $booking->FinishTime }}</li>
                <li><strong>Time of Arrival:</strong> {{ $booking->TimeOfArrival }}</li>
                <li><strong>Interpreter ID:</strong> {{ $booking->InterpreterID }}</li>
                <li><strong>Language:</strong> {{ $booking->Language1ID }}</li>
                <li><strong>Service ID:</strong> {{ $booking->ServiceID }}</li>
                <li><strong>Cost Centre Code:</strong> {{ $booking->CostCentreCode }}</li>
                <li><strong>Booking Person Email:</strong> {{ $booking->BookingPersonEmail }}</li>
                <li><strong>Contact Person Email:</strong> {{ $booking->contactPersonEmail }}</li>
                <li><strong>Budget Holder Email:</strong> {{ $booking->BudgetHolderEmail }}</li>
                <li><strong>Email of Feedbacker:</strong> {{ $booking->EmailofFeedbacker }}</li>
                <li><strong>Contact Number:</strong> {{ $booking->ContactNumber }}</li>
                <li><strong>Budget Holder Contact:</strong> {{ $booking->BudgetHolderContact }}</li>
                <li><strong>Gender of Interpreter:</strong> {{ $booking->GenderOfInterpreter }}</li>
                <li><strong>Client Job Reference Number:</strong> {{ $booking->ClientJobReferenceNumber }}</li>
                <li><strong>Specialty:</strong> {{ $booking->Specialty }}</li>
                <li><strong>Appointment:</strong> {{ $booking->appointment }}</li>
                <li><strong>Appointment Type:</strong> {{ $booking->appointment_type }}</li>
                <li><strong>Attendees:</strong> {{ $booking->attendees }}</li>
                <li><strong>End User Email:</strong> {{ $booking->EndUserEmail }}</li>
                <li><strong>End User Mobile:</strong> {{ $booking->EndUserMobile }}</li>
                <li><strong>Booking Address Post Code:</strong> {{ $booking->BookingAddressPostCode }}</li>
            </ul>
            <p>If you have any questions or need further assistance, please contact us at support@example.com.</p>
            <p>Thank you for your booking!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
