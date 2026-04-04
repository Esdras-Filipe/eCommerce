<?php

namespace Modules\Shared\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class UploadAchieveS3Service
{
    public function upload(UploadedFile $file, string $path = 'uploads'): string
    {
        $extension = $this->getExtension($file->getMimeType());
        $fileName  = $path . '/' . Str::uuid() . '.' . $extension;

        $inclui = Storage::disk('s3')->put($fileName, file_get_contents($file->getRealPath()));
        if (!$inclui)
            throw new \Exception();

        return $fileName;
    }

    private function getExtension(?string $contentType): string
    {
        return match ($contentType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}
