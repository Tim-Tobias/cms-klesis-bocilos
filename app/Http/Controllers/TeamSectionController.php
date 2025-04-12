<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutContentRequest;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;

class TeamSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::category('team-section')->active()->ordered()->get();
        $contents = Content::category('team-section')->get();

        return view('modules.dashboard.team.index', compact('images', 'contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutContentRequest $request)
    {
        $content = Content::category('team-section')->active()->first();

        if(!$content) {
            $newContent = new Content();
            $newContent->content = $request->content;
            $newContent->category = 'team-section';
            $newContent->active = true;

            $newContent->save();
        }else {
            $content->category = $request->content;
            $content->save();
        }

        return redirect()->to('/dashboard/team')->with('success', 'Successfully Updated Content About');
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
        $content = Content::where('id', $id)->category('team-section')->active()->first();

        return view('modules.dashboard.team.edit', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutContentRequest $request, string $id)
    {
        $content = Content::findOrFail($id);

        $content->content = $request->content;
        $content->save();

        return redirect()->to('/dashboard/team')->with('success', 'Successfully Updated Content About');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
