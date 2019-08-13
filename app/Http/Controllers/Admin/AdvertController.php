<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advert;

class AdvertController extends Controller
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
            if ($request->has('advert_node_id') and $request->advert_node_id != '') {
                $query->where('advert_node_id', $request->advert_node_id);
            }
        };
        $adverts = Advert::with('advert_node', 'photo')->where($where)->orderBy('sort')->paginate(3);
        return response()->json(compact('adverts'));
    }

    /***
     * 新增分类
     */
    public function store(Request $request)
    {
        Advert::create($request->all());
    }
    /***
     *
     */
    public function edit($id)
    {
        $advert = Advert::with('photo')->find($id);
        return response()->json($advert);
    }

    /***更新数据
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        //return $request->all();
        $advert =Advert::find($id);
        $advert->update($request->all());
    }
    /***
     * 删除
     */
    public function destroy($id)
    {
        //
        Advert::destroy($id);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
    /***
     * 改变排序
     */
    public function change_sort(Request $request,$id)
    {
        //
        Advert::where('id',$id)->update(['sort'=>$request->sort]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }

    public function change_attr(Request $request,$id)
    {
        //
        Advert::where('id',$id)->update(['is_show'=>!$request->is_show]);
        $info =['status'=>1,'msg'=>'ok'];
        return response()->json(compact('info'));
    }
}
