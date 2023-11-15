<?php

function convertToWebp($inputPath, $outputPath, $newWidth = null, $newHeight = null)
{
    // Check if the input file exists
    if (!file_exists($inputPath)) {
        return ['success' => false, 'error' => 'Input file does not exist'];
    }

    // Load the original image
    $originalImage = @imagecreatefromjpeg($inputPath);
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

    // Convert to WebP
    if (!imagewebp($newImage, $outputPath)) {
        imagedestroy($originalImage);
        imagedestroy($newImage);
        return ['success' => false, 'error' => 'Failed to convert the image to WebP'];
    }

    // Free up memory
    imagedestroy($originalImage);
    imagedestroy($newImage);

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
