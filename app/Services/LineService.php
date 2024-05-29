<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Line;

class LineService {

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

      $query = Line::query()
        ->with('object_types')
        ->with('sap_sos')
        ->with('sap_rems');

      if (isset($req["sap_so_id"]) && $req["sap_so_id"] !== "0") {
        $query = $query->where("sap_so_id", $req["sap_so_id"]);
      }

      if (isset($req["sap_rem_id"])) {
        $query = $query->where("sap_rem_id", $req["sap_rem_id"]);
      }

      if (isset($req["code"])) {
        $query = $query->where("code", "LIKE", "%" . $req["code"] . "%");
      }

      if (isset($req["name"])) {
        $query = $query->where("name", "LIKE", "%" . $req["name"] . "%");
      }

      if (isset($req["settlement"])) {
        $query = $query->where("settlement", "LIKE", "%" . $req["settlement"] . "%");
      }

      if (isset($req["street"])) {
        $query = $query->where("street", "LIKE", "%" . $req["street"] . "%");
      }

      if (isset($req["status_type_id"]) && $req["status_type_id"] !== "0") {
        $query = $query->where("status_type_id", $req["status_type_id"]);
      }

      if (isset($req["object_type_id"])) {
        $query = $query->where("object_type_id", $req["object_type_id"]);
      }

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
    return json_encode( 
      Line::where("id", $req['row_id'])->get()
    );
  }

  protected function store(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    //   return response(['errors' => $err], 422);
    // }

    // Line::create([
    //   "id_res" => $req["rem"], "id_type_Line" => $req["type"], "ab_inn" => $req["code"], 
		// 	"name" => $req["name"], "recvisit" => $req["properties"], "comments" => $req["comment"]
    // ]);  
  }

  protected function update(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // $model = Line::find($req->row_id);
    // $model["id_res"] = $req["rem"]; $model["id_type_Line"] = $req["type"]; $model["ab_inn"] = $req["code"]; 
    // $model["name"] = $req["name"]; $model["recvisit"] = $req["properties"]; $model["comments"] = $req["comment"];
    // $model->save();
  }

  protected function destroy(Request $req) { 
    // $err = $this->destroyValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // Line::where("id", $req["row_id"])->delete();
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
	// 		'code' => 'required|unique:lines,ab_inn,' . $req->row_id,
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['code'] = $validator->errors()->all();
	// 	}

	// 	$validator = Validator::make($req->all(), [
	// 		'name' => 'required|unique:Lines,name,' . $req->row_id,
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
	// 	// 	'row_id' => 'unique:Lines,id_type_Line'
	// 	// ]);
	// 	// if ($validator->fails()) {
	// 	// 	$err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
	// 	//  	return $err;
	// 	// }

	// 	return $err;
	// }

}