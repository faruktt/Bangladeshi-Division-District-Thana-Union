<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Division extends Model
{
    use HasRelationships;

    protected $table = 'divisions';
    public $timestamps = false;

    protected $fillable = ['name','bn_name','lat','lon','website'];

    public function districts()
    {
        return $this->hasMany(District::class, 'division_id', 'id');
    }

    public function thanas()
    {
        return $this->hasManyThrough(Thana::class, District::class, 'division_id', 'district_id', 'id', 'id');
    }
}
