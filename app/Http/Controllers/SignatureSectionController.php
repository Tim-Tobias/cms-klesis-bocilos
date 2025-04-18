<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBackgroundRequest;
use App\Http\Requests\SignatureSectionRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SignatureSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Image $image)
    {
        $background = $image->category('signature-section')->type('background')->active()->first();
        $images = $image->category('signature-section')->type('image')->active()->get()->count();

        return view('modules.dashboard.signature.index', compact('background', 'images'));
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $images = Image::category('signature-section')->type('image')->active()->select(['id','name', 'order', 'file_path', 'description', 'active']);

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
                    $editUrl = '/dashboard/signature/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/signature/'.$row->id;
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
    public function update(SignatureSectionRequest $request, string $id)
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
