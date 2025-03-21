<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>File uploading</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                max-width: 500px;
                padding-top: 50px;
            }

            .progress-container {
                margin-top: 20px;
            }

            #error {
                margin-top: 20px;
            }

            #response {
                margin-top: 20px;
                color: green;
            }

            .back-link {
                position: absolute;
                top: 20px;
                left: 20px;
                font-size: 1.5rem;
                color: #007bff;
                text-decoration: none;
                background: transparent;
                border: none;
                cursor: pointer;
            }

            .back-link:hover {
                color: #0056b3;
                text-decoration: none;
            }

            .container {
                padding-top: 40px; /* Місце для стрілочки */
            }
        </style>
    </head>
    <body class="container mt-5">
        <a href="{{ route('files.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to the files
        </a>

        <div class="container">
            <h1 class="text-center mb-4">Upload File</h1>

            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Choose file:</label>
                    <input type="file" class="form-control" name="file" id="file" accept=".pdf,.docx" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Upload</button>
            </form>

            <div id="progressContainer" class="progress-container" style="display:none;">
                <div class="progress">
                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>

            <div id="response" class="alert alert-success" style="display:none;"></div>
            <div id="error" class="alert alert-danger" style="display:none;"></div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

        <script>
        const form = document.getElementById('uploadForm');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressPercent = document.getElementById('progressPercent');
        const responseContainer = document.getElementById('response');
        const errorContainer = document.getElementById('error');
        const fileInput = document.getElementById('file');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear the errors.
            errorContainer.style.display = 'none';
            responseContainer.style.display = 'none';
            responseContainer.innerHTML = '';

            const formData = new FormData(form);
            progressContainer.style.display = 'block';

            const request = new XMLHttpRequest();
            request.open('POST', '/upload', true);

            // Uploading
            request.upload.addEventListener('progress', function(event) {
                if (event.lengthComputable) {
                    const percent = (event.loaded / event.total) * 100;
                    progressBar.style.width = percent + '%';
                    progressBar.setAttribute('aria-valuenow', percent);
                    progressBar.textContent = Math.round(percent) + '%';
                }
            });

            // Processing uploading.
            request.onload = function() {
                if (request.status >= 200 && request.status < 300) {
                    const data = JSON.parse(request.responseText);
                    responseContainer.style.display = 'block';
                    responseContainer.innerHTML = `<strong>File was upload successfully!</strong>`;
                    form.reset();
                    progressContainer.style.display = 'none';
                } else {
                    const errorData = JSON.parse(request.responseText);
                    errorContainer.style.display = 'block';
                    errorContainer.innerHTML = `<strong>Error:</strong> ${errorData.error}`;
                    progressContainer.style.display = 'none';
                }
            };

            // Send data.
            request.send(formData);
        });
    </script>

    </body>
</html>
