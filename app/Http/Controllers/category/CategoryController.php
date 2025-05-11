<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
       return view('category.add-category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('category.add-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'category_name'=>['required','string','max:255'],
            'category_slug'=>['required','string','max:255'],
            'category_description'=>['required'],
            'category_icon_link'=> ['nullable', 'string'],
            'category_status' => ['required', 'in:active,inactive'],
        ]);
Category::create($validated);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
