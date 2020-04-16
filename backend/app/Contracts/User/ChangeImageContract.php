<?php

namespace App\Contracts\User;

use Closure;
use App\User;
use Exception;
use Throwable;
use Illuminate\Http\UploadedFile;

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
     * @param  Closure  $callback
     * @param  UploadedFile  $file
     * @param  string  $path
     *
     * @return mixed
     */
    public function store(UploadedFile $file, string $path, Closure $callback);

    /**
     * @throws Throwable
     *
     * @param  User  $user
     * @param  UploadedFile  $file
     * @param  string  $type
     *
     * @return string
     */
    public function update(string $type, User $user, UploadedFile $file): string;
}
