<?php

namespace App\Class;

class Utils
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static function storePhoto($photoRequest, $path): string
    {
        if($photoRequest){
            $image_name = $photoRequest->getClientOriginalName();
            $photo = $photoRequest->storeAs($path,$image_name, 'public');
        }

        return $photo;  
    }
}
