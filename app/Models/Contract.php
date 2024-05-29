<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Owner;
use App\Models\SapBo;
use App\Models\Register;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }

    public function owners() {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function sap_bos() {
        return $this->belongsTo(SapBo::class, 'sap_bo_id');
    }

    public function registers() {
        return $this->hasMany(Register::class);
    }


}
