<?php
    use Illuminate\Support\Facades\Config;

    function uploadImage($folder, $image) {
        $ext = strtolower($image->extension());
        $filename = time().rand(100,999).'.'.$ext;
        $image->getClientOriginalName = $filename;
        $image->move($folder, $filename);

        return $filename;
    }
?>