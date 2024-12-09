<!-- resources/views/metadata/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Metadata Index</title>
</head>
<body>
    <h1>Metadata Index</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($metadata->isEmpty())
        <p>No metadata available.</p>
    @else
        <ul>
            @foreach($metadata as $meta)
                <li>{{ $meta->column_name }}: {{ $meta->client_column_name }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
