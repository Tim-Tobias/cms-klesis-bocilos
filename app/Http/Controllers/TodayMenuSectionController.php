<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodayMenuSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(10);
        return view('modules.dashboard.today_menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('modules.dashboard.today_menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $file = $request->file('file_path');
        $filePath = $file->store('images/today-menu', 'public');

        Menu::create([
            'name' => $request->name,
            'file_path' => $filePath,
            'id_category' => $request->id_category,
        ]);

        return redirect()->to('/dashboard/today-menu')->with('success', 'Menu created successfully.');
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
        $menu = Menu::where('id', $id)->first();
        $categories = Category::all();
        return view('modules.dashboard.today_menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, string $id)
    {
        $menu = Menu::where('id', $id)->first();

        $data = $request->only(['name', 'id_categories']);

        if ($request->hasFile('file_path')) {
            if ($menu->file_path) {
                Storage::disk('public')->delete($menu->file_path);
            }

            $file = $request->file('file_path');
            $data['file_path'] = $file->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->to('/dashboard/today-menu')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::where('id', $id)->first();

        if ($menu->file_path) {
            Storage::disk('public')->delete($menu->file_path);
        }

        $menu->delete();

        return redirect()->to('/dashboard/today-menu')->with('success', 'Menu deleted successfully.');
    }
}
