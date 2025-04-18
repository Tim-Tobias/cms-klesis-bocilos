<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutContentRequest;
use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeamSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contents = Content::category('team-section')->get()->count();

        return view('modules.dashboard.team.index', compact('contents'));
    }

    public function GetDataImage(Request $request)
    {
        if ($request->ajax()) {
            $teams = Image::category('team-section')->active()->select(['id','name', 'order', 'file_path', 'description', 'active']);

            return DataTables::of($teams)
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
                    $editUrl = '/dashboard/team/image/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/team/image/'.$row->id;
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

    public function GetDataContent(Request $request)
    {
        if ($request->ajax()) {
            $teams = Content::category('team-section')->active();

            return DataTables::of($teams)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/team/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/team/'.$row->id;
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return <<<HTML
                        <a href="{$editUrl}" class="btn btn-sm btn-primary">Edit</a>
                    HTML;
                })
                ->rawColumns(['action', 'content'])
                ->make(true);
        }
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
