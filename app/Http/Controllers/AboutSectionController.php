<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Http\Requests\AboutContentRequest;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $image = Image::category('about-section')->first();
        $contents = Content::category('about-section')->active()->get()->count();

        return view('modules.dashboard.about.index', compact('image', 'contents'));
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $contents = Content::category('about-section')->active()
                            ->active()->select(['id','content']);

            return DataTables::of($contents)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/about/'.$row->id.'/edit';

                    return <<<HTML
                        <a href="{$editUrl}" class="btn btn-sm btn-primary">Edit</a>
                    HTML;
                })
                ->rawColumns(['action', 'content'])
                ->make(true);
        }
    }

    public function EditBackground(AboutBackgroundRequest $request, Image $image)
    {
        $dataImage = $image->category('about-section')->first();

        if ($dataImage) {
            if ($dataImage->file_path && Storage::disk('public')->exists($dataImage->file_path)) {
                Storage::disk('public')->delete($dataImage->file_path);
            }
    
            $path = $request->file('file')->store('images/about', 'public');
            $dataImage->file_path = $path;
            
            $dataImage->save();
        }else {
            $image->name = "about-background";
            $image->category = 'about-section';
            $image->description = 'background image';
            $image->type = 'background';
            $image->order = 1;
            $image->active = true;

            $path = $request->file('file')->store('images/about', 'public');
            $image->file_path = $path;

            $image->save();
        }

        return redirect()->to('/dashboard/about')->with('success', 'Successfully Update Background Image');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutContentRequest $request)
    {
        $content = Content::category('about-section')->active()->first();

        if(!$content) {
            $newContent = new Content();
            $newContent->content = $request->content;
            $newContent->category = 'about-section';
            $newContent->active = true;

            $newContent->save();
        }else {
            $content->category = $request->content;
            $content->save();
        }

        return redirect()->to('/dashboard/about')->with('success', 'Successfully Updated Content About');
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
        $content = Content::where('id', $id)->category('about-section')->active()->first();

        return view('modules.dashboard.about.edit', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutContentRequest $request, string $id)
    {
        $content = Content::findOrFail($id);

        $content->content = $request->content;
        $content->save();

        return redirect()->to('/dashboard/about')->with('success', 'Successfully Updated Content About');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
