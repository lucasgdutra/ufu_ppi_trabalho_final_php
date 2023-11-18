<?php

function convertImage($inputPath, $outputPath, $outputFormat = 'webp', $newWidth = null, $newHeight = null)
{
    // Check if the input file exists
    if (!file_exists($inputPath)) {
        return ['success' => false, 'error' => 'Input file does not exist'];
    }

    // $imageType = exif_imagetype($inputPath);
    // if (!$imageType) {
    //     return ['success' => false, 'error' => 'Unsupported image type'];
    // }

    $imageInfo = getimagesize($inputPath);
    if ($imageInfo === false) {
        return ['success' => false, 'error' => 'Unsupported image type'];
    }

    $imageType = $imageInfo[2];

    // Load the original image based on its type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $originalImage = imagecreatefromjpeg($inputPath);
            break;
        case IMAGETYPE_PNG:
            $originalImage = imagecreatefrompng($inputPath);
            break;
        case IMAGETYPE_GIF:
            $originalImage = imagecreatefromgif($inputPath);
            break;
        case IMAGETYPE_WEBP:
            $originalImage = imagecreatefromwebp($inputPath);
            break;
        default:
            return ['success' => false, 'error' => 'Unsupported image type'];
    }

    if (!$originalImage) {
        return ['success' => false, 'error' => 'Failed to load the original image'];
    }

    // Get original dimensions
    $originalWidth = imagesx($originalImage);
    $originalHeight = imagesy($originalImage);

    // Calculate new dimensions
    if (is_null($newWidth) && is_null($newHeight)) {
        $newWidth = $originalWidth;
        $newHeight = $originalHeight;
    } elseif (is_null($newHeight)) {
        $aspectRatio = $originalHeight / $originalWidth;
        $newHeight = $newWidth * $aspectRatio;
    } elseif (is_null($newWidth)) {
        $aspectRatio = $originalWidth / $originalHeight;
        $newWidth = $newHeight * $aspectRatio;
    }

    // Create a new image with new dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    if (!$newImage) {
        imagedestroy($originalImage);
        return ['success' => false, 'error' => 'Failed to create a new image'];
    }

    // Copy and resize the original image onto the new image
    if (!imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight)) {
        imagedestroy($originalImage);
        imagedestroy($newImage);
        return ['success' => false, 'error' => 'Failed to resize the image'];
    }

    // Convert to specified format
    $conversionSuccess = false;
    switch (strtolower($outputFormat)) {
        case 'webp':
            $conversionSuccess = imagewebp($newImage, $outputPath);
            break;
        case 'jpg':
        case 'jpeg':
            $conversionSuccess = imagejpeg($newImage, $outputPath);
            break;
        default:
            return ['success' => false, 'error' => 'Unsupported output format'];
    }

    // Free up memory
    imagedestroy($originalImage);
    imagedestroy($newImage);

    if (!$conversionSuccess) {
        return ['success' => false, 'error' => 'Failed to convert the image'];
    }

    // Return success
    return ['success' => true, 'error' => null];
}

// Example usage
// $result = convertToWebp('image.jpg', 'outputimage.webp', 1920, null);
// if ($result['success']) {
//     echo "Conversion successful!";
// } else {
//     echo "Error: " . $result['error'];
// }
