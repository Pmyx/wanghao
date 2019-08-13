<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteNodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $site_nodes =SiteNode::orderBy('sort')->get();
        return response()->json(compact('site_nodes'));
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
        SiteNode::create($request->all());
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
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
        SiteNode::where('id',$request->id)->update($request->all());
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
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
        SiteNode::destroy($id);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
      /***
     * 改变排序
     */
    public function change_sort(Request $request,$id)
    {
        //
        SiteNode::where('id',$id)->update(['sort'=>$request->sort]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }

    /***多选删除
     * @param $id
     */
    public function del_all(Request $request){
        SiteNode::destroy($request->checked_id);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
}
