<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function Home() 
    {
        $images = Image::category('home-section')->active()->ordered()->get();

        foreach($images as $image) {
            $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;
        }

        return response()->json([
            'images' => $images
        ]);
    }

    public function About()
    {
        $image = Image::category('about-section')->active()->ordered()->first();
        $content = Content::category('about-section')->active()->first();

        $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;

        return response()->json([
            'image' => $image,
            'content' => $content
        ]);
    }

    public function Signature()
    {
        $images = Image::category('signature-section')->type('image')->active()->ordered()->get();
        $background = Image::category('signature-section')->type('background')->active()->first();

        $background->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $background->file_path;

        foreach($images as $image) {
            $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;
        }

        return response()->json([
            'images' => $images,
            'background' => $background
        ]);
    }
}
