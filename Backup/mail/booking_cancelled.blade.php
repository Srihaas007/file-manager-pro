<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancelled</title>
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
            background-color: #f05355;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
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
            <h1>Booking Cancelled</h1>
        </div>
        <div class="content">
            <p>Dear {{ $CancelationFullname }},</p>
            <p>We regret to inform you that your booking with the following details has been cancelled:</p>
            <ul>
                <li><strong>Client ID:</strong> {{ $ClientID }}</li>
                <li><strong>Booking ID:</strong> {{ $Booking_id }}</li>
                <li><strong>Date and Time Cancelled:</strong> {{ $DateTimeCancelled }}</li>
                <li><strong>Reason:</strong> {{ $CancelationReason }}</li>
                <li><strong>Full Name:</strong> {{ $CancelationFullname }}</li>
                <li><strong>Contact:</strong> {{ $CancelationContact }}</li>
                <li><strong>Cancelled By:</strong> {{ $ContactCancelled }}</li>
                <li><strong>Email:</strong> {{ $CancelationPersonEmail }}</li>
            </ul>
            <p>If you have any questions, please contact us at support@example.com.</p>
            <p>Thank you.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
