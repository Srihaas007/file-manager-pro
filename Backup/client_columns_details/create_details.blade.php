<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client Column Metadata</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            margin-bottom: 20px;
        }
        .form-section h4 {
            margin-bottom: 15px;
        }
        .remove-btn {
            cursor: pointer;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Create Client Column Metadata</h1>
        <form action="{{ route('columns.store') }}" method="POST">
            @csrf
            <div id="columns-container">
                <div class="form-section" data-index="0">
                    <h4>Column 1</h4>
                    <div class="form-group">
                        <label for="column_name_0">Column Name</label>
                        <input type="text" class="form-control" id="column_name_0" name="columns[0][column_name]" required>
                    </div>
                    <div class="form-group">
                        <label for="data_type_0">Data Type</label>
                        <select class="form-control" id="data_type_0" name="columns[0][data_type]" required>
                            <option value="string">String</option>
                            <option value="integer">Integer</option>
                            <option value="boolean">Boolean</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="length_0">Length</label>
                        <input type="number" class="form-control" id="length_0" name="columns[0][length]" min="1">
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_boolean_0" name="columns[0][is_boolean]" onchange="toggleBooleanOptions(this)">
                        <label class="form-check-label" for="is_boolean_0">Is Boolean</label>
                    </div>
                    <div class="form-group d-none" id="boolean_options_0">
                        <label for="true_value_0">True Value</label>
                        <input type="text" name="columns[0][true_value]" id="true_value_0" class="form-control">
                        <label for="false_value_0">False Value</label>
                        <input type="text" name="columns[0][false_value]" id="false_value_0" class="form-control">
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="nullable_0" name="columns[0][nullable]" value="1" onchange="logNullableChange(this)">
                        <label class="form-check-label" for="nullable_0">Nullable</label>
                    </div>
                    
                    <div class="form-group">
                        <label for="default_0">Default Value</label>
                        <input type="text" class="form-control" id="default_0" name="columns[0][default]">
                    </div>

                    <button type="button" class="btn btn-danger remove-btn" onclick="removeColumn(this)">Remove Column</button>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-primary" onclick="addColumn()">Add Column</button>
                <button type="submit" class="btn btn-success">Save Columns</button>
            </div>
        </form>
    </div>

    <script>
        let columnIndex = 1;

        function addColumn() {
            const container = document.getElementById('columns-container');
            const section = document.createElement('div');
            section.className = 'form-section';
            section.dataset.index = columnIndex;
            section.innerHTML = `
                <h4>Column ${columnIndex + 1}</h4>
                <div class="form-group">
                    <label for="column_name_${columnIndex}">Column Name</label>
                    <input type="text" class="form-control" id="column_name_${columnIndex}" name="columns[${columnIndex}][column_name]" required>
                </div>
                <div class="form-group">
                    <label for="data_type_${columnIndex}">Data Type</label>
                    <select class="form-control" id="data_type_${columnIndex}" name="columns[${columnIndex}][data_type]" required>
                        <option value="string">String</option>
                        <option value="integer">Integer</option>
                        <option value="boolean">Boolean</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="length_${columnIndex}">Length</label>
                    <input type="number" class="form-control" id="length_${columnIndex}" name="columns[${columnIndex}][length]" min="1">
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="is_boolean_${columnIndex}" name="columns[${columnIndex}][is_boolean]" onchange="toggleBooleanOptions(this)">
                    <label class="form-check-label" for="is_boolean_${columnIndex}">Is Boolean</label>
                </div>
                <div class="form-group d-none" id="boolean_options_${columnIndex}">
                    <label for="true_value_${columnIndex}">True Value</label>
                    <input type="text" name="columns[${columnIndex}][true_value]" id="true_value_${columnIndex}" class="form-control">
                    <label for="false_value_${columnIndex}">False Value</label>
                    <input type="text" name="columns[${columnIndex}][false_value]" id="false_value_${columnIndex}" class="form-control">
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="nullable_${columnIndex}" name="columns[${columnIndex}][nullable]" value="1">
                    <label class="form-check-label" for="nullable_${columnIndex}">Nullable</label>
                </div>
                
                <div class="form-group">
                    <label for="default_${columnIndex}">Default Value</label>
                    <input type="text" class="form-control" id="default_${columnIndex}" name="columns[${columnIndex}][default]">
                </div>

                <button type="button" class="btn btn-danger remove-btn" onclick="removeColumn(this)">Remove Column</button>
            `;
            container.appendChild(section);
            columnIndex++;
        }

        function removeColumn(button) {
            button.parentElement.remove();
        }

        function toggleBooleanOptions(checkbox) {
            const index = checkbox.parentElement.parentElement.dataset.index;
            const booleanOptions = document.getElementById(`boolean_options_${index}`);
            if (checkbox.checked) {
                booleanOptions.classList.remove('d-none');
            } else {
                booleanOptions.classList.add('d-none');
            }
        }

        function updateDataType(select) {
            const index = select.parentElement.parentElement.dataset.index;
            const dataType = select.value;

            const defaultContainer = document.querySelector(`#default_${index}`).parentElement;
            const defaultIntContainer = document.querySelector(`#default_int_${index}`).parentElement;

            if (dataType === 'integer') {
                defaultContainer.classList.add('hidden');
                defaultIntContainer.classList.remove('hidden');
            } else {
                defaultContainer.classList.remove('hidden');
                defaultIntContainer.classList.add('hidden');
            }
        }
        function logNullableChange(checkbox) {
            if (checkbox.checked) {
                console.log(`Column ${checkbox.id.split('_')[1]} is set to nullable (true)`);
            } else {
                console.log(`Column ${checkbox.id.split('_')[1]} is set to not nullable (false)`);
            }
        }
    </script>
</body>
</html>


