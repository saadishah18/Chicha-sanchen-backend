<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $service;

    public function __construct(CategoryService $categoryService){
        $this->service = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.categories.index');
    }

    public function datatable(Request $request){
        try {
            return $this->service->datatable($request);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.pages.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the image validation rules as needed
        ]);
        try {
            $this->service->store($request);
            return redirect()->route('admin.categories.index')->with('success','Category created successfully');
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
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
