<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $table = 'unions';
    public $timestamps = false;

    protected $fillable = ['thana_id','name','bn_name'];

    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id', 'id');
    }
}
