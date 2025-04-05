<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $image = Image::category('footer-section')->first();
        $contents = Content::category('footer-section')->active()->get();

        return view('modules.dashboard.footer.index', compact('image', 'contents'));
    }

    public function EditBackground(AboutBackgroundRequest $request, Image $image)
    {
        $dataImage = $image->category('footer-section')->first();

        if ($dataImage) {
            if ($dataImage->file_path && Storage::disk('public')->exists($dataImage->file_path)) {
                Storage::disk('public')->delete($dataImage->file_path);
            }
    
            $path = $request->file('file')->store('images/footer', 'public');
            $dataImage->file_path = $path;
            
            $dataImage->save();
        }else {
            $image->name = "footer-background";
            $image->category = 'footer-section';
            $image->description = 'background image';
            $image->type = 'background';
            $image->order = 1;
            $image->active = true;

            $path = $request->file('file')->store('images/footer', 'public');
            $image->file_path = $path;

            $image->save();
        }

        return redirect()->to('/dashboard/footer')->with('success', 'Successfully Update Background Image');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.footer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $content = Content::category('footer-section')->active()->first();

        if(!$content) {
            $newContent = new Content();
            $newContent->content = $request->content;
            $newContent->category = 'footer-section';
            $newContent->active = true;

            $newContent->save();
        }else {
            $content->category = $request->content;
            $content->save();
        }

        return redirect()->to('/dashboard/footer')->with('success', 'Successfully Updated Content Footer');
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
    public function edit(string $id)
    {
        $content = Content::where('id', $id)->category('footer-section')->active()->first();

        return view('modules.dashboard.footer.edit', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);

        $content->content = $request->content;
        $content->save();

        return redirect()->to('/dashboard/footer')->with('success', 'Successfully Updated Content Footer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
