<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdvertNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertNodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $advert_nodes =AdvertNode::orderBy('sort')->get();
        return response()->json(compact('advert_nodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        AdvertNode::create($request->all());
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
        AdvertNode::where('id',$request->id)->update($request->all());
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
        AdvertNode::destroy($id);
    }
    /***
     * 改变排序
     */
    public function change_sort(Request $request,$id)
    {
        //
        AdvertNode::where('id',$id)->update(['sort'=>$request->sort]);

    }

    /***多选删除
     * @param $id
     */
    public function del_all(Request $request){
        AdvertNode::destroy($request->checked_id);
    }
}
