<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\SapBo;

class SapBoService {

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

      return json_encode([ 
        "count" => SapBo::where("active", true)->count(),
        "dict" => SapBo::where("active", true)->offset($offset)->limit($page_size)->get()
      ]);
    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    // return json_encode( 
    //   SapBo::where("id", $req['row_id'])->get()
    // );
  }

  protected function store(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    //   return response(['errors' => $err], 422);
    // }

    // SapBo::create([
    //   'name' => $req->name,
    // ]);  
  }

  protected function update(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // $model = SapBo::find($req->row_id);
    // $model->name = $req->name;
    // $model->save();
  }

  protected function destroy(Request $req) { 
    // $err = $this->destroyValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // SapBo::where("id", $req["row_id"])->delete();
  }

  /////////////////////////////////////// Задіяти Requests

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	// private function fieldValidate($req) {
	// 	$err = [];

	// 	$validator = Validator::make($req->all(), [
	// 		'name' => 'required|unique:sap_bos,name',
	// 	]);
	// 	if ($validator->fails()) {
	// 		$err['name'] = $validator->errors()->all();
	// 	}

	// 	return $err;
	// }

 	// /**
	//  * @param \Illuminate\Http\Request $request
	//  * @return array
	//  */
	// private function destroyValidate($req) {
	// 	$err = [];

	// 	// $validator = Validator::make($req->all(), [
	// 	// 	'row_id' => 'unique:owners,id_type_owner'
	// 	// ]);
	// 	// if ($validator->fails()) {
	// 	// 	 $err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
	// 	//  	return $err;
	// 	// }

	// 	return $err;
	// }

}