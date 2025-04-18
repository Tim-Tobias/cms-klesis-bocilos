<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.dashboard.today_menu.categories.index');
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $images = Category::query();

            return DataTables::of($images)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/today-menu/categories/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/today-menu/categories/'.$row->id;
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
        return view('modules.dashboard.today_menu.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request, Category $category)
    {
        $category->name = $request->category;
        $category->save();

        return redirect()->to('/dashboard/today-menu/categories')->with('success', 'Category created successfully.');
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
        $cat = Category::where('id', $id)->first();

        return view('modules.dashboard.today_menu.categories.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $newCat = Category::findOrFail($id);

        $newCat->name = $request->category;
        $newCat->save();

        return redirect()->to('/dashboard/today-menu/categories')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newCat = Category::findOrFail($id);
        $newCat->delete();
        return redirect()->to('/dashboard/today-menu/categories')->with('success', 'Category deleted successfully.');
    }
}
