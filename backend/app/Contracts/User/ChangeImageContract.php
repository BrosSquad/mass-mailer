<?php

namespace App\Contracts\User;

use App\User;
use Illuminate\Http\UploadedFile;

interface ChangeImageContract {
    public const BACKGROUND_IMAGE = 'background';
    public const AVATAR = 'avatar';

    public function changeImage(string $type, User $user, UploadedFile $file);
}
