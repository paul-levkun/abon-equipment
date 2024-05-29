<?php

namespace App\Services;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Document;

class DocumentService {

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
        "count" => Document::count(),
        "dict" => Document::offset($offset)->limit($page_size)->get()
      ]);
    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    $query = Document::query()/*->with('registers')->with('doc_types')*/;
    return json_encode( 
      $query->where("register_id", $req['row_id'])->orderBy("doc_type_id")->get()
    );
    // return json_encode( 
    //   [ $req['row_id'] ]
    // );
  }

  protected function store(Request $req) { 
  try {
    // $err = $this->fieldValidate($req);

    // if (count($err) > 0) {
    //   return response(['errors' => $err], 422);
    // }

    Document::create([
      'register_id' => $req->register_id,
      'doc_type_id' => $req->doc_type_id,
      'file_path' => $req->file_path,
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

    $model = Document::find($req->row_id);
    $model->name = $req->name;
    $model->save();
  }

  protected function destroy(Request $req) { 
    $err = $this->destroyValidate($req);

    if (count($err) > 0) {
    	return response(['errors' => $err], 422);
    }

    Document::where("id", $req["row_id"])->delete();
  }

  /////////////////////////////////////// Задіяти Requests

 	/**
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	private function fieldValidate($req) {
		$err = [];

		$validator = Validator::make($req->all(), [
			'name' => 'required|unique:documents,name,' . $req->row_id,
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