<?php

namespace App\Http\Controllers;

use App\Models\PluginCategoriesModel;
use Illuminate\Http\Request;

class PluginCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.plugin_categories');
    }


    public function create()
    {

        $plugin_cata = PluginCategoriesModel::all();


        return response()->json(['data' => $plugin_cata]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:plugin_categories_table,name|max:255',
        ]);

        $plugin_categories =  PluginCategoriesModel::create([
            'name' => $request->name,
        ]);
        return response()->json(['success' => 'Plugin category created successfully!']);
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
        // Find the category by ID
        $category = PluginCategoriesModel::find($id);

        // Return the category data as JSON
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = PluginCategoriesModel::find($id);
        $category->update($request->all());

        return response()->json(['message' => 'Category updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = PluginCategoriesModel::find($id);

        $category->delete();


        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
    public function pluginpage() {}
}
