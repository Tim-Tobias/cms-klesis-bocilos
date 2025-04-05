<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('modules.dashboard.today_menu.categories.index', compact('categories'));
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
