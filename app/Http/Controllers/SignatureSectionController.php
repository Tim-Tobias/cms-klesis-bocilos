<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Http\Requests\SignatureSectionRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Image $image)
    {
        $background = $image->category('signature-section')->type('background')->active()->first();
        $images = $image->category('signature-section')->type('image')->active()->ordered()->get();

        return view('modules.dashboard.signature.index', compact('background', 'images'));
    }

    public function EditBackground(AboutBackgroundRequest $request, Image $image)
    {
        $dataImage = $image->category('signature-section')->type('background')->active()->first();

        if ($dataImage) {
            if ($dataImage->file_path && Storage::disk('public')->exists($dataImage->file_path)) {
                Storage::disk('public')->delete($dataImage->file_path);
            }
    
            $path = $request->file('file')->store('images/signature', 'public');
            $dataImage->file_path = $path;
            
            $dataImage->save();
        }else {
            $image->name = "signature-background";
            $image->category = 'signature-section';
            $image->description = 'background image';
            $image->type = 'background';
            $image->order = 1;
            $image->active = true;

            $path = $request->file('file')->store('images/signature', 'public');
            $image->file_path = $path;

            $image->save();
        }

        return redirect()->to('/dashboard/signature')->with('success', 'Successfully Update Background Image');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.signature.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SignatureSectionRequest $request, Image $image)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/signature', 'public');
            $image->file_path = $path;
        }

        $maxOrder = $image->category('signature-section')->type('image')->active()->max('order');
        $nextOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        $image->name =  $request->name;
        $image->type = 'image';
        $image->category = 'signature-section';
        $image->order = $nextOrder;
        $image->description =  $request->description;
        $image->save();

        return redirect()->to('/dashboard/signature')->with('success', 'Signature Section created successfully!');
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

        $order = $image->category('signature-section')->type('image')->active()->max('order');

        return view('modules.dashboard.signature.edit', compact('data_image', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = Image::findOrFail($id);

        $newOrder = (int) $request->order;

        if ($image->order != $request->order) {
            $oldOrder = $image->order;
            $newOrder = $request->order;
        
            if ($newOrder < $oldOrder) {
                Image::category($image->category)->type('image')->active()
                    ->where('id', '!=', $image->id)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } elseif ($newOrder > $oldOrder) {
                Image::category($image->category)->type('image')->active()
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

            $image->file_path = $request->file('file')->store('images/signature', 'public');
        }

        $image->save();

        return redirect()->to('/dashboard/signature')->with('success', 'Image updated successfully!');
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

        Image::category('signature-section')->type('image')->active()
        ->where('order', '>', $deletedOrder)
        ->decrement('order');

        return redirect()->to('/dashboard/signature')->with('success', 'Image deleted and order updated!');
    }
}
