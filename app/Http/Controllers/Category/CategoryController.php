<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index','show']);
        $this->middleware('auth:api')->except(['index','show']);
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store','update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categoies = Category::all();
        return $this->showAll($categoies);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => ' required',
        ];
        $this->validate($request,$rules);
        $category = Category::create($request->all());
        return $this->showOne($category,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->all());
        if($category->isClean())
            return $this->errorResponse('Debe especificar un valor dierente para actualizar',422);
        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
