<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Http\Requests\HomeSectionCreateRequest;
use App\Http\Requests\HomeSectionUpdateRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GallerySectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery_images = Image::category('gallery-section')
                            ->active()
                            ->type('image')
                            ->ordered()
                            ->get();

        
        $background = Image::category('gallery-section')->type('background')->active()->first();
        

        return view('modules.dashboard.gallery.index', compact('gallery_images', 'background'));
    }

    public function EditBackground(AboutBackgroundRequest $request, Image $image)
    {
        $dataImage = $image->category('gallery-section')->type('background')->first();

        if ($dataImage) {
            if ($dataImage->file_path && Storage::disk('public')->exists($dataImage->file_path)) {
                Storage::disk('public')->delete($dataImage->file_path);
            }
    
            $path = $request->file('file')->store('images/gallery', 'public');
            $dataImage->file_path = $path;
            
            $dataImage->save();
        }else {
            $image->name = "gallery-background";
            $image->category = 'gallery-section';
            $image->description = 'background image';
            $image->type = 'background';
            $image->order = 1;
            $image->active = true;

            $path = $request->file('file')->store('images/gallery', 'public');
            $image->file_path = $path;

            $image->save();
        }

        return redirect()->to('/dashboard/gallery')->with('success', 'Successfully Update Background Image Gallery');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeSectionCreateRequest $request, Image $image)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/gallery', 'public');
            $image->file_path = $path;
        }

        $maxOrder = $image->category('gallery-section')->max('order');
        $nextOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        $image->name =  $request->name;
        $image->type = 'image';
        $image->category = 'gallery-section';
        $image->order = $nextOrder;
        $image->description =  $request->description;
        $image->save();

        return redirect()->to('/dashboard/gallery')->with('success', 'Gallery Section updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Image $image)
    {
        $data_image = $image->where('id', $id)->first();

        $order = $image->category('gallery-section')->max('order');

        return view('modules.dashboard.gallery.edit', compact('data_image', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HomeSectionUpdateRequest $request, string $id)
    {

        $image = Image::findOrFail($id);

        $newOrder = (int) $request->order;

        if ($image->order != $request->order) {
            $oldOrder = $image->order;
            $newOrder = $request->order;
        
            if ($newOrder < $oldOrder) {
                // Geser item yang ada di range [newOrder, oldOrder - 1] => order naik (geser ke bawah)
                Image::where('category', $image->category)
                    ->where('id', '!=', $image->id)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } elseif ($newOrder > $oldOrder) {
                // Geser item yang ada di range [oldOrder + 1, newOrder] => order turun (geser ke atas)
                Image::where('category', $image->category)
                    ->where('id', '!=', $image->id)
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }
        
            $image->order = $newOrder;
        }
        
        $image->name = $request->name;
        $image->description = $request->description;
        $image->active = $request->has('active') ? $request->active : true;
        
        if ($request->hasFile('file')) {
            if ($image->file_path && Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            $image->file_path = $request->file('file')->store('images/gallery', 'public');
        }

        $image->save();

        return redirect()->to('/dashboard/gallery')->with('success', 'Image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = Image::findOrFail($id);
        $deletedOrder = $image->order;

        if ($image->file_path && Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }

        $image->delete();

        Image::category('gallery-section')
        ->where('order', '>', $deletedOrder)
        ->decrement('order');

        return redirect()->to('/dashboard/gallery')->with('success', 'Image deleted and order updated!');
    }
}
