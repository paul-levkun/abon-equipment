<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\ContractInexpediencyType;
use App\Models\Register;
use App\Models\Substation;
use App\Models\TechStateType;
// use App\Models\Dictionary;
// use App\Models\Owner;
// use App\Models\Rem;
// use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\OwnerService;
use App\Services\SubstationService;
use App\Services\LineService;
use App\Services\OwnerTypeService;
use App\Services\ContractFailureTypeService;
use App\Services\RemService;
use App\Services\ContractTypeService;
use App\Services\EquipmentTypeService;
use App\Services\VoltageClassService;
use App\Services\LocationTypeService;
use App\Services\TechStateTypeService;
use App\Services\LineSectionTypeService;
use App\Services\LineTypeService;
use App\Services\DocTypeService;
use App\Services\SapSoService;
use App\Services\SapRemService;
use App\Services\SapBoService;
use App\Services\RegisterService;
use App\Services\ObjectTypeService;
use App\Services\StatusTypeService;
use App\Services\ContractService;
use App\Services\DocumentService;
use App\Services\ContractStatusTypeService;
use App\Services\ContractInexpediencyTypeService;
use App\Services\UserService;

class DictsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {
		switch ($req["id"]) {
			case "rems": 
				return (new RemService())->dispatch($req, 'index');
			case "owners": 
				return (new OwnerService())->dispatch($req, 'index');
			case "substations": 
				return (new SubstationService())->dispatch($req, 'index');
			case "lines": 
				return (new LineService())->dispatch($req, 'index');
			case "owner_types": 
				return (new OwnerTypeService())->dispatch($req, 'index');
			case "equipment_types": 
				return (new EquipmentTypeService())->dispatch($req, 'index');
			case "voltage_classes": 
				return (new VoltageClassService())->dispatch($req, 'index');
			case "location_types": 
				return (new LocationTypeService())->dispatch($req, 'index');
			case "tech_state_types": 
				return (new TechStateTypeService())->dispatch($req, 'index');
			case "line_section_types": 
				return (new LineSectionTypeService())->dispatch($req, 'index');
			case "line_types": 
				return (new LineTypeService())->dispatch($req, 'index');
			case "doc_types": 
				return (new DocTypeService())->dispatch($req, 'index');
			case "object_types": 
				return (new ObjectTypeService())->dispatch($req, 'index');
			case "status_types": 
				return (new StatusTypeService())->dispatch($req, 'index');
			case "sap_sos": 
				return (new SapSoService())->dispatch($req, 'index');
			case "sap_rems": 
				return (new SapRemService())->dispatch($req, 'index');
			case "sap_bos": 
				return (new SapBoService())->dispatch($req, 'index');
			case "registers": 
				return (new RegisterService())->dispatch($req, 'index');
			case "contracts": 
				return (new ContractService())->dispatch($req, 'index');
			case "contract_status_types": 
				return (new ContractStatusTypeService())->dispatch($req, 'index');
			case "contract_types": 
				return (new ContractTypeService())->dispatch($req, 'index');
			case "contract_failure_types": 
				return (new ContractFailureTypeService())->dispatch($req, 'index');
			case "contract_inexpediency_types": 
				return (new ContractInexpediencyTypeService())->dispatch($req, 'index');
			case "users": 
				return (new UserService())->dispatch($req, 'index');
			case "connected_substations": 
				return (new SubstationService())->dispatch($req, 'index');
			case "connected_lines": 
				return (new LineService())->dispatch($req, 'index');
																					
			default: 
				return json_encode( DB::table("rems")->get() );
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
			//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $req) {
		switch ($req["id"]) {
			case "rems": 
				return "rems";
			case "owners":
				return (new OwnerService())->dispatch($req, 'store');												
			case "owner_types":
				return (new OwnerTypeService())->dispatch($req, 'store');
			case "equipment_types": 
				return (new EquipmentTypeService())->dispatch($req, 'store');
			case "location_types": 
				return (new LocationTypeService())->dispatch($req, 'store');
			case "tech_state_types": 
				return (new TechStateTypeService())->dispatch($req, 'store');
			case "line_section_types": 
				return (new LineSectionTypeService())->dispatch($req, 'store');
			case "line_types": 
				return (new LineTypeService())->dispatch($req, 'store');
			case "doc_types": 
				return (new DocTypeService())->dispatch($req, 'store');
			case "registers": 
				return (new RegisterService())->dispatch($req, 'store');
			case "documents": 
				return (new DocumentService())->dispatch($req, 'store');
			case "contract_types": 
				return (new ContractTypeService())->dispatch($req, 'store');
			case "contract_failure_types":
				return (new ContractFailureTypeService())->dispatch($req, 'store');
			case "contract_inexpediency_types": 
				return (new ContractInexpediencyTypeService())->dispatch($req, 'store');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, Request $req) {
		switch ($id) {
			case "owners": 
				return (new OwnerService())->dispatch($req, 'show');
			case 'owner_types':
				return (new OwnerTypeService())->dispatch($req, 'show');
			case "equipment_types": 
				return (new EquipmentTypeService())->dispatch($req, 'show');
			case "location_types": 
				return (new LocationTypeService())->dispatch($req, 'show');
			case "tech_state_types": 
				return (new TechStateTypeService())->dispatch($req, 'show');
			case "line_section_types": 
				return (new LineSectionTypeService())->dispatch($req, 'show');
			case "line_types": 
				return (new LineTypeService())->dispatch($req, 'show');
			case "doc_types": 
				return (new DocTypeService())->dispatch($req, 'show');
			case "registers": 
				return (new RegisterService())->dispatch($req, 'show');
			case "contracts": 
				return (new ContractService())->dispatch($req, 'show');
			case "documents": 
				return (new DocumentService())->dispatch($req, 'show');
			case "contract_types": 
				return (new ContractTypeService())->dispatch($req, 'show');
			case 'contract_failure_types':
				return (new ContractFailureTypeService())->dispatch($req, 'show');
			case "contract_inexpediency_types": 
				return (new ContractInexpediencyTypeService())->dispatch($req, 'show');
			case "users": 
				return (new UserService())->dispatch($req, 'show');
			case "substations": 
				return (new SubstationService())->dispatch($req, 'show');
			case "lines": 
				return (new LineService())->dispatch($req, 'show');
			case "connected_substations": 
				return (new SubstationService())->dispatch($req, 'show');
			case "connected_lines": 
				return (new LineService())->dispatch($req, 'show');
																	
			default:
				return json_encode(
					DB::table($id)->where("id", "=", $req["row_id"])->get()
				);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, Request $req) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, Request $req) {
		switch ($id) {
			case "rems": 
				return "rems";
			case "owners":
				return (new OwnerService())->dispatch($req, 'update');
			case "owner_types":
				return (new OwnerTypeService())->dispatch($req, 'update');
			case "equipment_types":
				return (new EquipmentTypeService())->dispatch($req, 'update');
			case "location_types": 
				return (new LocationTypeService())->dispatch($req, 'update');
			case "tech_state_types": 
				return (new TechStateTypeService())->dispatch($req, 'update');
			case "line_section_types": 
				return (new LineSectionTypeService())->dispatch($req, 'update');
			case "line_types": 
				return (new LineTypeService())->dispatch($req, 'update');
			case "doc_types": 
				return (new DocTypeService())->dispatch($req, 'update');
			case "registers": 
				return (new RegisterService())->dispatch($req, 'update');
			case "contract_types":
				return (new ContractTypeService())->dispatch($req, 'update');
			case "contract_failure_types":
				return (new ContractFailureTypeService())->dispatch($req, 'update');
			case "contract_inexpediency_types": 
				return (new ContractInexpediencyTypeService())->dispatch($req, 'update');
			case "users": 
				return (new UserService())->dispatch($req, 'update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $req) {
		switch ($id) {
			case "owners":
				return (new OwnerService())->dispatch($req, 'destroy');
			case "owner_types":
				return (new OwnerTypeService())->dispatch($req, 'destroy');
			case "equipment_types":
				return (new EquipmentTypeService())->dispatch($req, 'destroy');
			case "location_types": 
				return (new LocationTypeService())->dispatch($req, 'destroy');
			case "tech_state_types": 
				return (new TechStateTypeService())->dispatch($req, 'destroy');
			case "line_section_types": 
				return (new LineSectionTypeService())->dispatch($req, 'destroy');
			case "line_types": 
				return (new LineTypeService())->dispatch($req, 'destroy');
			case "doc_types": 
				return (new DocTypeService())->dispatch($req, 'destroy');
			case "registers": 
				return (new RegisterService())->dispatch($req, 'destroy');
			case "contract_types":
				return (new ContractTypeService())->dispatch($req, 'destroy');
			case "contract_failure_types":
				return (new ContractFailureTypeService())->dispatch($req, 'destroy');
			case "contract_inexpediency_types": 
				return (new ContractInexpediencyTypeService())->dispatch($req, 'destroy');
			case "users": 
				return (new UserService())->dispatch($req, 'destroy');
			}
	}

}

