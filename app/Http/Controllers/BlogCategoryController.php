<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::orderBy('created_at', 'desc')->paginate(10);

        return view('modules.dashboard.blog.blog-categories.index', compact('categories'));
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $images = BlogCategory::query();

            return DataTables::of($images)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/blog/categories/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/blog/categories/'.$row->id;
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
        return view('modules.dashboard.blog.blog-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request, BlogCategory $category)
    {
        $category->name = $request->category;
        $category->save();

        return redirect()->to('/dashboard/blog/categories')->with('success', 'Blog Category created successfully.');
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
        $cat = BlogCategory::where('id', $id)->first();

        return view('modules.dashboard.blog.blog-categories.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $newCat = BlogCategory::findOrFail($id);

        $newCat->name = $request->category;
        $newCat->save();

        return redirect()->to('/dashboard/blog/categories')->with('success', 'Blog Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newCat = BlogCategory::findOrFail($id);
        $newCat->delete();
        return redirect()->to('/dashboard/blog/categories')->with('success', 'Blog Category deleted successfully.');
    }
}
