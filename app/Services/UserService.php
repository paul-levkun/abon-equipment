<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\LogAction;

class UserService {

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

      $query = User::query()->with('sap_sos')->with('sap_rems')->with('sap_bos');

      return json_encode([ 
        "count" => $query->where("is_deleted", false)->count(),
        "dict" => $query->where("is_deleted", false)->offset($offset)->limit($page_size)->get()
      ]);
    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    $query = User::query()->with('sap_sos')->with('sap_rems')->with('sap_bos');
    return json_encode( 
      // User::with('sap_sos')->with('sap_rems')->with('sap_bos')->where("id", $req['row_id'])->get()
      $query->where("id", $req['row_id'])->get(), JSON_UNESCAPED_UNICODE
    );
  }

  protected function store(Request $req) { 
  try {
    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
      return response(['errors' => $err], 422);
    }

    User::create([
      'name' => $req->name,
      // 'user_id' => $req->user_id,
    ]);  
  }
  catch (\Exception $e) {
    Log::error($e->getMessage());
    return response()->json(['error' => 'Internal Server Error'], 500);
  }
  }

  protected function update(Request $req) { 
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    // 	return response(['errors' => $err], 422);
    // }

    // $so_id = $req->so_id === "" ? 0 : $req->so_id;
    // $rem_id = empty($req->rem_id) ? 0 : $req->rem_id;
    // $bo_id = empty($req->bo_id) ? 0 : $req->bo_id;
    $user_id = $req->user_id === "" ? 0 : $req->user_id;

    // $so_id = empty($req->so_id) ? -1 : $req->so_id;
    // $rem_id = empty($req->rem_id) ? (empty($req->so_id) ? -1 : 0) : $req->rem_id;
    // $bo_id = empty($req->bo_id) ? -1 : $req->bo_id;
    $so_id = $req->so_id;
    $rem_id = $req->rem_id > 0 ? $req->rem_id : ($so_id >= 0 ? 0 : -1);
    $bo_id = $req->bo_id;

    $ds_old = User::where("id", $req->row_id)->get();

    $model = User::find($req->row_id);
    $model->so_id = $so_id;
    $model->rem_id = $rem_id;
    $model->bo_id = $bo_id;
    $model->user_id = $user_id;
    $model->save();

    LogAction::create([
      'table_id' => "users",
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

    // User::where("id", $req["row_id"])->delete();

    $model = User::find($req->row_id);
    $model->user_id = $req->user_id;
    $model->is_deleted = true;
    $model->save();
  }

  /////////////////////////////////////// Задіяти Requests

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function fieldValidate($req) {
		$err = [];

		$validator = Validator::make($req->all(), [
			'name' => 'required|unique:users,name,' . $req->row_id . ',id,is_deleted,0',
		]);
		if ($validator->fails()) {
			$err['name'] = $validator->errors()->all();
		}

		return $err;
	}

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function destroyValidate($req) {
		$err = [];

		// $validator = Validator::make($req->all(), [
		// 	'row_id' => 'unique:owners,id_type_owner'
		// ]);
		// if ($validator->fails()) {
		// 	 $err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
		//  	return $err;
		// }

		return $err;
	}

}