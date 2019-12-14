<?php

namespace App\Services\User;

use TypeError;
use RuntimeException;
use Intervention\Image\Image;
use App\Contracts\User\ChangeImageContract;
use App\User;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Contracts\Filesystem\Factory as StorageFactory;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;
use Illuminate\Http\UploadedFile;
use Throwable;

class ChangeImage implements ChangeImageContract
{
    public const HASH_ALGORITHM = 'sha3-256';

    private Storage $storage;

    /**
     * ChangeImage constructor.
     *
     * @param StorageFactory $storageFactory
     */
    public function __construct(StorageFactory $storageFactory)
    {
        $this->storage = $storageFactory->disk('public');
    }

    /**
     * @throws Throwable
     *
     * @param User   $user
     * @param        $file
     * @param string $type
     *
     * @return string
     */
    public function changeImage(string $type, User $user, $file): string
    {
        $path = 'images/';
        switch ($type) {
            case self::AVATAR:
                $path .= 'avatars';
                break;
            case self::BACKGROUND_IMAGE:
                $path .= 'backgrounds';
                break;
        }
        return $this->storeImage(
            $file,
            $path,
            static function (Storage $storage, $imagePath, $fileName) use ($user, $type, $path) {
                switch ($type) {
                    case self::AVATAR:
                        $toDelete = $user->avatar;
                        $user->avatar = $fileName;
                        $saved = $user->save();
                        break;
                    case self::BACKGROUND_IMAGE:
                        $toDelete = $user->background_image;
                        $user->background_image = $fileName;
                        $saved = $user->save();
                        break;
                    default:
                        throw new RuntimeException('Error while saving');
                }

                if (!$saved) {
                    throw new RuntimeException('Error while saving');
                }

                $storage->delete($path . '/' . $toDelete);
                return asset('storage/' . $path . '/' . $fileName);
            }
        );
    }

    /**
     * @throws Exception
     * @throws Throwable
     *
     * @param Closure|null $callback
     * @param              $file
     * @param string       $path
     *
     * @return mixed
     */
    public function storeImage($file, string $path, ?Closure $callback)
    {
        if ($file instanceof Image) {
            $fileName = $file->filename ?? 'sample';
            $extension = $file->extension ?? 'png';
        } elseif ($file instanceof UploadedFile) {
            $fileName = $file->getClientOriginalName();
            $extension = $file->guessClientExtension();
        } else {
            throw new TypeError('File type not recognized');
        }


        if ($extension === null) {
            throw new RuntimeException('File type is not recognized');
        }

        // TODO: Check image extension

        $newName = $this->generateNewName($fileName, $extension);
        $isMoved = false;

        if ($file instanceof Image) {
            $isMoved = $this->storage->put($path . '/' . $newName, $file->stream()->detach());
        } elseif ($file instanceof UploadedFile) {
            $isMoved = $file->storePubliclyAs('public/' . $path, $newName);
        }

        if (!$isMoved) {
            throw new RuntimeException('File is not moved');
        }

        try {
            if ($callback !== null) {
                return $callback($this->storage, $isMoved, $newName);
            }
            return $isMoved;
        } catch (Throwable $e) {
            $this->storage->delete($isMoved);
            throw $e;
        }
    }

    private function generateNewName(string $clientName, string $extension): string
    {
        return hash(self::HASH_ALGORITHM, Carbon::now()->getTimestamp() . '$' . $clientName) . '.' . $extension;
    }
}
