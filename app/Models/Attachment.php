<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Intervention\Image\Facades\Image;

class Attachment extends Model
{
    use HasFactory;


    public static function createFromPath(string $path): Attachment {
        $pathInfo = pathinfo($path);
        $extension = $pathInfo['extension'];
        $newName = sha1($path) . '.' . $extension;
        $newPath = 'attachments/' . $newName;

        $disk = Storage::disk();
        if(!$disk->exists('attachments')) {
            $disk->makeDirectory('attachments');
        }

        $image = Image::make($path);
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk()->put($newPath, $image->encode('jpg', 75)->getEncoded());

        $att = new Attachment();
        $att->path = $newPath;
        $att->save();

        return $att;
    }
}
