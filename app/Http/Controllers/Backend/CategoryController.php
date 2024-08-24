<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Backend\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        // Authorization check
        if (Gate::denies('view category')) {
            abort(403, 'Unauthorized');
        }

        $data=[];

        $data['rows'] = Category::where('isDeleted', 'no')->latest('id')->paginate(20);

        foreach($data['rows'] as $row){
            $row->hashId = Crypt::encrypt($row->id);
        }

        return view('Backend.pages.category.index')->with('data', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        if (Gate::denies('create category')) {
            abort(403, 'Unauthorized');
        }
        return view('Backend.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request){

        // Authorization check
        if (Gate::denies('create category')) {
            abort(403, 'Unauthorized');
        }

        try{

            $slug = 'category/' . str_replace(' ', '-', strtolower($request->name));
            if(Category::where('slug', $slug)->exists()){
                Session::flash('error', 'Category already exists');
                return back();
            }

            $create = Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description ?? null,
                'status' => $request->status,
            ]);

            if(!$create){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'Category created successfully');
            return redirect()->route('backend.category.index');

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return back();
        }
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
    public function edit(Request $request, $id){

        // Authorization check
        if (Gate::denies('edit category')) {
            abort(403, 'Unauthorized');
        }

        try{

            $data = [];

            $data['row'] = Category::find($id);
            if(!$data['row']){
                Session::flash('error', 'Category not found');
                return back();
            }

            $data['row']->hashId = Crypt::encrypt($data['row']->id);

            return view('Backend.pages.category.edit')->with('data', $data);

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id){
        // Authorization check
        if (Gate::denies('edit category')) {
            abort(403, 'Unauthorized');
        }
        try{

            $category = Category::find($id);
            if(!$category){
                Session::flash('error', 'Category not found');
                return back();
            }

            if($category->name == $request->name){
                $slug = $category->slug;
            }else{
                $slug = 'category/' . str_replace(' ', '-', strtolower($request->name));

                if(Category::where('slug', $slug)->exists()){
                    Session::flash('error', 'Category already exists');
                    return back();
                }
            }

            $update = $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description ?? null,
                'status' => $request->status,
            ]);

            if(!$update){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'Category updated successfully');
            return redirect()->route('backend.category.index');

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){

        // Authorization check
        if (Gate::denies('delete category')) {
            abort(403, 'Unauthorized');
        }
        try{
            $category = Category::find($id);
            if(!$category){
                Session::flash('error', 'Category not found');
                return back();
            }

            $delete = $category->update([
                'isDeleted' => 'yes',
            ]);

            if(!$delete){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'Category deleted successfully');
            return redirect()->route('backend.category.index');

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
}
