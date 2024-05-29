<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Register;
use App\Models\Contract;

class Owner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_res',
        'ab_inn',
        'name',
        'recvisit',
        'id_type_owner',
        'comments',
        'sort',
        'user_id',
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }

    public function registers() {
        return $this->hasMany(Register::class);
    }

    public function contracts() {
        return $this->hasMany(Contract::class);
    }

}
