<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Http\Requests\SignatureSectionRequest;
use App\Http\Requests\UploadPdfRequest;
use App\Models\File;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MenuSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Image $image)
    {
        $background = $image->category('menu-section')->type('background')->active()->first();
        $images = $image->category('menu-section')->type('image')->active()->ordered()->get();
        $file = File::first();

        return view('modules.dashboard.menu.index', compact('background', 'images', 'file'));
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $images = Image::category('menu-section')->type('image')->active()->select(['id','name', 'order', 'file_path', 'description', 'active']);

            return DataTables::of($images)
                ->addIndexColumn()
                ->editColumn('file_path', function ($row) {
                    return '<img src="' . asset('storage/'. $row->file_path) . '" height="50"/>';
                })
                ->editColumn('active', function ($row) {
                    if($row->active) {
                        return '<span class="badge bg-success">Active</span>';
                    }else {
                        return '<span class="badge bg-danger">Deactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/menu/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/menu/'.$row->id;
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return <<<HTML
                        <a href="{$editUrl}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{$deleteUrl}" method="POST" style="display:inline-block;">
                            {$csrf}
                            {$method}
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    HTML;
                })
                ->rawColumns(['action', 'file_path', 'active'])
                ->make(true);
        }
    }

    public function EditBackground(AboutBackgroundRequest $request, Image $image)
    {
        $dataImage = $image->category('menu-section')->type('background')->active()->first();

        if ($dataImage) {
            if ($dataImage->file_path && Storage::disk('public')->exists($dataImage->file_path)) {
                Storage::disk('public')->delete($dataImage->file_path);
            }
    
            $path = $request->file('file')->store('images/menu', 'public');
            $dataImage->file_path = $path;
            
            $dataImage->save();
        }else {
            $image->name = "menu-background";
            $image->category = 'menu-section';
            $image->description = 'background image';
            $image->type = 'background';
            $image->order = 1;
            $image->active = true;

            $path = $request->file('file')->store('images/menu', 'public');
            $image->file_path = $path;

            $image->save();
        }

        return redirect()->to('/dashboard/menu')->with('success', 'Successfully Update Background Image');
    }

    public function EditFile(UploadPdfRequest $request, File $file)
    {
        $dataFile = $file->first();

        if($dataFile) {
            if ($dataFile->file_path && Storage::disk('public')->exists($dataFile->file_path)) {
                Storage::disk('public')->delete($dataFile->file_path);
            }

            $path = $request->file('file_pdf')->store('pdf/menu', 'public');
            $dataFile->file_path = $path;
            
            $dataFile->save();
        }else {
            $path = $request->file('file_pdf')->store('pdf/menu', 'public');
            $file->file_path = $path;

            $file->save();
        }

        return redirect()->to('/dashboard/menu')->with('success', 'Successfully Update File Image');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SignatureSectionRequest $request, Image $image)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images/menu', 'public');
            $image->file_path = $path;
        }

        $maxOrder = $image->category('menu-section')->type('image')->active()->max('order');
        $nextOrder = $maxOrder !== null ? $maxOrder + 1 : 1;

        $image->name =  $request->name;
        $image->type = 'image';
        $image->category = 'menu-section';
        $image->order = $nextOrder;
        $image->description =  $request->description;
        $image->save();

        return redirect()->to('/dashboard/menu')->with('success', 'Menu Section created successfully!');
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

        $order = $image->category('menu-section')->type('image')->active()->max('order');

        return view('modules.dashboard.menu.edit', compact('data_image', 'order'));
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
        $image->highlight = $request->has('highlight') ? $request->highlight : false;
        
        if ($request->hasFile('file')) {
            if ($image->file_path && Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            $image->file_path = $request->file('file')->store('images/menu', 'public');
        }

        $image->save();

        return redirect()->to('/dashboard/menu')->with('success', 'Image updated successfully!');
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

        Image::category('menu-section')->type('image')->active()
        ->where('order', '>', $deletedOrder)
        ->decrement('order');

        return redirect()->to('/dashboard/menu')->with('success', 'Image deleted and order updated!');
    }
}
