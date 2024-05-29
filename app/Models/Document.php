<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Register;
use App\Models\DocType;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'register_id',
        'doc_type_id',
        'file_path',
    ];

    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }

    public function doc_types() {
        return $this->belongsTo(DocType::class, 'doc_type_id');
    }

    public function registers() {
        return $this->belongsTo(Register::class, 'register_id');
    }

}
