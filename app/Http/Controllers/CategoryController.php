<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\CategoryroleModel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $category = Category::get();
            $user = $request->user();
            $role = $user->role;
            return response()->json(['status' => 'success', 'message' => 'category fetched successfully!.', 'role' => $role ,'category' => $category], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error' , 'message' => 'failed to fetched category!.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $name = $request->name;

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $mimeType = $request->file('image')->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('images', $fileNameToStore);

            $data = array('name' => $name, 'image' => $path);

            $data = Category::create($data);

            return response()->json(['status' => 'success', 'message' => 'category created successfully!.', 'user' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error' , 'message' => 'failed to create category!.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function catroleArray(Request $request)
    {
        try {
            $parentCategories = CategoryroleModel::select('id','name','pid')->where('pid',0)->get();
           /* $parentCategories = CategoryroleModel::select('id','name','pid')->get()->toArray();

            foreach ($parentCategories as $key => $value) {
                print_r($parentCategories);
            }
            die("---");*/
            $categories = [];
                foreach ($parentCategories as $i => $category) {
                $categories[] = CategoryroleModel::with('subcategories')->where('id',$category->id)->first();
            }
            //print_r($categories);die("---");
            return response()->json(['status' => 'success', 'message' => 'category created successfully!.', 'data' => $categories], 200);
        } catch (Exception $e) {
            //return response()->json(['status' => 'error' , 'message' => 'failed to create category!.'], 400);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
