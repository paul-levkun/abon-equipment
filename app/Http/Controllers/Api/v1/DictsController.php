<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\Owner;
use App\Models\Rem;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use App\Models\MyNames;
use App\Models\FailureType;
use App\Services\FailureTypeService;

	// !!!!!!!!!! DB::table('users')->where('votes', '>', 100)->dd();
	// !!!!!!!!!! DB::table('users')->where('votes', '>', 100)->dump();

class DictsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {
	// dd($req["id"], $req["page_id"], $req["page_size"]);

			$page_id = $req["page_id"];
			$page_size = $req["page_size"];
			$offset = ($page_id - 1) * $page_size;
			switch ($req["id"]) {
					case "rems": 
							return json_encode( [ 
									"count" => DB::table("rems")->count(),
									"dict" => DB::table("rems")->orderBy("sort")->offset($offset)->limit($page_size)->get() 
							] );
					case "owner_types": 
							return json_encode( [ 
									"count" => DB::table("owner_types")->count(),
									"dict" => DB::table("owner_types")->offset($offset)->limit($page_size)->get() 
							] );
					case "owners": 
							return json_encode( [ 
									"count" => DB::table("owners")->count(),
									"dict" => DB::table("owners")->offset($offset)->limit($page_size)->get() 
							] );
					case "failure_types": 
						// return json_encode( [ 
						// 		// // "count" => DB::table("failure_types")->count(),
						// 		// // "dict" => DB::table("failure_types")->offset($offset)->limit($page_size)->get() 
						// 		"count" => FailureType::count(),
						// 		"dict" => FailureType::all()
						// ] );
						// $service = new FailureTypeService();
						// return $service->dispatch([], 'index');
						return (new FailureTypeService())->dispatch(null, 'index');
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
				$err = $this->validateOwner($req);

				if (count($err) > 0) {
					return response(['errors' => $err], 422);
				}

				DB::table('owners')->insert([
					"id_res" => $req["rem"], "id_type_owner" => $req["type"], "ab_inn" => $req["code"], 
					"name" => $req["name"], "recvisit" => $req["properties"], "comments" => $req["comment"]
				]);

												return [
													"id" => $req["id"], "rem" => $req["rem"], "type" => $req["type"], "code" => $req["code"], 
													"name" => $req["name"], "properties" => $req["properties"], "comment" => $req["comment"]
												];
												
			case "owner_types":
				$err = $this->validateOwnerTypes($req);

				if (count($err) > 0) {
					return response(['errors' => $err], 422);
				}

				DB::table('owner_types')->insert([
					"name" => $req["name"], "short_name" => $req["short-name"],
				]);

												return [
													"id" => $req["id"], "name" => $req["name"], "short-name" => $req["short-name"],
												];

			case "failure_types":
				// $err = $this->validateFailureTypes($req);

				// if (count($err) > 0) {
				// 	return response(['errors' => $err], 422);
				// }

				// FailureType::create([
				// 	'name' => $req->name,
				// ]);

												// return [
												// 	"id" => $req["id"], "name" => $req["name"],
												// ];
				
				return (new FailureTypeService())->dispatch($req, 'store');
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
			case 'failure_types':
				return (new FailureTypeService())->dispatch($req, 'show');
		
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
				$err = $this->validateOwner($req);

				if (count($err) > 0) {
					return response(['errors' => $err], 422);
				}

				DB::table('owners')
					->where('id', "=", $req["row_id"])
					->update([
						"id_res" => $req["rem"], "id_type_owner" => $req["type"], "ab_inn" => $req["code"], 
						"name" => $req["name"], "recvisit" => $req["properties"], "comments" => $req["comment"]
					]);

												return [ "test" => "test", "idddd" => $id,
														"id" => $req["id"], "row_id" => $req["row_id"], "rem" => $req["rem"], "type" => $req["type"], "code" => $req["code"], 
													"name" => $req["name"], "properties" => $req["properties"], "comment" => $req["comment"]
												];

			case "owner_types":
				$err = $this->validateOwnerTypes($req);

				if (count($err) > 0) {
					return response(['errors' => $err], 422);
				}

				DB::table('owner_types')
					->where('id', "=", $req["row_id"])
					->update([
						"name" => $req["name"], "short_name" => $req["short-name"],
					]);

												return [ "row_id" => $req["row_id"], "dict_id" => $id,
													"dict_id" => $req["id"], "name" => $req["name"], "short-name" => $req["short-name"],
												];

			case "failure_types":
				// $err = $this->validateFailureTypes($req);

				// if (count($err) > 0) {
				// 	return response(['errors' => $err], 422);
				// }

				// $model = FailureType::find($req->row_id);
				// $model->name = $req->name;
				// $model->save();

				// 								return [ "row_id" => $req["row_id"], "dict_id" => $id,
				// 									"dict_id" => $req["id"], "name" => $req["name"],
				// 								];

				return (new FailureTypeService())->dispatch($req, 'update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $req) {
		// $validator = Validator::make($req->all(), [
		// 	'row_id' => 'unique:owners,id_type_owner'
		// ]);
		// if ($validator->fails()) {
		// 	 $err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
		//  	return $err;
		// }

		// // DB::table($id)->where("id", "=", $req["row_id"])->delete();

		// return [ 
		// 	"id" => $id,
		// 	"row_id" => $req["row_id"],
		// ];
		switch ($id) {
			case "failure_types":
				return (new FailureTypeService())->dispatch($req, 'destroy');
		}
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function validateOwner($req) {
		$err = [];

		$validator = Validator::make($req->all(), [
			'code' => 'required',
		]);
		if ($validator->fails()) {
			$err['code'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'name' => 'required',
		]);
		if ($validator->fails()) {
			$err['name'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'rem' => 'required',
		]);
		if ($validator->fails()) {
			$err['rem'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'type' => 'required',
		]);
		if ($validator->fails()) {
			$err['type'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'properties' => 'required',
		]);
		if ($validator->fails()) {
			$err['properties'] = $validator->errors()->all();
		}

		return $err;
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function validateOwnerTypes($req) {
		$err = [];

		$validator = Validator::make($req->all(), [
			'name' => 'string|min:8|required|unique:owner_types,name',
		]);
		if ($validator->fails()) {
			$err['name'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'short-name' => 'required',
		]);
		if ($validator->fails()) {
			$err['short-name'] = $validator->errors()->all();
		}

		return $err;
	}

	// /**
	//  * @param \Illuminate\Http\Request $request
	//  * @return array
	//  */
	// private function validateFailureTypes($req) {
	// 	$err = [];

	// 	$validator = Validator::make($req->all(), [
	// 		'name' => 'required|unique:failure_types,name',
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['name'] = $validator->errors()->all();
	// 	}

	// 	return $err;
	// }
}

