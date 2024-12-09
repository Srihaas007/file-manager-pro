import pandas as pd

# Load the CSV file
file_path = 'C:/xampp3/htdocs/hospital/OnDemandLog.csv'
df = pd.read_csv(file_path)

# Display the actual columns
actual_columns = df.columns.tolist()
print("Actual columns found in CSV file:", actual_columns)

# Define the mapping of actual column names to expected column names
column_mapping = {
    'Call Id': 'CallId',
    'Date/Time': 'Date/Time',
    'Downloaded Time zone': 'Downloaded Time zone',
    'Language 1': 'Language 1',
    'Language 2': 'Language 2',
    'Service Type': 'Service Type',
    'Type': 'Type',
    'Duration': 'Duration',
    'Interpreter Peer Rating': 'Interpreter Peer Rating',
    'Interpreter Call Quality Rating': 'Interpreter Call Quality Rating',
    'Queue Time (s)': 'Queue Time (s)',
    'Call Center Queue/Hold Time (s)': 'Call Center Queue/Hold Time (s)',
    'Other Participants': 'Other Participants',
    'Conference Duration': 'Conference Duration',
    'Pending Duration Updates': 'Pending Duration Updates',
    'Duration Adjusted to 0': 'Duration Adjusted to 0',
    'Call Status': 'Call Status',
    'Call Status (Operator)': 'Call Status (Operator)',
    'CustomFieldKey1': 'CustomFieldKey1',
    'CustomFieldKey2': 'CustomFieldKey2',
    'MyInternalId': 'MyInternalId'
}

# List of required columns in their expected names
required_columns = ['CallId', 'Duration', 'Queue Time (s)', 'Call Status', 'Conference Duration', 'Other Participants']

# Map actual columns to the expected column names
mapped_columns = [column_mapping.get(col, col) for col in actual_columns]

# Check for missing columns based on the mapping
missing_columns = [col for col in required_columns if col not in mapped_columns]

# Output the missing columns
print("Missing required columns:", missing_columns)
