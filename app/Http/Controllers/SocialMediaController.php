<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialMediaRequest;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $images = SocialMedia::query();

            return DataTables::of($images)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/social-media/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/social-media/'.$row->id;
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
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.web-config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialMediaRequest $request, SocialMedia $social)
    { 

        $social->name = strtolower($request->name);
        $social->description = $request->description;
        $social->path = $request->path;
        $social->save();

        return redirect()->to('/dashboard/web-config')->with('success', 'Social Media updated successfully!');
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
    public function edit(string $id, SocialMedia $social)
    {
        $social = $social->where('id', $id)->first();

        return view('modules.dashboard.web-config.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialMediaRequest $request, string $id)
    {

        $social = SocialMedia::findOrFail($id);
        $social->name = strtolower($request->name);
        $social->description = $request->description;
        $social->path = $request->path;

        $social->save();

        return redirect()->to('/dashboard/web-config')->with('success', 'Social Media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = SocialMedia::findOrFail($id);

        $image->delete();

        return redirect()->to('/dashboard/web-config')->with('success', 'Social Media Deleted');
    }
}
