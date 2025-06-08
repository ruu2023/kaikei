<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $validated['created_at'] = now();

        $maxSort = Category::max('sort_order') ?? 0;
        $validated['sort_order'] = $maxSort + 1;
        $category = Category::create($validated);

        // return response()->json($category, 201);

        return redirect("/settings?page=category");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {

        $validated = $request->validated();

        $category->update($validated);

        // return response()->json([
        //     'message' => 'カテゴリーを更新しました。',
        //     'category' => $category
        // ]);

        return redirect("/settings?page=category");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        // return response()->json(['message', 'Deleted'], 200);

        return back();
    }
}
