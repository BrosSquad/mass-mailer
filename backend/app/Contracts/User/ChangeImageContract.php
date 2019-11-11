<?php

namespace App\Contracts\User;

use App\User;
use Closure;
use Exception;
use Illuminate\Http\UploadedFile;
use Throwable;

/**
 * Interface ChangeImageContract
 * @package App\Contracts\User
 */
interface ChangeImageContract
{
    public const BACKGROUND_IMAGE = 'background';
    public const AVATAR = 'avatar';

    /**
     * @param UploadedFile $file
     * @param string $path
     * @param Closure $callback
     * @return mixed
     * @throws Exception
     * @throws Throwable
     */
    public function storeImage(UploadedFile $file, string $path, Closure $callback);

    /**
     * @param string $type
     * @param User $user
     * @param UploadedFile $file
     * @return string
     * @throws Throwable
     */
    public function changeImage(string $type, User $user, UploadedFile $file): string;
}
