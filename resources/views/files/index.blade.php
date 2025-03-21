<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .file-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-item:hover {
            background-color: #f1f1f1;
        }

        .file-details {
            flex-grow: 1;
        }

        .file-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .file-info {
            font-size: 0.9rem;
            color: #555;
        }

        .delete-btn {
            background: transparent;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }

        .delete-btn:hover {
            color: #a71d2a;
        }

        .file-actions {
            display: flex;
            align-items: center;
        }

        .file-actions i {
            margin-left: 10px;
        }

        .add-file-btn {
            margin-bottom: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">My files</h1>

    <div class="add-file-btn">
        <a href="{{ route('files.upload') }}" class="btn btn-success">Add file</a>
    </div>

    @if(count($files) > 0)
        @foreach($files as $file)
            @php
                $filePath = storage_path('app/' . $file->path);
                $fileType = pathinfo($file->name, PATHINFO_EXTENSION);
                $fileSizeFormatted = number_format($file->size / 1024 / 1024, 2) . ' MB'; // Перетворюємо в MB
                $uploadTime = \Carbon\Carbon::parse($file->created_at)->format('d.m.Y H:i');
            @endphp
            <div class="file-item">
                <div class="file-details">
                    <div class="file-name">{{ $file->name }}</div>
                    <div class="file-info">
                        <span><strong>Type:</strong> {{ strtoupper($fileType) }} |</span>
                        <span><strong>Size:</strong> {{ $fileSizeFormatted }} |</span>
                        <span><strong>Created at:</strong> {{ $uploadTime }}</span>
                    </div>
                </div>
                <div class="file-actions">
                    <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>There are no files yet.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
