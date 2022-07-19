<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getImages()
    {
        $images = Image::with('tags')->get();
        return response()->json($images);
    }
    
    public function deleteTag(Request $request) {
        $image = Image::find($request->imageId);
        $image->tags()->detach($request->tagId);
    }

}
