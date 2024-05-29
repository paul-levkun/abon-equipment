<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Contract;
use App\Models\Owner;

class ContractService {

  public function dispatch(Request $req = null, $method = 'index') {
    switch ($method) {
      case "index":
        return $this->index($req);
      case "show":
        return $this->show($req);
      case "store":
        return $this->store($req);
      case "update":
        return $this->update($req);
      case "destroy":
        return $this->destroy($req);
      default: 
        throw new \Exception("Method not found", 404);
    }
  }

  protected function index(Request $req) { 
    try {
      $page_id = $req["page_id"];
			$page_size = $req["page_size"];
			$offset = ($page_id - 1) * $page_size;

      // $query = Contract::query();

      $query = Contract::query()->with('owners')->with('sap_bos');

      if (isset($req["sap_bo_id"]) && $req["sap_bo_id"] !== "0") {
        $query = $query->where("sap_bo_id", $req["sap_bo_id"]);
      }

      if (isset($req["code"])) {
        $query = $query->where("code", "LIKE", "%" . $req["code"] . "%");
      }

      if (isset($req["owner_code"])) {
        $query = $query->whereHas('owners', function ($queryOwners) use ($req) {
          $queryOwners->where('ab_inn', "LIKE", "%" . $req["owner_code"] . "%");
        });
      }

      if (isset($req["owner_name"])) {
        $query = $query->whereHas('owners', function ($queryOwners) use ($req) {
          $queryOwners->where('name', "LIKE", "%" . $req["owner_name"] . "%");
        });
      }

      // Log::error($query->toSql());

      return json_encode([ 
        "count" => $query->count(),
        "dict" => $query->offset($offset)->limit($page_size)->get()//all() // paginate(100)
      ]);

    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    $ds = Contract::where("id", $req['row_id'])->get();
    if (isset($ds[0]['owner_id'])) {
      $owner = Owner::where("id", $ds[0]['owner_id'])->get();
      $ds[0]['owner_name'] = $owner[0]['name'];
      // Log::error($owner[0]['name']);
    }
    // else
    //   $ds[0]['contracts']['owner_name'] = "***";

    return json_encode($ds);
  }

  protected function store(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    //   return response(['errors' => $err], 422);
    // }

    // Contract::create([
    //   "id_res" => $req["rem"], "id_type_Contract" => $req["type"], "ab_inn" => $req["code"], 
		// 	"name" => $req["name"], "recvisit" => $req["properties"], "comments" => $req["comment"]
    // ]);  
  }

  protected function update(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // $model = Contract::find($req->row_id);
    // $model["id_res"] = $req["rem"]; $model["id_type_Contract"] = $req["type"]; $model["ab_inn"] = $req["code"]; 
    // $model["name"] = $req["name"]; $model["recvisit"] = $req["properties"]; $model["comments"] = $req["comment"];
    // $model->save();
  }

  protected function destroy(Request $req) { 
    // $err = $this->destroyValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // Contract::where("id", $req["row_id"])->delete();
  }

  /////////////////////////////////////// Задіяти Requests (а може й нє) )

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	// private function fieldValidate($req) {
  // try{
	// 	$err = [];

	// 	$validator = Validator::make($req->all(), [
	// 		'code' => 'required|unique:contracts,ab_inn,' . $req->row_id,
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['code'] = $validator->errors()->all();
	// 	}

	// 	$validator = Validator::make($req->all(), [
	// 		'name' => 'required|unique:Contracts,name,' . $req->row_id,
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['name'] = $validator->errors()->all();
	// 	}

	// 	$validator = Validator::make($req->all(), [
	// 		'rem' => 'required',
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['rem'] = $validator->errors()->all();
	// 	}

	// 	$validator = Validator::make($req->all(), [
	// 		'type' => 'required',
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['type'] = $validator->errors()->all();
	// 	}

	// 	$validator = Validator::make($req->all(), [
	// 		'properties' => 'required',
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['properties'] = $validator->errors()->all();
	// 	}

  //   response()->json(['errrror' => $req], 500);

	// 	return $err;
  // }
  // catch (\Exception $e) {
  //   Log::error($e->getMessage());
  //   return response()->json(['error' => 'Internal Server Error'], 500);
  // }
	// }

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	// private function destroyValidate($req) {
	// 	$err = [];

	// 	// $validator = Validator::make($req->all(), [
	// 	// 	'row_id' => 'unique:Contracts,id_type_Contract'
	// 	// ]);
	// 	// if ($validator->fails()) {
	// 	// 	$err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
	// 	//  	return $err;
	// 	// }

	// 	return $err;
	// }

}