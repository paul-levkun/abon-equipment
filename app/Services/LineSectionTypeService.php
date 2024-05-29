<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\LineSectionType;
use App\Models\LogAction;

class LineSectionTypeService {

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
        "count" => LineSectionType::where("is_deleted", false)->count(),
        "dict" => LineSectionType::where("is_deleted", false)->offset($offset)->limit($page_size)->get()
      ]);
    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    return json_encode( 
      LineSectionType::where("id", $req['row_id'])->get()
    );
  }

  protected function store(Request $req) { 
  try {
    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
      return response(['errors' => $err], 422);
    }

    LineSectionType::create([
      'name' => $req->name,
      'user_id' => $req->user_id,
    ]);  
  }
  catch (\Exception $e) {
    Log::error($e->getMessage());
    return response()->json(['error' => 'Internal Server Error'], 500);
  }
  }

  protected function update(Request $req) { 
    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
    	return response(['errors' => $err], 422);
    }

    $ds_old = LineSectionType::where("id", $req->row_id)->get();

    $model = LineSectionType::find($req->row_id);
    $model->name = $req->name;
    $model->user_id = $req->user_id;
    $model->save();

    LogAction::create([
      'table_id' => "line_section_types",
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

    // LineSectionType::where("id", $req["row_id"])->delete();

    $model = LineSectionType::find($req->row_id);
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
			'name' => 'required|unique:line_section_types,name,' . $req->row_id . ',id,is_deleted,0',
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

		$validator = Validator::make($req->all(), [
			'row_id' => 'unique:registers,line_section_type_id'
		]);
		if ($validator->fails()) {
			 $err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
		 	return $err;
		}

		return $err;
	}

}