<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Data Management System Documentation</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
    body {
        font-family: Arial, sans-serif;
        padding-top: 55px;
    }

    .navbar {
        background-color: #004d99;
    }

    .navbar-brand, .nav-link {
        color: #ffffff !important;
    }

    .navbar-brand:hover, .nav-link:hover {
        color: #d0e6ff !important;
    }

    .navbar-brand-container {
        text-align: center;
        background-color: #0f2f49;
        color: white;
        padding: 10px 0;
        font-size: 24px; /* Set the font size to 24 pixels */
    }


    .navbar-nav {
        margin: 0 auto;
    }


    .section-heading {
        font-size: 28px;
        font-weight: bold;
        color: #004d99;
        margin: 20px 0;
    }

    .section-content {
        margin-bottom: 30px;
    }

    .footer {
        background-color: #004d99;
        color: #ffffff;
        padding: 20px;
        text-align: center;
    }
    .navbar-expand-lg .navbar-nav .nav-link {
        padding-right: 3.5rem;
        padding-left: 2.5rem;
        font-size: large;
        font-weight: bolder;
    }

    .footer a {
        color: #d0e6ff;
        text-decoration: none;
    }

    .footer a:hover {
        text-decoration: underline;
    }

    .highlight {
        background-color: #d0e6ff;
        border-left: 5px solid #004d99;
        padding: 10px;
        margin-bottom: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    /* Normal Card Styles */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }

    .card-body {
        padding: 15px;
        display: none; /* Initially hidden */
    }

    .card-header {
        padding: 15px;
        background-color: #f8f9fa;
        cursor: pointer;
        user-select: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header:hover {
        background-color: #e2e6ea;
    }

    .card-title {
        color: #004d99;
        font-size: 22px;
        margin-bottom: 15px;
    }

    /* Custom Card Styles */
    .custom-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .custom-card-body {
        padding: 20px;
    }

    .custom-card-title {
        color: #004d99;
        font-size: 22px;
        margin-bottom: 15px;
    }

    /* Method Box Styles */
    .method-box {
        padding: 5px 10px;
        border-radius: 4px;
        color: #ffffff;
        font-weight: bold;
        font-size: 0.75rem; /* Smaller font size */
        text-transform: uppercase;
        margin-right: 1rem;
        display: inline-block;
    }

    .method-post {
        background-color: #49cc90; /* Green for POST */
    }

    .method-get {
        background-color: #17a2b8; /* Teal for GET */
    }

    .method-put {
        background-color: #28a745; /* Green for PUT */
    }

    .method-delete {
        background-color: #dc3545; /* Red for DELETE */
    }

    pre {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
        overflow-x: auto;
    }

    .errors {
        list-style-type: none;
        padding: 0;
    }

    .errors li {
        margin-bottom: 5px;
    }

    @media (max-width: 767px) {
        .section-heading {
            font-size: 24px;
        }

        .card-title, .custom-card-title {
            font-size: 20px;
        }
    }
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#introduction">Introduction</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#features">Key Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#how-it-works">How It Works</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#security">Security and Compliance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#benefits">Benefits for Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#conclusion">Conclusion</a>
            </li>
        </ul>
    </div>
</nav>
<div class="navbar-brand-container">
    <a class="navbar-brand" href="#">Client Data Management System Admin Documentation(Admin Two way Documentation)</a>
</div>


<div class="container">

    <div id="introduction" class="section-content"><br><br>
        <div class="section-heading">Introduction</div>
        <p>The <strong>Client Data Management System</strong> is a cutting-edge solution crafted to handle and manage client-specific data with exceptional efficiency and flexibility. Designed with a focus on security and adaptability, our system provides a seamless experience in data management, ensuring that client data is always up-to-date and accurately reflected across all platforms.</p>
        <p>This documentation will guide you through the key features, operational mechanism, security protocols, and the numerous benefits our system offers, helping you understand how we can meet your data management needs with utmost precision and professionalism.</p>
    </div>

    <div id="features" class="section-content">
        <div class="section-heading">Key Features</div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Dynamic Data Mapping</h5>
                <p><strong>Dynamic Table Mapping:</strong> Our system dynamically maps client-specific columns and tables. This means each client's data structure is tailored to their needs, allowing for real-time adjustments and updates without manual intervention.</p>
                <p><strong>Real-time Updates:</strong> With real-time data updates, you can be assured that all client data is current and accurately represented, improving the efficiency of data management and reducing the risk of errors.</p>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Automated Data Updates</h5>
                <p><strong>Seamless Integration:</strong> Our system automates the process of data transfer and updates between your local database and remote servers, making data management more efficient and less prone to human error.</p>
                <p><strong>Error Handling:</strong> Comprehensive error handling mechanisms ensure that any issues are promptly addressed, minimizing disruptions and maintaining data integrity.</p>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Comprehensive Metadata Management</h5>
                <p><strong>Metadata Storage:</strong> Metadata such as data types, column lengths, and default values are stored and managed securely, allowing the system to accurately process and interpret each data element.</p>
                <p><strong>Flexible Metadata Updates:</strong> Metadata can be adjusted dynamically to accommodate changes in the client's data schema, ensuring that the system remains adaptable to evolving requirements.</p>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Secure Data Handling</h5>
                <p><strong>Database Security:</strong> Our system uses encrypted connections for both local and remote databases, safeguarding data against unauthorized access and ensuring privacy.</p>
                <p><strong>Access Control:</strong> Strict access controls are in place, limiting data access to authorized personnel only and protecting against potential breaches.</p>
                <p><strong>Validation and Sanitization:</strong> All data is validated and sanitized to prevent security threats, including SQL injection and data corruption.</p>
            </div>
        </div>
    </div>

    <div id="how-it-works" class="section-content">
        <div class="section-heading">How It Works</div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Data Mapping and Retrieval</h5>
                <p><strong>Client-Specific Configuration:</strong> Each client's data is configured according to their unique requirements, with our system dynamically mapping client-specific columns and tables based on metadata.</p>
                <p><strong>Data Retrieval:</strong> Data is fetched from the local database, mapped according to the client's metadata, and prepared for further processing or integration into remote systems.</p>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Data Updates</h5>
                <p><strong>Update Mechanism:</strong> Updates are processed through secure API endpoints, with data validation and application conducted efficiently to ensure accuracy.</p>
                <p><strong>Real-Time Synchronization:</strong> Our system ensures that updates are reflected immediately, keeping all databases synchronized and up-to-date.</p>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-body">
                <h5 class="custom-card-title">Error Handling and Logging</h5>
                <p><strong>Comprehensive Logging:</strong> Detailed logs capture all errors and exceptions, enabling rapid identification and resolution of issues.</p>
                <p><strong>Proactive Monitoring:</strong> Continuous monitoring alerts us to potential issues before they impact the client, ensuring a smooth and reliable data management experience.</p>
            </div>
        </div>
    </div>

    <div id="security" class="section-content">
        <div class="section-heading">Security and Compliance</div>
        <div class="highlight">
            <p><strong>Data Encryption:</strong> All sensitive data is encrypted both at rest and during transmission, ensuring the highest level of security and privacy.</p>
            <p><strong>Compliance:</strong> Our system adheres to industry standards and data protection regulations, guaranteeing that your data is handled in accordance with legal and ethical requirements.</p>
            <p><strong>Regular Audits:</strong> We conduct regular security audits and vulnerability assessments to maintain a secure environment and address any potential risks proactively.</p>
        </div>
    </div>

    <div id="benefits" class="section-content">
        <div class="section-heading">Benefits for Clients</div>
        <ul>
            <li><strong>Enhanced Efficiency:</strong> Automated data management processes reduce manual intervention, speeding up operations and minimizing errors.</li>
            <li><strong>Real-Time Updates:</strong> Immediate synchronization of data ensures that your information is always accurate and up-to-date.</li>
            <li><strong>Scalability:</strong> The system is designed to scale with your needs, accommodating growing volumes of data and evolving requirements.</li>
            <li><strong>Improved Security:</strong> Advanced security measures protect your data from unauthorized access and potential breaches.</li>
        </ul>
    </div>

    <div id="conclusion" class="section-content">
        <div class="section-heading">Conclusion</div>
        <p>Our <strong>Client Data Management System</strong> is designed to offer a dynamic, secure, and efficient solution for managing client-specific data. By leveraging cutting-edge technology and adhering to the highest standards of security and compliance, we ensure that your data is managed with the utmost care and precision.</p>
        <p>We are confident that our system will meet your needs and exceed your expectations, providing you with a reliable and adaptable tool for all your data management requirements. Thank you for considering our solution; we look forward to partnering with you for a successful data management experience.</p>
    </div>

</div>

<div class="container">
        <h1>API Documentation</h1>
      
</div>
       
<div class="container">
        <div id="api-endpoints" class="section-content">
            <div class="section-heading">API Endpoints</div>

            <!-- POST /update/cancelled-by-client -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/cancelled-by-client</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates the column mapping when a client cancels an event.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/cancelled-by-client",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "CancelledByClient": "boolean",
        "CancelationReason": "string",
        "CancelationFullname": "string",
        "CancelationContact": "string",
        "ContactCancelled": "string",
        "CancelationPersonEmail": "string"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "Column mapping updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /update/cancelled-by-us -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/cancelled-by-us</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates cancellation details when the event is canceled by us.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/cancelled-by-us",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "CancelledByUs": "boolean",
        "CancelationReason": "string"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "Cancellation details updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /update/cancel-by-interpreter -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/cancel-by-interpreter</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates cancellation details when the event is canceled by the interpreter.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/cancel-by-interpreter",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "CancelByInterpreter": "boolean",
        "CancelationReason": "string"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "Interpreter cancellation details updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /update/dna -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/dna</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates the DNA status of the booking.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/dna",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "DNA": "boolean"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "DNA status updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /update/client-dna -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/client-dna</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates the client's DNA status.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/client-dna",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "ClientDNA": "boolean"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "Client DNA status updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /update/is-confirmed-booking -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/is-confirmed-booking</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates the confirmation status of a booking.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
{
    "method": "POST",
    "url": "/update/is-confirmed-booking",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "IsConfirmedBooking": "boolean"
    }
}
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
{
    "status": "success",
    "message": "Booking confirmation status updated successfully"
}
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                    </ul>
                </div>
            </div>

            <!-- POST /client/metadata -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/client/metadata</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Retrieves metadata for a specific client based on the provided client ID.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
            {
                "method": "POST",
                "url": "/client/metadata",
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer {token}"
                },
                "body": {
                    "client_id": "integer"
                }
            }
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
            {
                "metadata": [
                    {
                        "client_column_name": "string",
                        "data_type": "string",
                        "length": "integer",
                        "is_boolean": "boolean",
                        "nullable": "boolean",
                        "default": "string",
                        "default_int": "integer",
                        "true_value": "string",
                        "false_value": "string"
                    }
                ]
            }
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Client ID is missing or invalid.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                        <li><strong>404 Not Found:</strong> No metadata found for the provided client ID.</li>
                    </ul>
                </div>
            </div>
            <!-- POST /update/column-metadata -->
            <div class="card">
                <div class="card-header" onclick="toggleCard(this)">
                    <span class="method-box method-post">POST</span>
                    <h5 class="card-title">/update/column-metadata</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Updates metadata for a specific column in a table for the given client ID.</p>
                    <p><strong>Request:</strong></p>
                    <pre>
            {
                "method": "POST",
                "url": "/update/column-metadata",
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer {token}"
                },
                "body": {
                    "client_id": "integer",
                    "table_name": "string",
                    "column_name": "string",
                    "data_type": "string",
                    "length": "integer",
                    "is_boolean": "boolean",
                    "nullable": "boolean",
                    "default": "string",
                    "default_int": "integer",
                    "true_value": "string",
                    "false_value": "string"
                }
            }
                    </pre>
                    <p><strong>Response:</strong></p>
                    <pre>
            {
                "status": "success",
                "message": "Column metadata updated successfully."
            }
                    </pre>
                    <p><strong>Errors:</strong></p>
                    <ul class="errors">
                        <li><strong>400 Bad Request:</strong> Missing required fields or invalid data.</li>
                        <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                        <li><strong>404 Not Found:</strong> Table or column not found for the provided client ID.</li>
                    </ul>
                </div>
            </div>
       <!-- POST /insert/data -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-post">POST</span>
        <h5 class="card-title">/insert/data</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Inserts data into an existing table schema for a specific client. No new table schemas are created in the client's database; instead, data is inserted into existing schemas.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "POST",
    "url": "/insert/data",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "client_id": "integer",
        "table_name": "string",
        "data": {
            "column_name": "value"
        }
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "message": "Data inserted successfully into the specified table schema."
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>400 Bad Request:</strong> Invalid input data or missing fields.</li>
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            <li><strong>404 Not Found:</strong> The specified table schema does not exist for the client.</li>
        </ul>
    </div>
</div>

<!-- GET /fetch/table-schema -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-get">GET</span>
        <h5 class="card-title">/fetch/table-schema</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Fetches the saved table schema information from our reference database. This endpoint does not create or delete table schemas in the client's database.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "GET",
    "url": "/fetch/table-schema",
    "headers": {
        "Authorization": "Bearer {token}"
    },
    "params": {
        "client_id": "integer",
        "table_name": "string"
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "schema": {
        "table_name": "string",
        "columns": [
            {
                "name": "string",
                "type": "string"
            }
        ]
    }
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>400 Bad Request:</strong> Invalid request parameters or missing fields.</li>
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            <li><strong>404 Not Found:</strong> The specified schema or client ID does not exist.</li>
        </ul>
    </div>
</div>


<!-- GET /events -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-get">GET</span>
        <h5 class="card-title">/api/create-metadata-table</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Retrieves a list of all events, including table and column metadata, for a specified client.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "GET",
    "url": "/api/create-metadata-table",
    "headers": {
        "Authorization": "Bearer {token}"
    },
    "query_parameters": {
        "client_id": "integer"  // The ID of the client whose event data is to be fetched
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "data": {
        "client_id": "integer",
        "metadata": {
            "tables": [
                {
                    "table_name": "string",
                    "columns": [
                        {
                            "column_name": "string",
                            "data_type": "string",
                            "is_nullable": "boolean"
                        }
                    ]
                }
            ]
        },
        "events": [
            {
                "ClientID": "integer",
                "Table Name": "string",
                "Column Name": "string",
                "Metadata of Columns": "string"
            }
        ]
    }
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            <li><strong>404 Not Found:</strong> No events found for the provided client ID.</li>
            <li><strong>500 Internal Server Error:</strong> An unexpected error occurred.</li>
        </ul>
    </div>
</div>

<!-- PUT /events/{event_id} -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-put">PUT</span>
        <h5 class="card-title">/api/create-metadata-table{event_id}</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Updates the details of a Table and columns, including any relevant metadata associated with the event.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "PUT",
    "url": "/api/create-metadata-table/{ClientID}",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "ClientID": "string",
        "Table Name": "string",
        "COlumns Name": "string"
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "message": "Details updated successfully",
    "data": {
        "event_id": "integer",
        "updated_columns": {
            "Column Name": "string",
            "Metadata of Column": "string",
            "Updated at Time": "string"
        }
    }
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>400 Bad Request:</strong> Invalid input data.</li>
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            <li><strong>404 Not Found:</strong> ClientID not found.</li>
        </ul>
    </div>
</div>

<!-- DELETE /events/{event_id} -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-delete">DELETE</span>
        <h5 class="card-title">/api/create-metadata-table/{event_id}</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Deletes a specific column or table and updates the metadata if necessary.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "DELETE",
    "url": "/api/create-metadata-table/{deleting the Column or Table}",
    "headers": {
        "Authorization": "Bearer {token}"
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "message": "Column or Table deleted successfully",
    "data": {
        "event_id": "integer",
        "remaining_events": [
            {
                "event_id": "integer",
                "event_name": "string",
                "event_date": "string",
                "event_location": "string"
            }
        ]
    }
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            <li><strong>404 Not Found:</strong> Remove not found.</li>
        </ul>
    </div>
</div>

<!-- POST /events -->
<div class="card">
    <div class="card-header" onclick="toggleCard(this)">
        <span class="method-box method-post">POST</span>
        <h5 class="card-title">/api/create-metadata-table</h5>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> Creates a new entry in the database, with metadata provided as part of the request body.</p>
        <p><strong>Request:</strong></p>
        <pre>
{
    "method": "POST",
    "url": "/api/create-metadata-table",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "Submit": "string",
        "Submit_date": "string",
        
    }
}
        </pre>
        <p><strong>Response:</strong></p>
        <pre>
{
    "status": "success",
    "message": "Entry in the database created successfully",
    "data": {
        "ClientID": "integer",
        "Submit": "string",
        "Submit_date": "string",
        "metadata": {
            "tables": [
                {
                    "table_name": "string",
                    "columns": [
                        {
                            "column_name": "string",
                            "data_type": "string",
                            "is_nullable": "boolean"
                        }
                    ]
                }
            ]
        }
    }
}
        </pre>
        <p><strong>Errors:</strong></p>
        <ul class="errors">
            <li><strong>400 Bad Request:</strong> Invalid input data.</li>
            <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
        </ul>
    </div>
</div>

<!-- POST /updatebooking -->
<div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/updatebooking</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Updates an existing booking.</p>
                <p><strong>Request:</strong></p>
                <pre>
{
    "method": "POST",
    "url": "/updatebooking",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    },
    "body": {
        "booking_id": "integer",
        "new_details": "string"
    }
}
                </pre>
                <p><strong>Response:</strong></p>
                <pre>
{
    "status": "success",
    "message": "Booking updated successfully"
}
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                </ul>
            </div>
        </div>
 
<!-- GET /clients/user -->
<div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-get">GET</span>
                <h5 class="card-title">/clients/user</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Retrieves details of the authenticated client.</p>
                <p><strong>Request:</strong></p>
                <pre>
{
    "method": "GET",
    "url": "/clients/user",
    "headers": {
        "Authorization": "Bearer {token}"
    }
}
                </pre>
                <p><strong>Response:</strong></p>
                <pre>
{
    "status": "success",
    "data": {
        "client_id": "integer",
        "client_name": "string",
        "email": "string"
    }
}
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                </ul>
            </div>
        </div>

             <!-- POST /clients/stop-api-access -->
             <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/clients/stop-api-access</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Stops API access for a client.</p>
                <p><strong>Request:</strong></p>
                <pre>
{
    "method": "POST",
    "url": "/clients/stop-api-access",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    }
}
                </pre>
                <p><strong>Response:</strong></p>
                <pre>
{
    "status": "success",
    "message": "API access stopped"
}
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                </ul>
            </div>
        </div>

        <!-- GET /clients/stop-api-access -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-get">GET</span>
                <h5 class="card-title">/clients/stop-api-access</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Stops API access for a client via GET request.</p>
            </div>
        </div>

        <!-- POST /clients/start-api-access -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/clients/start-api-access</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Starts API access for a client.</p>
                <p><strong>Request:</strong></p>
                <pre>
{
    "method": "POST",
    "url": "/clients/start-api-access",
    "headers": {
        "Content-Type": "application/json",
        "Authorization": "Bearer {token}"
    }
}
                </pre>
                <p><strong>Response:</strong></p>
                <pre>
{
    "status": "success",
    "message": "API access started"
}
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
                </ul>
            </div>
        </div>

        <!-- GET /clients/start-api-access -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-get">GET</span>
                <h5 class="card-title">/clients/start-api-access</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Starts API access for a client via GET request.</p>
            </div>
        </div>

        <!-- POST /clients/register -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/clients/register</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Registers a new client.</p>
                <p><strong>Request:</strong></p>
                <pre>
{
    "method": "POST",
    "url": "/clients/register",
    "headers": {
        "Content-Type": "application/json"
    },
    "body": {
        "client_name": "string",
        "email": "string",
        "password": "string"
    }
}
                </pre>
                <p><strong>Response:</strong></p>
                <pre>
{
    "status": "success",
    "message": "Client registered successfully"
}
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>400 Bad Request:</strong> Invalid input data.</li>
                    <li><strong>409 Conflict:</strong> Client already exists.</li>
                </ul>
            </div>
        </div>

        <!-- GET /client/register -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-get">GET</span>
                <h5 class="card-title">/client/register</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Displays the client registration form.</p>
            </div>
        </div>
        <!-- POST /clients/logout -->
    <div class="card">
        <div class="card-header" onclick="toggleCard(this)">
            <span class="method-box method-post">POST</span>
            <h5 class="card-title">/clients/logout</h5>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> Logs out a client.</p><br>
            <p><strong>Request:</strong></p>
            <pre>
{
    "method": "POST",
    "url": "/clients/logout",
    "headers": {
        "Authorization": "Bearer {token}"
    }
}
            </pre>
            <p><strong>Parameters:</strong></p><br>
            <ul>
                <li><strong>Authorization</strong>: Bearer token to authenticate the request (string).</li><br>
            </ul>
            <p><strong>Response:</strong></p>
            <pre>
{
    "status": "success",
    "message": "Client logged out successfully"
}
            </pre>
            <p><strong>Errors:</strong></p><br>
            <ul class="errors">
                <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li>
            </ul>
        </div>
    </div>
        <!-- POST /updatecancelledbyagency -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/updatecancelledbyagency</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Updates a booking status to "cancelled by agency."</p>
                <p><strong>Request:</strong></p>
                <pre>
        {
            "method": "POST",
            "url": "/updatecancelledbyagency",
            "headers": {
                "Content-Type": "application/json",
                "Authorization": "Bearer {token}"
            },
            "body": {
                "ClientID": "integer",
                "Booking_id": "integer",
                "CancelationReason": "integer",
                "CancelationNote": "string"
            }
        }
                </pre>
                <p><strong>Parameters:</strong></p>
                <ul>
                    <li><strong>Authorization</strong>: Bearer token to authenticate the request (string).</li><br>
                    <li><strong>ClientID</strong>: The unique identifier for the client (integer).</li><br>
                    <li><strong>Booking_id</strong>: The unique identifier for the booking (integer).</li><br>
                    <li><strong>CancelationReason</strong>: The reason for cancelling the booking, represented by an integer. Must exist in the `Reasons` table (integer).</li><br>
                    <li><strong>CancelationNote</strong>: Additional notes or details regarding the cancellation (string).</li><br>
                </ul>
                <p><strong>Response:</strong></p>
                <pre>
        {
            "status": "success",
            "message": "Updated as Cancelled by Agency",
            "booking": {
                "ClientID": "integer",
                "Booking_id": "integer",
                "CancelationReason": "integer",
                "CancelationNote": "string"
            }
        }
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>400 Bad Request:</strong> Invalid input data.</li><br>
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li><br>
                    <li><strong>403 Forbidden:</strong> ClientID does not match authenticated client.</li><br>
                    <li><strong>404 Not Found:</strong> Booking ID does not exist.</li><br>
                    <li><strong>422 Unprocessable Entity:</strong> Validation errors in request data, invalid cancellation reason/user type, or booking status conflicts.</li><br>
                    <li><strong>500 Internal Server Error:</strong> An unexpected error occurred.</li><br>
                </ul>
            </div>
        </div>
        

        <!-- POST /updatecancelledbyinterpreter -->
        <div class="card">
            <div class="card-header" onclick="toggleCard(this)">
                <span class="method-box method-post">POST</span>
                <h5 class="card-title">/updatecancelledbyinterpreter</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> Updates a booking status to "cancelled by interpreter."</p>
                <p><strong>Request:</strong></p>
                <pre>
        {
            "method": "POST",
            "url": "/updatecancelledbyinterpreter",
            "headers": {
                "Content-Type": "application/json",
                "Authorization": "Bearer {token}"
            },
            "body": {
                "ClientID": "integer",
                "Booking_id": "integer",
                "CancelationReason": "integer"
            }
        }
                </pre>
                <p><strong>Parameters:</strong></p>
                <ul>
                    <li><strong>Authorization</strong>: Bearer token to authenticate the request (string).</li><br>
                    <li><strong>ClientID</strong>: The unique identifier for the client (integer).</li><br>
                    <li><strong>Booking_id</strong>: The unique identifier for the booking (integer).</li><br>
                    <li><strong>CancelationReason</strong>: The reason for cancelling the booking, represented by an integer. Must exist in the `Reasons` table and be associated with an interpreter (integer).</li><br>
                </ul>
                <p><strong>Response:</strong></p>
                <pre>
        {
            "status": "success",
            "message": "Booking status updated to cancelled by interpreter",
            "booking": {
                "ClientID": "integer",
                "Booking_id": "integer",
                "CancelationReason": "integer"
            }
        }
                </pre>
                <p><strong>Errors:</strong></p>
                <ul class="errors">
                    <li><strong>400 Bad Request:</strong> Invalid input data.</li><br>
                    <li><strong>401 Unauthorized:</strong> Authentication failed or token is missing.</li><br>
                    <li><strong>403 Forbidden:</strong> ClientID does not match authenticated client.</li><br>
                    <li><strong>404 Not Found:</strong> Booking ID does not exist.</li><br>
                    <li><strong>422 Unprocessable Entity:</strong> Validation errors in request data, invalid cancellation reason/user type, or booking status conflicts.</li><br>
                    <li><strong>500 Internal Server Error:</strong> An unexpected error occurred.</li><br>
                </ul>
            </div>
        </div>
    </div>
</div>
            

    <script>
        function toggleCard(header) {
            var cardBody = header.nextElementSibling;
            if (cardBody.style.display === "none" || cardBody.style.display === "") {
                cardBody.style.display = "block";
            } else {
                cardBody.style.display = "none";
            }
        }
    </script>


<footer class="footer">
    <p>&copy; 2024 Absolute-Interpreting and Translating Ltd. All rights reserved. </p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
