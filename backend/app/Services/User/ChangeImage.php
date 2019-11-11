<?php

namespace App\Services\User;

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
    /**
     * @var Storage
     */
    private $storage;

    /**
     * ChangeImage constructor.
     * @param StorageFactory $storageFactory
     */
    public function __construct(StorageFactory $storageFactory)
    {
        $this->storage = $storageFactory->disk('public');
    }

    /**
     * @param string $type
     * @param User $user
     * @param UploadedFile $file
     * @return string
     * @throws Throwable
     */
    public function changeImage(string $type, User $user, UploadedFile $file): string
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
        return $this->storeImage($file, $path,
            function (Storage $storage, $imagePath, $fileName) use ($user, $type, $path) {
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
                        throw new Exception('Error while saving');
                }

                if (!$saved) {
                    throw new Exception('Error while saving');
                }
                
                $storage->delete($path. '/' . $toDelete);
                return asset('storage/' . $path . '/' . $fileName);
            }
        );
    }

    /**
     * @param UploadedFile $file
     * @param string $path
     * @param Closure $callback
     * @return mixed
     * @throws Exception
     * @throws Throwable
     */
    public function storeImage(UploadedFile $file, string $path, Closure $callback)
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->guessClientExtension();

        if ($extension === null) {
            throw new Exception('File type is not recognized');
        }

        $newName = $this->generateNewName($fileName, $extension);

        $isMoved = $file->storePubliclyAs('public/' . $path, $newName);

        if (!$isMoved) {
            throw new Exception('File is not moved');
        }

        try {
            return $callback($this->storage, $isMoved, $newName);
        } catch (Throwable $e) {
            $this->storage->delete($isMoved);
            throw $e;
        }

    }

    private function generateNewName(string $clientName, string $extension): string
    {
        return hash('sha3-256', Carbon::now()->getTimestamp() . '$' . $clientName) . '.' . $extension;
    }
}
