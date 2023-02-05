<?php

namespace App\Traits;

trait UploadImage
{
    function upload($image, $folder)
    {
        $imageExtension = $image->getClientOriginalExtension();
        $imageName = time().'.'.$imageExtension;
        $path = $folder;
        $image->move($path, $imageName);
        return $imageName;
    }

}
