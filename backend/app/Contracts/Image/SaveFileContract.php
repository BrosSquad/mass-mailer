<?php

namespace App\Contracts\Image;

use Illuminate\Http\UploadedFile;

interface SaveFileContract {
    public function saveFile(UploadedFile $file): string;
}