<?php
$uploadDir = 'uploads/';
$images = array_diff(scandir($uploadDir), array('.', '..'));

function getImagePath($filename) {
    return $GLOBALS['uploadDir'] . $filename;
}
?>

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
