<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    //
    protected $guarded=['photo'];

    /***关联分类表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advert_node()
    {
        return $this->belongsTo('App\Models\AdvertNode');
    }

    /***关联图片表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Models\Photo');
    }
}
