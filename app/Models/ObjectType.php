<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Substation;
use App\Models\Line;

class ObjectType extends Model
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

    public function substations() {
        return $this->hasMany(Substation::class);
    }

    public function lines() {
        return $this->hasMany(Line::class);
    }

}
