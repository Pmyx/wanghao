<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /***
     * 加载首页
     */
    public function index(Request $request)
    {
        $where = function($query) use ($request){
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('name', 'like', $search);
            }
            if ($request->has('site_node_id') and $request->site_node_id != '') {
                $query->where('site_node_id', $request->site_node_id);
            }
        };
        $sites = Site::with('site_node', 'photo')->where($where)->paginate(1);
        return response()->json(compact('sites'));
    }

    /***
     * 新增分类
     */
    public function store(Request $request)
    {
        Site::create($request->all());
    }
    /***
     *
     */
    public function edit($id)
    {
        $site = Site::with('photo')->find($id);
        return response()->json($site);
    }

    /***更新数据
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        //return $request->all();
        $site =Site::find($id);
        $site->update($request->all());
    }
    /***
     * 删除
     */
    public function destroy($id)
    {
        //
        Site::destroy($id);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
    /***
     * 改变排序
     */
    public function change_sort(Request $request,$id)
    {
        //
        Site::where('id',$id)->update(['sort'=>$request->sort]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }

    public function change_attr(Request $request,$id)
    {
        //
        Site::where('id',$id)->update(['is_show'=>!$request->is_show]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
}
