<?php
$uploadDir = 'uploads/';
$allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    foreach ($_FILES["fileToUpload"]["tmp_name"] as $key => $tmpName) {
        $fileName = $_FILES["fileToUpload"]["name"][$key];
        $filePath = $uploadDir . basename($fileName);
        $fileType = pathinfo($filePath, PATHINFO_EXTENSION);

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($tmpName, $filePath)) {
                addWatermark($filePath, $fileType);
            } else {
                echo "Gagal meng-upload file: $fileName.<br>";
            }
        } else {
            echo "Hanya file JPG, JPEG, PNG, & GIF yang diperbolehkan: $fileName.<br>";
        }
    }
    echo "Semua gambar telah di-upload dan watermark telah ditambahkan. <a href='display.php'> Lihat </a>";
}

function addWatermark($filePath, $fileType) {
    $watermarkText = "Rumah Joglo Dian Mustika";
    $image = null;

    switch ($fileType) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($filePath);
            break;
        case 'png':
            $image = imagecreatefrompng($filePath);
            break;
        case 'gif':
            $image = imagecreatefromgif($filePath);
            break;
    }

    if ($image) {
        $textColor = imagecolorallocatealpha($image, 255, 255, 255, 50); // putih dengan opacity 50%
        $fontPath = realpath('JAWAPALSU.TTF'); // Gantilah dengan path font TrueType Anda
        $fontSize = 50;
        $x = imagesx($image) - 900; // Posisi X watermark
        $y = imagesy($image) - 300;  // Posisi Y watermark

        // Tambahkan watermark dengan rotasi 30 derajat
        imagettftext($image, $fontSize, 40, $x, $y, $textColor, $fontPath, $watermarkText);

        switch ($fileType) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($image, $filePath);
                break;
            case 'png':
                imagepng($image, $filePath);
                break;
            case 'gif':
                imagegif($image, $filePath);
                break;
        }
        imagedestroy($image);
    }
}
?>
