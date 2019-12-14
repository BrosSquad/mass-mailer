<?php

namespace App\Contracts\User;

use App\User;
use Closure;
use Exception;
use Illuminate\Http\UploadedFile;
use Throwable;

/**
 * Interface ChangeImageContract
 *
 * @package App\Contracts\User
 */
interface ChangeImageContract
{
    public const BACKGROUND_IMAGE = 'background';
    public const AVATAR           = 'avatar';

    /**
     * @throws Exception
     * @throws Throwable
     *
     * @param Closure|null $callback
     * @param         $file
     * @param string  $path
     *
     * @return mixed
     */
    public function storeImage($file, string $path, ?Closure $callback);

    /**
     * @throws Throwable
     *
     * @param User   $user
     * @param        $file
     * @param string $type
     *
     * @return string
     */
    public function changeImage(string $type, User $user, $file): string;
}
