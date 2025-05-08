<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.dashboard.blog.index');
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::with('category')->select('blogs.*');

            return DataTables::of($blogs)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" height="50"/>';
                })
                ->editColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->editColumn('content', function ($row) {
                    return limitText($row->content);
                })
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/blog/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/blog/'.$row->id;
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
                ->rawColumns(['action', 'image', 'content'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();

        return view('modules.dashboard.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $blog = new Blog;

        if ($request->hasFile('image')) {
            $blog->image = $request->file('image')->store('blogs', 'public');
        }

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->active = $request->active;
        $blog->save();

        return redirect()->to('/dashboard/blog')->with('success', 'Blog berhasil disimpan.');
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
        $categories = BlogCategory::all();

        $blog = Blog::findOrFail($id);

        return view('modules.dashboard.blog.edit', compact('categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {   
        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
    
            $blog->image = $request->file('image')->store('blogs', 'public');
        }

        $blog->blog_category_id = $request->blog_category_id;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->active = $request->active;
        $blog->save();

        return redirect()->to('/dashboard/blog')->with('success', 'Blog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->to('/dashboard/blog')->with('success', 'Blog berhasil dihapus.');
    }
}
