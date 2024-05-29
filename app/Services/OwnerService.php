<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Owner;
use App\Models\LogAction;

class OwnerService {

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

      $query = Owner::query();

      // if (isset($req["sap_so_id"])) {
      //   $query = $query->where("sap_so_id", $req["sap_so_id"]);
      // }

      // if (isset($req["sap_rem_id"])) {
      //   $query = $query->where("sap_rem_id", $req["sap_rem_id"]);
      // }

      if (isset($req["sap_code"])) {
        $query = $query->where("sap_code", "LIKE", "%" . $req["sap_code"] . "%");
      }

      if (isset($req["ab_inn"])) {
        $query = $query->where("ab_inn", "LIKE", "%" . $req["ab_inn"] . "%");
      }

      if (isset($req["name"])) {
        $query = $query->where("name", "LIKE", "%" . $req["name"] . "%");
      }

      if (isset($req["recvisit"])) {
        $query = $query->where("recvisit", "LIKE", "%" . $req["recvisit"] . "%");
      }                                                        

      return json_encode([ 
        "count" => $query->where("is_deleted", false)->count(),
        "dict" => $query->where("is_deleted", false)->offset($offset)->limit($page_size)->get()//all() // paginate(100)
      ]);

      // return json_encode([ 
      //   // "count" => Owner::where("id_res", 26)->count(),
      //   // "dict" => Owner::where("id_res", 26)->offset($offset)->limit($page_size)->get()//all() // paginate(100)
      //   "count" => Owner::count(),
      //   "dict" => Owner::offset($offset)->limit($page_size)->get()//all() // paginate(100)
      // ]);
    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    return json_encode( 
      Owner::where("id", $req['row_id'])->get()
    );
  }

  protected function store(Request $req) { 
    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
      return response(['errors' => $err], 422);
    }

    Owner::create([
      // "id_res" => $req["rem"],
      "id_type_owner" => $req["type"], "ab_inn" => $req["code"], 
			"name" => $req["name"], "recvisit" => $req["properties"], "comments" => $req["comment"],
      'user_id' => $req->user_id,
    ]);  
  }

  protected function update(Request $req) { 
    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
    	return response(['errors' => $err], 422);
    }

    $ds_old = Owner::where("id", $req->row_id)->get();

    $model = Owner::find($req->row_id);
    // $model["id_res"] = $req["rem"]; 
    $model["id_type_owner"] = $req["type"]; $model["ab_inn"] = $req["code"]; 
    $model["name"] = $req["name"]; $model["recvisit"] = $req["properties"]; $model["comments"] = $req["comment"];
    $model->user_id = $req->user_id;
    $model->save();

    LogAction::create([
      'table_id' => "owners",
      'row_id' => $req->row_id,
      'old_json' => json_encode($ds_old[0], JSON_UNESCAPED_UNICODE),
      'new_json' => json_encode($req->all(), JSON_UNESCAPED_UNICODE),
      'user_id' => $req->user_id,
    ]);
  }

  protected function destroy(Request $req) { 
    $err = $this->destroyValidate($req);

    if (count($err) > 0) {
    	return response(['errors' => $err], 422);
    }

    // Owner::where("id", $req["row_id"])->delete();

    $model = Owner::find($req->row_id);
    $model->user_id = $req->user_id;
    $model->is_deleted = true;
    $model->save();
  }

  /////////////////////////////////////// Задіяти Requests (а може й нє) )

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function fieldValidate($req) {
  try {
		$err = [];

		$validator = Validator::make($req->all(), [
			'code' => 'required|unique:owners,ab_inn,' . $req->row_id . ',id,is_deleted,0',
		]);
		if ($validator->fails()) {
			$err['code'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'name' => 'required|unique:owners,name,' . $req->row_id,  
		]);
		if ($validator->fails()) {
			$err['name'] = $validator->errors()->all();
		}

		// $validator = Validator::make($req->all(), [
		// 	'rem' => 'required',
		// ]);
		// if ($validator->fails()) {
		// 	$err['rem'] = $validator->errors()->all();
		// }

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

    // response()->json(['errrror' => $req], 500);

		return $err;
  }
  catch (\Exception $e) {
    Log::error($e->getMessage());
    return response()->json(['error' => 'Internal Server Error'], 500);
  }
	}

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function destroyValidate($req) {
		$err = [];

		$validator = Validator::make($req->all(), [
			'row_id' => 'unique:registers,owner_id'
		]);
		if ($validator->fails()) {
			$err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
		 	return $err;
		}

		return $err;
	}

}