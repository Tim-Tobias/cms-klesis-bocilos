<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeSectionCreateRequest;
use App\Http\Requests\HomeSectionUpdateRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $home_images = Image::category('home-section')
                            ->active()
                            ->ordered()
                            ->get();

        return view('modules.dashboard.home.index', compact('home_images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.home.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeSectionCreateRequest $request, Image $image)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/home', 'public');
            $image->file_path = $path;
        }

        $maxOrder = $image->category('home-section')->max('order');
        $nextOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        $image->id = Str::uuid();
        $image->name =  $request->name;
        $image->type = 'background';
        $image->category = 'home-section';
        $image->order = $nextOrder;
        $image->description =  $request->description;
        $image->save();

        return redirect()->to('/dashboard/home')->with('success', 'Home Section updated successfully!');
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

        $order = $image->category('home-section')->max('order');

        return view('modules.dashboard.home.edit', compact('data_image', 'order'));
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

            $image->file_path = $request->file('file')->store('images', 'public');
        }

        $image->save();

        return redirect()->to('/dashboard/home')->with('success', 'Image updated successfully!');
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

        Image::category('home-section')
        ->where('order', '>', $deletedOrder)
        ->decrement('order');

        return redirect()->to('/dashboard/home')->with('success', 'Image deleted and order updated!');
    }
}
