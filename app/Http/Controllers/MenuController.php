<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with('children')
            ->get();

        return response()->json($menus, 200);
    }

    public function childrenMenus()
    {
        // $childMenus = Menu::whereNotNull('parent_id')->get();
        $childMenus = Menu::get();
        return response()->json($childMenus, 200);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:menus,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $menu_id = Carbon::now()->millisecondOfDay();

            $request['menu_id'] = $menu_id;

            $menu = Menu::create($request->all());

            return response()->json($menu, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $menu = Menu::with('parent', 'children')->findOrFail($id);
        return response()->json($menu, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->parent_id) {
            $menu->update($request->all());
        } else {
            $menu->update([
                'name' => $request->name
            ]);
        }

        return response()->json($menu, 200);
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();

            return response()->json(
                ['msg' => 'Menu deleted successfully'],
                201
            );
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
