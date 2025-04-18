<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TodayMenuSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.dashboard.today_menu.index');
    }

    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::with('category');

            return DataTables::of($menus)
                ->addIndexColumn()
                ->editColumn('file_path', function ($row) {
                    return '<img src="' . $row->file_path . '" height="50"/>';
                })
                ->editColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = '/dashboard/today-menu/'.$row->id.'/edit';
                    $deleteUrl = '/dashboard/today-menu/'.$row->id;
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
                ->rawColumns(['action', 'file_path'])
                ->make(true);
        }
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

        $data = $request->only(['name', 'id_category']);

        if ($request->hasFile('file_path')) {
            if ($menu->file_path) {
                Storage::disk('public')->delete($menu->file_path);
            }

            $file = $request->file('file_path');
            $data['file_path'] = $file->store('menus', 'public');
        }

        $menu->id_category = $data['id_category'];

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
