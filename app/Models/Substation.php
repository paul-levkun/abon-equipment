<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\ObjectType;
use App\Models\Register;
use App\Models\SapSo;
use App\Models\SapRem;


class Substation extends Model
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

    public function object_types() {
        return $this->belongsTo(ObjectType::class, 'object_type_id');
    }

    public function registers() {
        return $this->hasMany(Register::class, 'substation_id');
    }

    public function connected_registers() {
        return $this->hasMany(Register::class, 'connected_substation_id');
    }

    public function sap_sos() {
        return $this->belongsTo(SapSo::class, 'sap_so_id');
    }

    public function sap_rems() {
        return $this->belongsTo(SapRem::class, 'sap_rem_id');
    }

}
