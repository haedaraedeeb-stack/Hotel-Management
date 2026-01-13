<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Upload image and create Image model record
     */
    public function uploadImage(UploadedFile $imageFile, $model, $folder = 'uploads')
    {
        try {
            // Generate unique filename
            $filename = $this->generateUniqueFilename($imageFile);
            
            // Define storage path
            $path = $folder . '/' . $filename;
            
            // Store the file
            Storage::disk('public')->put($path, file_get_contents($imageFile));
            
            // Create image record
            $image = Image::create([
                'path' => $path,
                'imageable_id' => $model->id,
                'imageable_type' => get_class($model),
            ]);

            return $image;
            
        } catch (\Exception $e) {
            Log::error('Failed to upload image: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload multiple images
     */
    public function uploadMultipleImages(array $imageFiles, $model, $folder = 'uploads')
    {
        $uploadedImages = [];
        
        foreach ($imageFiles as $imageFile) {
            if ($imageFile instanceof UploadedFile) {
                $image = $this->uploadImage($imageFile, $model, $folder);
                if ($image) {
                    $uploadedImages[] = $image;
                }
            }
        }
        
        return $uploadedImages;
    }

    /**
     * Delete image file and record
     */
    public function deleteImage(Image $image)
    {
        try {
            // Delete file from storage
            $this->deleteFile($image->path);
            
            // Delete record
            $image->delete();
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to delete image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple images
     */
    public function deleteMultipleImages($imageIds)
    {
        try {
            $images = Image::whereIn('id', $imageIds)->get();
            $deletedCount = 0;
            
            foreach ($images as $image) {
                if ($this->deleteImage($image)) {
                    $deletedCount++;
                }
            }
            
            return $deletedCount;
            
        } catch (\Exception $e) {
            Log::error('Failed to delete multiple images: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Delete all images for a model
     */
    public function deleteModelImages($model)
    {
        try {
            $images = $model->images;
            $deletedCount = 0;
            
            foreach ($images as $image) {
                if ($this->deleteImage($image)) {
                    $deletedCount++;
                }
            }
            
            return $deletedCount;
            
        } catch (\Exception $e) {
            Log::error('Failed to delete model images: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get image URL
     */
    // public function getImageUrl($path)
    // {
    //     if (!$path) {
    //         return null;
    //     }
        
    //     return Storage::disk('public')->url($path);
    // }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = Str::slug($name);
        
        return $name . '_' . time() . '_' . Str::random(10) . '.' . $extension;
    }

    /**
     * Delete file from storage
     */
    private function deleteFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }
        return false;
    }

    /**
     * Move image to new model (change ownership)
     */
    // public function moveImageToModel(Image $image, $newModel)
    // {
    //     try {
    //         $image->update([
    //             'imageable_id' => $newModel->id,
    //             'imageable_type' => get_class($newModel),
    //         ]);
            
    //         return true;
            
    //     } catch (\Exception $e) {
    //         Log::error('Failed to move image: ' . $e->getMessage());
    //         return false;
    //     }
    // }

    /**
     * Copy image to new model
     */
    // public function copyImageToModel(Image $image, $newModel, $newFolder = null)
    // {
    //     try {
    //         // Generate new path if folder is specified
    //         $newPath = $image->path;
    //         if ($newFolder) {
    //             $filename = basename($image->path);
    //             $newPath = $newFolder . '/' . $filename;
                
    //             // Copy file in storage
    //             if (Storage::disk('public')->exists($image->path)) {
    //                 Storage::disk('public')->copy($image->path, $newPath);
    //             }
    //         }
            
    //         // Create new image record
    //         $newImage = Image::create([
    //             'path' => $newPath,
    //             'imageable_id' => $newModel->id,
    //             'imageable_type' => get_class($newModel),
    //         ]);
            
    //         return $newImage;
            
    //     } catch (\Exception $e) {
    //         Log::error('Failed to copy image: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Get images by model type
     */
    // public function getImagesByModelType($modelClass)
    // {
    //     return Image::where('imageable_type', $modelClass)->get();
    // }

    /**
     * Get images for specific model
     */
    // public function getModelImages($model)
    // {
    //     return Image::where('imageable_id', $model->id)
    //                ->where('imageable_type', get_class($model))
    //                ->get();
    // }

    /**
     * Update image path
     */
    // public function updateImagePath(Image $image, $newPath)
    // {
    //     try {
    //         // Delete old file if exists
    //         $this->deleteFile($image->path);
            
    //         // Update record
    //         $image->update(['path' => $newPath]);
            
    //         return true;
            
    //     } catch (\Exception $e) {
    //         Log::error('Failed to update image path: ' . $e->getMessage());
    //         return false;
    //     }
    // }

    /**
     * Validate image file
     */
    // public function validateImage(UploadedFile $imageFile, $maxSize = 5120, $allowedMimes = ['jpeg', 'png', 'jpg', 'gif', 'webp'])
    // {
    //     if (!$imageFile->isValid()) {
    //         return false;
    //     }
        
    //     if ($imageFile->getSize() > $maxSize * 1024) { // Convert KB to bytes
    //         return false;
    //     }
        
    //     $extension = strtolower($imageFile->getClientOriginalExtension());
    //     if (!in_array($extension, $allowedMimes)) {
    //         return false;
    //     }
        
    //     return true;
    // }

    /**
     * Get image storage info
     */
    // public function getStorageInfo()
    // {
    //     $totalSize = 0;
    //     $imageCount = Image::count();
        
    //     $images = Image::all();
    //     foreach ($images as $image) {
    //         if (Storage::disk('public')->exists($image->path)) {
    //             $totalSize += Storage::disk('public')->size($image->path);
    //         }
    //     }
        
    //     return [
    //         'count' => $imageCount,
    //         'total_size' => $totalSize,
    //         'total_size_mb' => round($totalSize / 1024 / 1024, 2),
    //     ];
    // }
}