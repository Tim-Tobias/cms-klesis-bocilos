<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Content;
use App\Models\File;
use App\Models\Image;
use App\Models\Menu;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

    public function Gallery() 
    {
        $images = Image::category('gallery-section')->type('image')->active()->ordered()->get();

        foreach($images as $image) {
            $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;
        }

        $background = Image::category('gallery-section')->type('background')->active()->first();
        $background->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $background->file_path;

        return response()->json([
            'images' => $images,
            'background' => $background
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

    public function Team()
    {
        $images = Image::category('team-section')->active()->ordered()->get();
        $content = Content::category('team-section')->first();

        foreach($images as $image) {
            $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;
        }

        return response()->json([
            'images' => $images,
            'content' => $content
        ]);
    }

    public function Menu()
    {
        $images = Image::category('menu-section')->type('image')->active()->ordered()->get();
        $background = Image::category('menu-section')->type('background')->active()->first();
        $file = File::first();

        $background->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $background->file_path;
        $file->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $file->file_path;

        foreach($images as $image) {
            $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;
        }

        return response()->json([
            'images' => $images,
            'background' => $background,
            'file' => $file,
        ]);
    }

    public function Categories()
    {
        $categories = Category::all();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function TodayMenu(Request $request)
    {
        $query = Menu::query()->with('category');

        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $menus = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'menus' => $menus
        ]);
    }

    public function BlogCategories()
    {
        $categories = BlogCategory::all();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function blog(Request $request)
    {
        $query = Blog::query()->with('category');

        if ($request->has('category') && strtolower($request->category) !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $blogs = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'blogs' => $blogs
        ]);
    }

    public function blogDetail(Request $request, $id)
    {
        $blog = Blog::with('category')->findOrFail($id);

        return response()->json([
            'blog' => $blog
        ]);
    }

    public function socialMedia()
    {
        $socialMedia = SocialMedia::get();

        return response()->json([
            'social_media' => $socialMedia
        ]);
    }

    public function Footer()
    {
        $image = Image::category('footer-section')->type('background')->first();
        $content = Content::category('footer-section')->first();

        $image->file_path = request()->getSchemeAndHttpHost() . '/storage/' . $image->file_path;


        return response()->json([
            'image' => $image,
            'content' => $content
        ]);
    }
}
