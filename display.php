<?php
$uploadDir = 'uploads/';
$images = array_diff(scandir($uploadDir), array('.', '..'));

function getImagePath($filename) {
    return $GLOBALS['uploadDir'] . $filename;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Gambar dengan Watermark</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .gallery img {
            max-width: 100%;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }
        .gallery img:hover {
            transform: scale(1.05);
        }
        .image-container {
            text-align: center;
            width: 200px;
            position: relative;
        }
        .image-container img {
            border-radius: 10px;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            display: none;
        }
        .image-container:hover .delete-btn {
            display: block;
        }
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 10px;
        }
        .lightbox .close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 40px;
            cursor: pointer;
        }
        .lightbox .prev, .lightbox .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            font-size: 30px;
            cursor: pointer;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }
        .lightbox .prev {
            left: 20px;
        }
        .lightbox .next {
            right: 20px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Galeri Gambar dengan Watermark <a href="index.php"> Tambah Foto </a></h1>
    <div class="gallery">
        <?php foreach ($images as $index => $image): ?>
            <?php if (in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg', 'gif'])): ?>
                <div class="image-container">
                    <img src="<?php echo htmlspecialchars(getImagePath($image)); ?>" alt="<?php echo htmlspecialchars($image); ?>" data-index="<?php echo $index; ?>" class="gallery-item">
                    <a href="delete.php?file=<?php echo urlencode($image); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?');">X</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="lightbox" id="lightbox">
        <span class="close" id="close">&times;</span>
        <span class="prev" id="prev">&lt;</span>
        <img id="lightbox-img">
        <span class="next" id="next">&gt;</span>
    </div>

    <script>
        const galleryItems = document.querySelectorAll('.gallery-item');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const closeBtn = document.getElementById('close');
        const prevBtn = document.getElementById('prev');
        const nextBtn = document.getElementById('next');
        let currentIndex = 0;

        galleryItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                currentIndex = index;
                showLightbox();
            });
        });

        closeBtn.addEventListener('click', () => {
            lightbox.style.display = 'none';
        });

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            updateLightboxImage();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % galleryItems.length;
            updateLightboxImage();
        });

        function showLightbox() {
            const imgSrc = galleryItems[currentIndex].src;
            lightboxImg.src = imgSrc;
            lightbox.style.display = 'flex';
        }

        function updateLightboxImage() {
            const imgSrc = galleryItems[currentIndex].src;
            lightboxImg.src = imgSrc;
        }

        window.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                lightbox.style.display = 'none';
            }
        });
    </script>
</body>
</html>
