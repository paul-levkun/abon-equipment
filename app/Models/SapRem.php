<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\SapSo;
use App\Models\Register;
use App\Models\Substation;
use App\Models\Line;
use App\Models\User;

class SapRem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }

    public function sap_sos() {
        return $this->belongsTo(SapSo::class, 'so_id');
    }

    public function registers() {
        return $this->hasMany(Register::class);
    }

    public function substations() {
        return $this->hasMany(Substation::class);
    }

    public function lines() {
        return $this->hasMany(Line::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
