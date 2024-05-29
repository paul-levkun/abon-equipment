<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Substation;
use App\Models\Line;
use App\Models\SapSo;
use App\Models\SapRem;
use App\Models\ContractType;
use App\Models\Owner;
use App\Models\Contract;
use App\Models\ContractInexpediencyType;
use App\Models\ContractFailureType;
use App\Models\ContractStatusType;
use App\Models\Document;

class Register extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // $fillable має дію тільки при store(). При update() не впливає
        'sap_so_id',
        'sap_rem_id',
        'substation_id',
        'line_id',
        'location_type_id',
        'line_section_type_id',
        'tech_state_type_id',
        'in_cds_id',
        'owner_id',
        'cond_units',
        'contract_id',
        'contract_status_type_id',
        'contract_type_id',
        'contract_failure_type_id',
        'contract_inexpediency_type_id',
        'connected_substation_id',
        'connected_line_id',
        'comment',
        'user_id',
    ];

    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value) {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }

    public function substations() {
        return $this->belongsTo(Substation::class, 'substation_id');
    }

    public function lines() {
        return $this->belongsTo(Line::class, 'line_id');
    }

    public function connected_substations() {
        return $this->belongsTo(Substation::class, 'connected_substation_id');
    }

    public function connected_lines() {
        return $this->belongsTo(Line::class, 'connected_line_id');
    }

    public function sap_sos() {
        return $this->belongsTo(SapSo::class, 'sap_so_id');
    }

    public function sap_rems() {
        return $this->belongsTo(SapRem::class, 'sap_rem_id');
    }

    public function contract_types() {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    public function owners() {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function contracts() {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function contract_failure_types() {
        return $this->belongsTo(ContractFailureType::class, 'contract_failure_type_id');
    }

    public function contract_inexpediency_types() {
        return $this->belongsTo(ContractInexpediencyType::class, 'contract_inexpediency_type_id');
    }

    public function contract_status_types() {
        return $this->belongsTo(ContractStatusType::class, 'contract_status_type_id');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

}
