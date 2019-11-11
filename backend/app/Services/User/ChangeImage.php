<?php

namespace App\Services\User;

use App\Contracts\Image\SaveFileContract;
use App\Contracts\User\ChangeImageContract;
use App\User;
use \Illuminate\Http\UploadedFile;

class ChangeImage implements ChangeImageContract
{

    private $saveFileContract;

    public function __construct(SaveFileContract $saveFileContract)
    {
        $this->saveFileContract = $saveFileContract;
    }


    public function changeImage(string $type, User $user, UploadedFile $file)
    {
        $imagePath = $this->saveFileContract->saveFile($file);
        switch ($type) {
            case self::AVATAR:
                $user->avatar = $imagePath;
                $user->saveOrFail();
                break;
            case self::BACKGROUND_IMAGE:
                $user->background_image = $imagePath;
                $user->saveOrFail();
                break;
        }

        return $imagePath;
    }
}
