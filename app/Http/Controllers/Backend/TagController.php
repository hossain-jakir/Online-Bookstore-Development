<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $data=[];

        $data['rows'] = Tag::where('isDeleted', 'no')->latest('id')->paginate(20);

        foreach($data['rows'] as $row){
            $row->hashId = Crypt::encrypt($row->id);
        }

        return view('Backend.pages.tag.index')->with('data', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

        return view('Backend.pages.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request){
        try{

            $slug = 'tag/' . str_replace(' ', '-', strtolower($request->name));
            if(Tag::where('slug', $slug)->exists()){
                Session::flash('error', 'tag already exists');
                return back();
            }

            $create = Tag::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description ?? null,
                'status' => $request->status,
            ]);

            if(!$create){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'tag created successfully');
            return redirect()->route('backend.tag.index');

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
        try{

            $data = [];

            $data['row'] = Tag::find($id);
            if(!$data['row']){
                Session::flash('error', 'Tag not found');
                return back();
            }

            $data['row']->hashId = Crypt::encrypt($data['row']->id);

            return view('Backend.pages.tag.edit')->with('data', $data);

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
    public function update(TagRequest $request, $id){
        try{

            $tag = Tag::find($id);
            if(!$tag){
                Session::flash('error', 'tag not found');
                return back();
            }

            if($tag->name == $request->name){
                $slug = $tag->slug;
            }else{
                $slug = 'tag/' . str_replace(' ', '-', strtolower($request->name));

                if(Tag::where('slug', $slug)->exists()){
                    Session::flash('error', 'tag already exists');
                    return back();
                }
            }

            $update = $tag->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description ?? null,
                'status' => $request->status,
            ]);

            if(!$update){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'tag updated successfully');
            return redirect()->route('backend.tag.index');

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
        try{
            $tag = Tag::find($id);
            if(!$tag){
                Session::flash('error', 'tag not found');
                return back();
            }

            $delete = $tag->update([
                'isDeleted' => 'yes',
            ]);

            if(!$delete){
                Session::flash('error', 'Something went wrong');
                return back();
            }

            Session::flash('success', 'tag deleted successfully');
            return redirect()->route('backend.tag.index');

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
}
