<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .upload-container {
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            max-width: 500px;
            width: 100%;
        }
        .upload-container.dragover {
            border-color: #000;
        }
        input[type="file"] {
            display: none;
        }
        .upload-label {
            cursor: pointer;
            padding: 10px 20px;
            border: 2px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            background-color: #eee;
        }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .loading-overlay .spinner {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .gallery img {
            max-width: 100%;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="upload-container" id="upload-container">
        <h1>Upload Gambar</h1>
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" id="fileToUpload" name="fileToUpload[]" multiple>
            <label for="fileToUpload" class="upload-label">Pilih File atau Seret ke Sini</label>
        </form>
        <div class="gallery" id="gallery"></div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <script>
        const uploadContainer = document.getElementById('upload-container');
        const fileInput = document.getElementById('fileToUpload');
        const gallery = document.getElementById('gallery');
        const uploadForm = document.getElementById('uploadForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        uploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadContainer.classList.add('dragover');
        });

        uploadContainer.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadContainer.classList.remove('dragover');
        });

        uploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();
            uploadContainer.classList.remove('dragover');
            const files = e.dataTransfer.files;
            fileInput.files = files;
            uploadForm.submit();
        });

        fileInput.addEventListener('change', () => {
            uploadForm.submit();
        });

        uploadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(uploadForm);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'upload.php', true);
            loadingOverlay.style.display = 'flex';

            xhr.onload = () => {
                if (xhr.status === 200) {
                    alert('Upload selesai!');
                    loadingOverlay.style.display = 'none';
                    loadGallery();
                } else {
                    alert('Terjadi kesalahan saat upload.');
                    loadingOverlay.style.display = 'none';
                }
            };

            xhr.onerror = () => {
                alert('Terjadi kesalahan saat mengirim data.');
                loadingOverlay.style.display = 'none';
            };

            xhr.send(formData);
        });

      

        loadGallery();
    </script>
</body>
</html>
