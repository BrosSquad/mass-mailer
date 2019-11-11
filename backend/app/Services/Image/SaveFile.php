<?php

namespace App\Services\Image;

use App\Contracts\Image\SaveFileContract;
use Carbon\Carbon;
use Exception;
use \Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;

class SaveFile implements SaveFileContract {
    
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }


    public function saveFile(UploadedFile $file): string
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->guessClientExtension();

        if($extension === null) {
            throw new Exception('File type is not recognized');
        }

        $newName = $this->generateNewName($fileName, $extension);

        $this->storage->makeDirectory(storage_path('app/public/images'));

        $path = $file->getPath();

        $exists = $this->storage->exists($path);
        $isMoved = $this->storage->move($path,$this->generateTo($newName));
        
        if(!$isMoved) {
            throw new Exception('File is not moved');
        }

        return asset('storage/' . $newName);
    }


    private function generateNewName(string $clientName, string $extension): string {
        return hash('sha3-256', Carbon::now()->getTimestamp() . '$' .  $clientName) . '.' . $extension;
    }

    private function generateTo(string $fileName): string {
        return  storage_path('app/public/images') . DIRECTORY_SEPARATOR . $fileName; 
    }
}