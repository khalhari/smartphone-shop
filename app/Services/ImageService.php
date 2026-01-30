<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * Upload and optimize product image
     */
    public function uploadProductImage(UploadedFile $image, $productId)
    {
        // Validate image type
        $this->validateImage($image);

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = "products/{$productId}";

        // Create optimized versions
        $this->createThumbnail($image, $path, $filename);
        $this->createMediumSize($image, $path, $filename);
        $fullPath = $this->createFullSize($image, $path, $filename);

        return $fullPath;
    }

    private function validateImage(UploadedFile $image)
    {
        // Check file size
        if ($image->getSize() > 2097152) { // 2MB
            throw new \Exception('Die Bildgröße darf 2MB nicht überschreiten.');
        }

        // Check MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($image->getMimeType(), $allowedMimes)) {
            throw new \Exception('Ungültiger Bildtyp. Nur JPEG, PNG und WebP sind erlaubt.');
        }

        // Check image dimensions
        list($width, $height) = getimagesize($image->getRealPath());
        if ($width < 500 || $height < 500) {
            throw new \Exception('Das Bild muss mindestens 500x500 Pixel groß sein.');
        }
    }

    private function createThumbnail($image, $path, $filename)
    {
        $img = Image::make($image);
        $img->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        });
        $img->encode('jpg', 80);
        Storage::disk('public')->put("{$path}/thumb_{$filename}", $img);
    }

    private function createMediumSize($image, $path, $filename)
    {
        $img = Image::make($image);
        $img->fit(500, 500, function ($constraint) {
            $constraint->upsize();
        });
        $img->encode('jpg', 85);
        Storage::disk('public')->put("{$path}/medium_{$filename}", $img);
    }

    private function createFullSize($image, $path, $filename)
    {
        $img = Image::make($image);
        $img->fit(1000, 1000, function ($constraint) {
            $constraint->upsize();
        });
        $img->encode('jpg', 90);
        $fullPath = "{$path}/{$filename}";
        Storage::disk('public')->put($fullPath, $img);
        return $fullPath;
    }

    public function deleteProductImages($productId)
    {
        Storage::disk('public')->deleteDirectory("products/{$productId}");
    }
}
