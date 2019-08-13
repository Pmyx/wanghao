<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
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
            if ($request->has('notice_node_id') and $request->notice_node_id != '') {
                $query->where('notice_node_id', $request->notice_node_id);
            }
        };
        $notices = Notice::with('notice_node', 'photo')->where($where)->paginate(3);
        return response()->json(compact('notices'));
    }

    /***
     * 新增分类
     */
    public function store(Request $request)
    {
        Notice::create($request->all());
    }
    /***
     *
     */
    public function edit($id)
    {
        $notice = Notice::with('photo')->find($id);
        return response()->json($notice);
    }

    /***更新数据
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        //return $request->all();
        $notice =Notice::find($id);
        $notice->update($request->all());
    }
    /***
     * 删除
     */
    public function destroy($id)
    {
        //
        Notice::destroy($id);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
    /***
     * 改变排序
     */
    public function change_sort(Request $request,$id)
    {
        //
        Notice::where('id',$id)->update(['sort'=>$request->sort]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }

    public function change_attr(Request $request,$id)
    {
        //
        Notice::where('id',$id)->update(['is_show'=>!$request->is_show]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
}
