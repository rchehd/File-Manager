<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Deleted Notification</title>
</head>
    <body>
        <h1>File Deleted</h1>
        <p>The following file has been deleted:</p>
        <ul>
            <li><strong>File Name:</strong> {{ $file_name }}</li>
            <li><strong>File Size:</strong> {{ $file_size }} bytes</li>
            <li><strong>Deleted At:</strong> {{ $deleted_at }}</li>
        </ul>
    </body>
</html>
