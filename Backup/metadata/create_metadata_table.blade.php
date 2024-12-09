<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Metadata Table</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light grey background for contrast */
        }

        .container {
            max-width: 1200px; /* Increased container width */
            margin-top: 40px; /* Increased top margin */
        }

        .form-section {
            margin-bottom: 30px; /* Increased bottom margin */
            padding: 20px; /* Adjusted padding */
            border: 1px solid #ced4da; /* Slightly darker border color */
            border-radius: 12px; /* Rounded corners for a softer look */
            background-color: #ffffff; /* White background for form sections */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Deeper shadow effect */
        }

        .form-section h4 {
            margin-bottom: 20px; /* Adjusted margin below the header */
            font-size: 1.5rem; /* Adjusted font size */
            font-weight: bold;
        }

        .remove-btn {
            cursor: pointer;
            color: #ffffff;
            font-size: 0.75rem; /* Smaller font size */
            font-weight: bold;
            padding: 0.25rem 0.5rem; /* Reduced padding */
            background-color: #dc3545; /* Red background color */
            border: none;
            border-radius: 4px; /* Smaller border radius */
            width: 80px; /* Fixed width */
            height: 40px; /* Fixed height */
            display: flex; /* Align items in the center */
            justify-content: center;
            align-items: center;
            text-align: center; /* Center text */
        }
        nav {
            background-color: #0f2f49; /* Dark blue color */
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
          
        }

        nav h1 {
            margin: 0;
            font-size: 1.5rem; /* Adjust font size as needed */
            text-align: center;
        }
        /* Note Styles */
        .note {
            margin-top: 15px;
            font-size: 0.875rem;
            color: #6c757d; /* Light gray text color */
        }
        /* Align Add New Table Button and Note */
        .align-buttons {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between button and note */
            margin-bottom: 15px;
        }

        /* Align Save Metadata Button to Right */
        .save-button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        /* Adjust Button Styling */
        .add-button {
            margin-top: 15px;
        }

        .submit-button {
            margin-top: 15px;
        }



        .remove-btn:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .form-group {
            margin-bottom: 15px; /* Adjusted bottom margin */
        }

        .form-check-label {
            margin-left: 1rem; /* Adjusted left margin */
            margin-top: 1.5rem; /* Adjusted top margin */
        }

        .boolean-options {
            display: none;
        }

        .boolean-options.show {
            display: block;
        }

        .add-button, .submit-button {
            margin-top: 20px; /* Increased top margin */
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Adjusted gap between columns */
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 2rem; /* Adjusted bottom margin */
        }

        .form-check-input {
            margin-top: 0;
            margin-left: 0.2rem; /* Slight adjustment */
            margin-top: 1.5rem; /* Adjusted top margin */
        }

        .form-row .form-group {
            margin-bottom: 0;
            flex: 1;
            min-width: 0; /* Prevents form group from growing too large */
        }

        .form-control-sm {
            font-size: 0.875rem; /* Adjusted font size */
            padding: 0.375rem 0.75rem; /* Adjusted padding */
        }

        .modal-content {
            padding: 30px; /* Increased padding */
        }

        .modal-header {
            border-bottom: 2px solid #dee2e6; /* Thicker border */
        }

        .modal-footer {
            border-top: 2px solid #dee2e6; /* Thicker border */
        }

        .btn-custom {
            background-color: #007bff; /* Blue background color */
            border: none;
            color: #fff;
            border-radius: 8px; /* Larger border radius */
            padding: 0.5rem 1rem; /* Increased padding */
            font-size: 0.875rem; /* Adjusted font size */
        }

        .btn-custom:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .btn-danger-custom {
            background-color: #dc3545; /* Red background color */
            border: none;
            color: #fff;
            border-radius: 8px; /* Larger border radius */
            padding: 0.5rem 1rem; /* Increased padding */
        }

        .btn-danger-custom:hover {
            background-color: #c82333; /* Darker red on hover */
        }


    </style>
</head>
<body>
<nav>
    <h1 style="text-align: center;">Absolute Patient Liaison Solution(APLS)</h1>
</nav><br><br><br>
<h2 style="text-align: center;">Please Enter Your Database Table Details.</h2>
    <div class="container mt-4">
        
        <form action="{{ route('metadata.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="client_id">Client ID</label>
                <input type="text" class="form-control form-control-sm" id="client_id" name="client_id" required>
            </div>

            <div id="tables-container">
                <!-- Tables will be added here dynamically -->
            </div>

            <div class="form-group align-buttons">
                <button type="button" class="btn btn-secondary add-button" onclick="addTable()">Add New Table</button>
                <div class="note"><strong style="font-size: larger;"><--</strong>Please start by adding the table name first (click here to add table)</div>
            </div>

            <div class="save-button-container">
                <button type="submit" class="btn btn-success submit-button">Save Metadata</button>
            </div>    <br><br><br><br><br>
        </form>
    </div>

    <script>

    document.getElementById('client_id').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            addTable(); // Call the function to add a table
        }
    });

        let columnIndex = 0;
        const availableColumns = [
            'InterpreterID', 'ClientID', 'DateOfJOb', 'TimeOfJob', 'BookingID', 'StartTime',
            'FinishTime', 'Language1ID', 'IsConfirmedBooking', 'BookingAddressID', 'NoOfHoursBooked',
            'HouseNo', 'BookingAddress1', 'BookingAddress2', 'BookingAddress3', 'BookingAddressPostCode','CancelByInterpreter',
            'CancelledByClient', 'CancelledByUs', 'CancelledBy', 'DateTimeCancelled', 'DNA', 'ClientDNA',
            'EndUserEmail', 'EndUserMobile', 'ClientCaller', 'ContactNumber', 'BookingPersonEmail', 'Officer',
            'contactPersonEmail', 'ServiceID', 'GenderOfInterpreter', 'ClientClientName', 'BudgetHolderName',
            'BudgetHolderContact', 'BudgetHolderEmail', 'DeptOrTypeofCase', 'HealthSafetyHazzards',
            'AnySpecialInstructions', 'TrustServices', 'OtherTrusts', 'OtherNature', 'DoubleBookingDetected',
            'ReasonF2FInterpreterNeeded', 'DateTimeOfBookingConfirmation', 'DateTimeOfBookingConfirmationFirstTime',
            'CancelationReason', 'CancelationFullname', 'CancelationContact', 'ContactCancelled',
            'CancelationPersonEmail', 'appointment', 'appointment_type', 'attendees'
        ];

        const columnDescriptions = {
            'InterpreterID': 'This is the column for Interpreter ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'ClientID': 'This is the column for Client ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'DateOfJOb': 'This is the column for Date Of Job in our table. Please enter the column name from your table related to this entity and their properties.',
            'TimeOfJob': 'This is the column for Time Of Job in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingID': 'This is the column for Booking ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'StartTime': 'This is the column for Start Time in our table. Please enter the column name from your table related to this entity and their properties.',
            'FinishTime': 'This is the column for Finish Time in our table. Please enter the column name from your table related to this entity and their properties.',
            'Language1ID': 'This is the column for Language1 ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'IsConfirmedBooking': 'This is the column for Is Confirmed Booking in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingAddressID': 'This is the column for Booking Address ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'NoOfHoursBooked': 'This is the column for No Of Hours Booked in our table. Please enter the column name from your table related to this entity and their properties.',
            'HouseNo': 'This is the column for House No in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingAddress1': 'This is the column for Booking Address 1 in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingAddress2': 'This is the column for Booking Address 2 in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingAddress3': 'This is the column for Booking Address 3 in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingAddressPostCode': 'This is the column for Booking Address Post Code in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelledByClient': 'This is the column for Cancelled By Client in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelledByUs': 'This is the column for Cancelled By Us in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelledBy': 'This is the column for Cancelled By in our table. Please enter the column name from your table related to this entity and their properties.',
            'DateTimeCancelled': 'This is the column for Date Time Cancelled in our table. Please enter the column name from your table related to this entity and their properties.',
            'DNA': 'This is the column for DNA in our table. Please enter the column name from your table related to this entity and their properties.',
            'ClientDNA': 'This is the column for Client DNA in our table. Please enter the column name from your table related to this entity and their properties.',
            'EndUserEmail': 'This is the column for End User Email in our table. Please enter the column name from your table related to this entity and their properties.',
            'EndUserMobile': 'This is the column for End User Mobile in our table. Please enter the column name from your table related to this entity and their properties.',
            'ClientCaller': 'This is the column for Client Caller in our table. Please enter the column name from your table related to this entity and their properties.',
            'ContactNumber': 'This is the column for Contact Number in our table. Please enter the column name from your table related to this entity and their properties.',
            'BookingPersonEmail': 'This is the column for Booking Person Email in our table. Please enter the column name from your table related to this entity and their properties.',
            'Officer': 'This is the column for Officer in our table. Please enter the column name from your table related to this entity and their properties.',
            'contactPersonEmail': 'This is the column for Contact Person Email in our table. Please enter the column name from your table related to this entity and their properties.',
            'ServiceID': 'This is the column for Service ID in our table. Please enter the column name from your table related to this entity and their properties.',
            'GenderOfInterpreter': 'This is the column for Gender Of Interpreter in our table. Please enter the column name from your table related to this entity and their properties.',
            'ClientClientName': 'This is the column for Client Client Name in our table. Please enter the column name from your table related to this entity and their properties.',
            'BudgetHolderName': 'This is the column for Budget Holder Name in our table. Please enter the column name from your table related to this entity and their properties.',
            'BudgetHolderContact': 'This is the column for Budget Holder Contact in our table. Please enter the column name from your table related to this entity and their properties.',
            'BudgetHolderEmail': 'This is the column for Budget Holder Email in our table. Please enter the column name from your table related to this entity and their properties.',
            'DeptOrTypeofCase': 'This is the column for Dept Or Type of Case in our table. Please enter the column name from your table related to this entity and their properties.',
            'HealthSafetyHazzards': 'This is the column for Health Safety Hazzards in our table. Please enter the column name from your table related to this entity and their properties.',
            'AnySpecialInstructions': 'This is the column for Any Special Instructions in our table. Please enter the column name from your table related to this entity and their properties.',
            'TrustServices': 'This is the column for Trust Services in our table. Please enter the column name from your table related to this entity and their properties.',
            'OtherTrusts': 'This is the column for Other Trusts in our table. Please enter the column name from your table related to this entity and their properties.',
            'OtherNature': 'This is the column for Other Nature in our table. Please enter the column name from your table related to this entity and their properties.',
            'DoubleBookingDetected': 'This is the column for Double Booking Detected in our table. Please enter the column name from your table related to this entity and their properties.',
            'ReasonF2FInterpreterNeeded': 'This is the column for Reason F2F Interpreter Needed in our table. Please enter the column name from your table related to this entity and their properties.',
            'DateTimeOfBookingConfirmation': 'This is the column for Date Time Of Booking Confirmation in our table. Please enter the column name from your table related to this entity and their properties.',
            'DateTimeOfBookingConfirmationFirstTime': 'This is the column for Date Time Of Booking Confirmation First Time in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelationReason': 'This is the column for Cancelation Reason in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelationFullname': 'This is the column for Cancelation Fullname in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelationContact': 'This is the column for Cancelation Contact in our table. Please enter the column name from your table related to this entity and their properties.',
            'ContactCancelled': 'This is the column for Contact Cancelled in our table. Please enter the column name from your table related to this entity and their properties.',
            'CancelationPersonEmail': 'This is the column for Cancelation Person Email in our table. Please enter the column name from your table related to this entity and their properties.',
            'appointment': 'This is the column for appointment in our table. Please enter the column name from your table related to this entity and their properties.',
            'appointment_type': 'This is the column for appointment type in our table. Please enter the column name from your table related to this entity and their properties.',
            'attendees': 'This is the column for attendees in our table. Please enter the column name from your table related to this entity and their properties.'
        };

        function addTable() {
            const container = document.getElementById('tables-container');
            const tableId = `table_${Date.now()}`;
            const newTableName = prompt("Enter the new table name:");
            if (newTableName) {
                const tableSection = document.createElement('div');
                tableSection.className = 'form-section table-container';
                tableSection.id = tableId;
                tableSection.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>${newTableName}</h4>
                        <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeTable('${tableId}')">Remove Table</button>
                    </div>
                    <div id="columns-container-${tableId}">
                        <!-- Columns for ${newTableName} will be added here dynamically -->
                    </div>
                    <input type="hidden" name="tables[${tableId}][table_name]" value="${newTableName}">
                    <button type="button" class="btn btn-primary add-button" onclick="addColumnToTable('${tableId}')">Add Column to ${newTableName}</button>
                `;
                container.appendChild(tableSection);
            }
        }

        function removeTable(tableId) {
            const tableSection = document.getElementById(tableId);
            if (tableSection) {
                tableSection.remove();
            }
        }

        function addColumnToTable(tableId) {
        const container = document.getElementById(`columns-container-${tableId}`);
        const columnSelect = availableColumns.map(col => `<option value="${col}">${col}</option>`).join('');

        const section = document.createElement('div');
        section.className = 'form-section';
        section.innerHTML = `
            <div class="form-row">
                <div class="form-group">
                    <label for="column_name_${columnIndex}">Column Name</label>
                    <select class="form-control form-control-sm" id="column_name_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][column_name]" required>
                        <option value="">Select Column</option>
                        ${columnSelect}
                    </select>
                </div>
                <div class="form-group">
                    <label for="column_value_${columnIndex}">Column Value</label>
                    <input type="text" class="form-control form-control-sm column-value-input" id="column_value_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][column_value]" required>
                </div>
                <div class="form-group">
                    <label for="data_type_${columnIndex}">Data Type</label>
                    <select class="form-control form-control-sm" id="data_type_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][data_type]" required>
                        <option value="string">String</option>
                        <option value="integer">Integer</option>
                        <option value="boolean">Boolean</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="length_${columnIndex}">Length</label>
                    <input type="number" class="form-control form-control-sm" id="length_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][length]" min="1">
                </div>
                <div class="form-group">
                    <label for="default_${columnIndex}">Default Value</label>
                    <input type="text" class="form-control form-control-sm" id="default_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][default]">
                </div>
                <div class="form-group form-check d-flex align-items-center">
                    <input type="checkbox" class="form-check-input" id="is_boolean_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][is_boolean]" onchange="toggleBooleanOptions(this)">
                    <label class="form-check-label" for="is_boolean_${columnIndex}">Is Boolean</label>
                </div>

                <div class="boolean-options" id="boolean_options_${columnIndex}">
                    <div class="form-group">
                        <label for="true_value_${columnIndex}">True Value</label>
                        <input type="text" name="tables[${tableId}][columns][${columnIndex}][true_value]" id="true_value_${columnIndex}" class="form-control form-control-sm" style="width: 100px;">
                    </div>
                    <div class="form-group">
                        <label for="false_value_${columnIndex}">False Value</label>
                        <input type="text" name="tables[${tableId}][columns][${columnIndex}][false_value]" id="false_value_${columnIndex}" class="form-control form-control-sm" style="width: 100px;">
                    </div>
                </div>

                <div class="form-group form-check d-flex align-items-center">
                    <input type="checkbox" class="form-check-input" id="nullable_${columnIndex}" name="tables[${tableId}][columns][${columnIndex}][nullable]" value="1">
                    <label class="form-check-label" for="nullable_${columnIndex}">Nullable</label>
                </div>
                
                <button type="button" class="btn btn-danger remove-btn" onclick="removeColumn(this)">Remove Column</button>
                
            </div><br>
            <div class="form-row">
                <p class="column-description" id="column_description_${columnIndex}"></p>
            </div>
        `;
        container.appendChild(section);
        
        const columnSelectElement = section.querySelector(`#column_name_${columnIndex}`);
        const descriptionElement = section.querySelector(`#column_description_${columnIndex}`);
        columnSelectElement.addEventListener('change', function () {
            const selectedValue = this.value;
            const currentTableColumns = Array.from(container.querySelectorAll('.column-select')).map(select => select.value);
            if (currentTableColumns.filter(col => col === selectedValue).length > 1) {
                alert('Column already selected in this table. Please choose a different column.');
                this.value = '';
                descriptionElement.textContent = '';
            } else {
                descriptionElement.textContent = columnDescriptions[selectedValue] || '';
            }
        });
        columnIndex++;
    }


        function removeColumn(button) {
            button.parentElement.remove();
        }

        function toggleBooleanOptions(checkbox) {
            const index = checkbox.id.split('_')[2];
            const booleanOptions = document.getElementById(`boolean_options_${index}`);
            booleanOptions.classList.toggle('show', checkbox.checked);
        }
    </script>
</body>
</html>
