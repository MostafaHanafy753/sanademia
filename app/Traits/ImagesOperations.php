<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImagesOperations
{
    public $ORDER_PAYMENT_SCREEN_SHOT_PATH = 'orders/payment-screen-shots';

    public function storeFile($file, $path, $fileName = null, $disk = 'public')
    {
        try {
            if (is_file($file) && !file_exists(public_path($file)) && !is_string($file)) {
                if ($fileName) {
                    $path = $file->storeAs($path, $fileName, ['disk' => $disk]);
                } else {
                    $path = $file->store($path, ['disk' => $disk]);
                }
                if ($disk == 'public') {
                    return 'storage/' . $path;
                }
                return $path;
            } elseif (file_exists(public_path($file))) {
                return $this->move($file, $path, $disk);
            }
            return $file;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function replaceFile($oldFilePath, $newFile, $newFilePath, $disk = 'public')
    {
        try {

            $path = $this->storeFile($newFile, $newFilePath, $disk);
            if ($path) {
                $oldPath = public_path($oldFilePath);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                return $path;
            }

            return null;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function moveFile($oldFilePath, $newFilePath, $disk = 'public')
    {
        try {
            // Validate old file path
            if (!$oldFilePath) {
                throw new \InvalidArgumentException('Old file path is required.');
            }

            // Extract the file name and extension
            $fileName = pathinfo($oldFilePath, PATHINFO_FILENAME);
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $destinationDir = rtrim($newFilePath, '/');

            // Generate a unique file path if the file exists in the destination
            $newFullPath = "$destinationDir/$fileName.$extension";
            $counter = 1;
            $newFullPathNotRepeated=$newFullPath;

            while (Storage::disk($disk)->exists($newFullPathNotRepeated)) {
                $newFullPathNotRepeated = "$destinationDir/{$fileName}_{$counter}.$extension";
                $counter++;
            }
            $oldFilePath = str_replace('storage/', '', $oldFilePath);
            // Check if the old file exists in the specified disk
            if (!Storage::disk($disk)->exists($oldFilePath)) {
                if (Storage::disk($disk)->exists($newFullPath)) {
                    //copy the file to the new path with new name
                    Storage::disk($disk)->copy($newFullPath, $newFullPathNotRepeated);
                }
            } else {
                Storage::disk($disk)->move($oldFilePath, $newFullPathNotRepeated);
            }
            // Move the file to the new unique path

            // Return the public URL of the new file
            return Storage::url($newFullPathNotRepeated);

        }  catch (\Exception $e) {
            // Log and handle other unexpected errors
            Log::error("File move error: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteFile($filePath, $disk = 'public'): bool
    {
        try {
            $oldPath = public_path($filePath);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCollectionOfFiles($filesPaths, $disk = 'public')
    {
        try {
            foreach ($filesPaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink(public_path($filePath));
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function move($sourcePath, $destinationPath, $disk = 'public')
    {
        try {

            $fileName = pathinfo($sourcePath, PATHINFO_BASENAME);

            $sourcePath = str_replace('storage/', '', $sourcePath);
            Storage::disk($disk)->move($sourcePath, $destinationPath . '/' . $fileName);
            return 'storage/' . $destinationPath . '/' . $fileName;
        } catch (\Exception $e) {
            return false;
        }
    }

    function getMediaType($filePath,$disk='public')
    {
        $filePath = str_replace('storage/', '', $filePath);
        // Check if the old file exists in the specified disk
        if (!Storage::disk($disk)->exists($filePath)) {
            //check path extension
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if ($extension == 'mp4' || $extension == 'avi' || $extension == 'flv' || $extension == 'wmv' || $extension == 'mov' || $extension == '3gp' || $extension == 'mkv') {
                return 'video';
            } elseif ($extension == 'mp3' || $extension == 'wav' || $extension == 'wma' || $extension == 'aac' || $extension == 'flac' || $extension == 'm4a') {
                return 'audio';
            } else {
                return 'image';
            }
        } else {

            $mimeType = Storage::disk($disk)->mimeType($filePath);
            $mediaType = explode('/', $mimeType);
            return $mediaType[0];
        }


    }


}
