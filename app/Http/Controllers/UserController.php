<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modules.dashboard.users.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email'])->where('id', "<>", Auth::id());

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = '/dashboard/users/'.$row->id.'/edit';
                $deleteUrl = '/dashboard/users/'.$row->id;
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
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request['password'] = bcrypt($request['password']);
        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $user = User::findOrFail($id);
        return view('modules.dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
