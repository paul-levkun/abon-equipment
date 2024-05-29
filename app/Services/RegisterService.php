<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Register;
use App\Models\Owner;
use App\Models\Document;
use App\Models\LogAction;
use Illuminate\Validation\Rule;

class RegisterService {

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

      $query = Register::query()->with('substations')->with('lines')
        ->with('connected_substations')->with('connected_lines')
        ->with(['substations.object_types'])->with(['lines.object_types'])
        ->with('sap_sos')->with('sap_rems')
        ->with('owners')->with('contracts')
        ->with('contract_types')
        ->with('contract_inexpediency_types')
        ->with('contract_failure_types')
        ->with('contract_status_types')
        ->withCount('documents');

      // $query = Register::query()->with('object_types');

      if (isset($req["sap_so_id"]) && $req["sap_so_id"] !== "0") {
        $query = $query->where("sap_so_id", $req["sap_so_id"]);
      }

      if (isset($req["sap_rem_id"]) && $req["sap_rem_id"] !== "0") {
        $query = $query->where("sap_rem_id", $req["sap_rem_id"]);
      }

      if (isset($req["object_code"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->orWhereHas('substations', 
              function ($query) use ($req) {
                $query->where("code", "LIKE", "%" . $req["object_code"] . "%");
              }
            )->orWhereHas('lines', 
              function ($query) use ($req) {
                $query->where("code", "LIKE", "%" . $req["object_code"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["object_name"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->orWhereHas('substations', 
              function ($query) use ($req) {
                $query->where("name", "LIKE", "%" . $req["object_name"] . "%");
              }
            )->orWhereHas('lines', 
              function ($query) use ($req) {
                $query->where("name", "LIKE", "%" . $req["object_name"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["object_type_id"]) && $req["object_type_id"] !== "0") {
        $query = $query->where(
          function ($q) use ($req) {
            $q->orWhereHas('substations', 
              function ($query) use ($req) {
                $arr = explode(",", $req["object_type_id"]);
                $query->whereIn("object_type_id", $arr);
              }
            )->orWhereHas('lines', 
              function ($query) use ($req) {
                $arr = explode(",", $req["object_type_id"]);
                $query->where("object_type_id", $arr);
              }
            );
          }
        );
      }

      // if (isset($req["contract_inexpediency_type_id"]) && $req["contract_inexpediency_type_id"] !== "0") {
      //   $query = $query->where("contract_inexpediency_type_id", $req["contract_inexpediency_type_id"]);
      // }

      if (isset($req["contract_inexpediency_type_id"]) && $req["contract_inexpediency_type_id"] !== "0") {
        $query = $query->where(
          function ($q) use ($req) {
            $q->where("contract_inexpediency_type_id", $req["contract_inexpediency_type_id"]);
            if ($req["contract_inexpediency_type"] === "Невизначено") {
              $q->orWhereNull("contract_inexpediency_type_id");
            }
          }
        );
      }

      if (isset($req["owner_code"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->whereHas('owners', 
              function ($query) use ($req) {
                $query->where("sap_code", "LIKE", "%" . $req["owner_code"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["owner_code"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->whereHas('owners', 
              function ($query) use ($req) {
                $query->where("sap_code", "LIKE", "%" . $req["owner_code"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["owner_inn"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->whereHas('owners', 
              function ($query) use ($req) {
                $query->where("ab_inn", "LIKE", "%" . $req["owner_inn"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["owner_name"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->whereHas('owners', 
              function ($query) use ($req) {
                $query->where("name", "LIKE", "%" . $req["owner_name"] . "%");
              }
            );
          }
        );
      }

      if (isset($req["contract_status_type_id"]) && $req["contract_status_type_id"] !== "0") {
        $query = $query->where(
          function ($q) use ($req) {
            $q->where("contract_status_type_id", $req["contract_status_type_id"]);
            if ($req["contract_status_type"] === "Невизначено") {
              $q->orWhereNull("contract_status_type_id");
            }
          }
        );
      }
      // 300079180
      // 300223481

      if (isset($req["contract_failure_type_id"]) && $req["contract_failure_type_id"] !== "0") {
        $query = $query->where("contract_failure_type_id", $req["contract_failure_type_id"]);
      }

      if (isset($req["contract_type_id"]) && $req["contract_type_id"] !== "0") {
        $query = $query->where("contract_type_id", $req["contract_type_id"]);
      }

      if (isset($req["contract_code"])) {
        $query = $query->where(
          function ($q) use ($req) {
            $q->whereHas('contracts', 
              function ($query) use ($req) {
                $query->where("code", "LIKE", "%" . $req["contract_code"] . "%");
              }
            );
          }
        );
      }

      return json_encode([ 
        "count" => $query->where("is_deleted", false)->count(),
        "dict" => $query->where("is_deleted", false)->offset($offset)->limit($page_size)->get()//all() // paginate(100)
      ]);

    }
    catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Internal Server Error'], 500);
    }
  }

  protected function show(Request $req) { 
    $query = Register::query()->with('substations')->with('lines')->with('owners')->with('contracts')
      ->with('connected_substations')->with('connected_lines');
    $ds = $query->where("id", $req['row_id'])->get();

    if (isset($ds[0]['contracts']['owner_id'])) {
      $owner = Owner::where("id", $ds[0]['contracts']['owner_id'])->get();
      $ds[0]['contracts']['owner_name'] = $owner[0]['name'];
      // Log::error($owner[0]['name']);
    }

    return json_encode($ds);
  }

  protected function store(Request $req) { 
    // error_reporting(~E_ALL);
    // return response(['errors' => [1,2,3,4,5]], 422);
    // error_reporting(E_ALL & ~E_NOTICE);
    // ini_set('error_reporting', E_ALL & ~E_NOTICE);
    // ini_set('display_errors', 'off');

    $err = $this->fieldValidate($req);
    // Log::error($err);

    if (count($err) > 0) {
      // return response($err);
      return response()->json(['errors' => $err], 422);
      // return response(null, 422);
      // return response(['errors' => $err, 'adv' => [3,2,1]], 422);
    }

    Log::error("-------");

    // Log::error($req["cond_units"]);

    $register = Register::create([
      "sap_so_id" => $req["sap_so_id"],
      "sap_rem_id" => $req["sap_rem_id"],
      "substation_id" => $req["substation_id"],
      "line_id" => $req["line_id"],
      "location_type_id" => $req["location_type_id"],
      "line_section_type_id" => $req["line_section_type_id"],
      "tech_state_type_id" => $req["tech_state_type_id"],
      "in_cds_id" => $req["in_cds_id"],
      "cond_units" => $req["cond_units"],
      "owner_id" => $req["owner_id"],
      "contract_id" => $req["contract_id"],
      "contract_status_type_id" => $req["contract_status_type_id"],
      "contract_type_id" => $req["contract_type_id"],
      "contract_failure_type_id" => $req["contract_failure_type_id"],
      "contract_inexpediency_type_id" => $req["contract_inexpediency_type_id"],
      "connected_substation_id" => $req["connected_substation_id"],
      "connected_line_id" => $req["connected_line_id"],
      "comment" => $req["comment"],
      'user_id' => $req->user_id,
    ]);

    $newId = $register->id;

    /////////////////////////////////////			
    // Збереження файлів на сервер
    if ($req->hasFile('file_docs')) {
      $docs = $req->file('file_docs');
      foreach ($docs as $doc) {
        $file_name = $doc->getClientOriginalName();

        $randName = uniqid(/*'temp_',*/ true);
        // $folder = config('app.LOCAL_PATH'); // $folder = env('LOCAL_PATH');
        $folder = config('app.FTP_PATH'); // $folder = env('FTP_PATH');

        try {
          $path = $doc->storeAs("{$folder}{$randName}", $file_name); 
          // $arr[] = json_encode("{$folder)}{$randName}/" . $file_name, JSON_UNESCAPED_UNICODE);
        }
        catch (\Exception $e) {
          Log::error($e->getMessage());
          return response()->json(['errors' => [ 
            "ftp" => ["Помилка FTP сервера: \"" . $e->getMessage() . "\". Звернітся до адміністратора мережі"]
          ]], 500);
        }

        DB::table('documents')->insert([
          'register_id' => $newId,
          'doc_type_id' => $req->doc_type_id,
          'file_path' => "{$folder}{$randName}/" . $file_name,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ]);
      }

      // return json_encode(['files' => $arr]);
    }
    // Збереження файлів на сервер
    /////////////////////////////////////
  }

  protected function update(Request $req) { 

    // error_reporting(E_ALL & ~E_NOTICE);
    // ini_set('error_reporting', E_ALL & ~E_NOTICE);

    $err = $this->fieldValidate($req);

    if (count($err) > 0) {
    	return response(['errors' => $err], 422);
    }

    $ds_old = Register::where("id", $req->row_id)->get();

    $model = Register::find($req->row_id);
    $model["sap_so_id"] = $req["sap_so_id"];
    $model["sap_rem_id"] = $req["sap_rem_id"];
    $model["substation_id"] = $req["substation_id"];
    $model["line_id"] = $req["line_id"];
    $model["location_type_id"] = $req["location_type_id"];
    $model["line_section_type_id"] = $req["line_section_type_id"];
    $model["tech_state_type_id"] = $req["tech_state_type_id"];
    $model["in_cds_id"] = $req["in_cds_id"];
    $model["cond_units"] = $req["cond_units"];
    $model["owner_id"] = $req["owner_id"];
    $model["contract_id"] = $req["contract_id"];
    $model["contract_status_type_id"] = $req["contract_status_type_id"];
    $model["contract_type_id"] = $req["contract_type_id"];
    $model["contract_failure_type_id"] = $req["contract_failure_type_id"];
    $model["contract_inexpediency_type_id"] = $req["contract_inexpediency_type_id"];
    $model["connected_substation_id"] = $req["connected_substation_id"];
    $model["connected_line_id"] = $req["connected_line_id"];
    $model["comment"] = $req["comment"];
    $model->user_id = $req->user_id;

    $register = $model->save();

    /////////////////////////////////////			
    // Збереження файлів на сервер
    if ($req->hasFile('file_docs')) {
      $docs = $req->file('file_docs');
      $arr = [];
      foreach ($docs as $doc) {
        $file_name = $doc->getClientOriginalName();

        $randName = uniqid(/*'temp_',*/ true);
        // $folder = config('app.LOCAL_PATH'); // $folder = env('LOCAL_PATH');
        $folder = config('app.FTP_PATH'); // $folder = env('FTP_PATH');

        try {
          $path = $doc->storeAs("{$folder}{$randName}", $file_name); 
          // $arr[] = json_encode("{$folder)}{$randName}/" . $file_name, JSON_UNESCAPED_UNICODE);
        }
        catch (\Exception $e) {
          Log::error($e->getMessage());
          return response()->json(['errors' => [ 
            "ftp" => ["Помилка FTP сервера: \"" . $e->getMessage() . "\". Звернітся до адміністратора мережі"]
          ]], 500);
        }

        DB::table('documents')->insert([
          'register_id' => $req->row_id,
          'doc_type_id' => $req->doc_type_id,
          'file_path' => "{$folder}{$randName}/" . $file_name,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ]);
      }

      // return json_encode(['files' => $arr]);
    }
    // Збереження файлів на сервер
    /////////////////////////////////////

    /////////////////////////////////////
		// файли на видалення
    $arrDeletedFiles = $arrDeletedDB = [];
    $arrDeletedDocs = json_decode($req->deleted_docs);
    foreach($arrDeletedDocs as $deletedDoc) {
      $arrDeletedFiles[] = $deletedDoc->fileRelPath;
      $arrDeletedDB[] = $deletedDoc->id;
    }

    if (count($arrDeletedFiles) > 0) {
			// Storage::delete($arrDeletedFiles);            // Тільки файли
      foreach($arrDeletedFiles as $deletedFile) {
        $parentDirectory = dirname($deletedFile);
        Storage::deleteDirectory($parentDirectory); // Взагалі-то, видалення разом з файлами
      }

			DB::table('documents')->whereIn('id', $arrDeletedDB)->delete();
		}
    // файли на видалення
    /////////////////////////////////////

    // return json_encode(['files' => $arrDeletedFiles]);
    // file_put_contents("log.txt", "3");

    LogAction::create([
      'table_id' => "registers",
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

    // Register::where("id", $req["row_id"])->delete();

    $model = Register::find($req->row_id);
    $model->user_id = $req->user_id;
    $model->is_deleted = true;
    $model->save();

    /////////////////////////////////////
		// файли на видалення
    $dsDeletedDocs = Document::where("register_id", $req["row_id"])->get();

    $arrDeletedFiles = $arrDeletedDB = [];
    foreach($dsDeletedDocs as $deletedDoc) {
      $arrDeletedFiles[] = $deletedDoc->file_path;
      $arrDeletedDB[] = $deletedDoc->id;
    }

    if (count($arrDeletedFiles) > 0) {
			// Storage::delete($arrDeletedFiles);            // Тільки файли
      foreach($arrDeletedFiles as $deletedFile) {
        $parentDirectory = dirname($deletedFile);
        Storage::deleteDirectory($parentDirectory); // Взагалі-то, видалення разом з файлами
      }

			DB::table('documents')->whereIn('id', $arrDeletedDB)->delete();
		}
    // файли на видалення
    /////////////////////////////////////

    // return json_encode(['files' => json_encode($arrDeletedFiles, JSON_UNESCAPED_UNICODE), 'db' => json_encode($dsDeletedDocs, JSON_UNESCAPED_UNICODE) ]);
    return ['files' => $arrDeletedFiles, 'db' => $dsDeletedDocs ];
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
			'sap_so_id' => 'required',
		]);
		if ($validator->fails()) {
			$err['sap_so'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'sap_rem_id' => 'required',
		]);
		if ($validator->fails()) {
			$err['sap_rem'] = $validator->errors()->all();
		}

    Log::error($req["id"]);
    $validator = Validator::make($req->all(), 
      // [ 'substation_id' => 'required_without:line_id',
      //   'line_id' => 'required_without:substation_id',
      // ],
      // [ 'substation_id.required_without' => __('validation.required_without_substation_id', ['attribute' => __('attributes.substation_id')]),
      //   'line_id.required_without' => __('validation.required_without_line_id', ['attribute' => __('attributes.line_id')]),
      // ],
      // Нижче - невірно
      // ['substation_id' => 'unique:registers,substation_id,' . $req->substation_id . ',id,is_deleted,0',],
      // ['line_id' => 'unique:registers,line_id,' . $req->line_id . ',id,is_deleted,0',]
      [
        'substation_id' => [
            'required_without:line_id',
            Rule::unique('registers')->where(function ($query) use ($req) {
              return $query
                ->where('substation_id', $req->substation_id)
                ->where('is_deleted', 0)
                ->whereNotNull('substation_id');
            })->ignore($req->row_id),
        ],
        'line_id' => [
            'required_without:substation_id',
            Rule::unique('registers')->where(function ($query) use ($req) {
              return $query
                ->where('line_id', $req->line_id)
                ->where('is_deleted', 0)
                ->whereNotNull('line_id');
            })->ignore($req->row_id),
        ],
      ],
      [
        'substation_id.required_without' => __('validation.required_without_substation_id', ['attribute' => __('attributes.substation_id')]),
        'line_id.required_without' => __('validation.required_without_line_id', ['attribute' => __('attributes.line_id')]),
      ],
      
    );
		if ($validator->fails()) {
			$err['en_object'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), 
      [ 'owner_id' => 'required', 
      ],
      [ 'owner_id.required' => __('validation.required_with_owner_id', ['attribute' => __('attributes.owner_id')]),
      ]
    );
		if ($validator->fails()) {
			$err['owner'] = $validator->errors()->all();
		}

		$validator = Validator::make($req->all(), [
			'cond_units' => 'nullable|numeric|max:10000',
		]);
		if ($validator->fails()) {
			$err['cond_units'] = $validator->errors()->all();
		}

    $validator = Validator::make($req->all(), [
			// 'doc_type_id' => 'required',
      // 'has_docs' => 'required_with:doc_type_id',
      'doc_type_id' => 'required_with:has_docs',
      // 'has_docs' => 'required',
		]);
		if ($validator->fails()) {
			$err['has_docs'] = $validator->errors()->all();
		}

    $validator = Validator::make($req->all(), 
      [ 'contract_type_id' => 'required_if:contract_status_type_id,1', ],
      [ // 'contract_type_id.required_if' => __('validation.required_if_contract_type_id', ['attribute' => __('attributes.contract_type_id')]),
        'contract_type_id.required_if' => __('validation.required_if_contract_type_id', ['attribute' => __('Тип договору')]),
      ]

    );
		if ($validator->fails()) {
			$err['contract_type'] = $validator->errors()->all();
		}

    $validator = Validator::make($req->all(), 
      [ 'contract_failure_type_id' => 'required_if:contract_status_type_id,2', ],
      [ 'contract_failure_type_id.required_if' => 
        __('validation.required_if_contract_failure_type_id', ['attribute' => __('Відмова')]), ]
    );
		if ($validator->fails()) {
			$err['contract_failure_type'] = $validator->errors()->all();
		}

    $validator = Validator::make($req->all(), 
      [ 'contract_inexpediency_type_id' => 'required_if:contract_status_type_id,3', ],
      [ 'contract_inexpediency_type_id.required_if' => 
        __('validation.required_if_contract_inexpediency_type_id', ['attribute' => __('Недоцільність заключення договору')]), ]
    );
		if ($validator->fails()) {
			$err['contract_inexpediency_type'] = $validator->errors()->all();
		}

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

	// 	// $validator = Validator::make($req->all(), [
	// 	// 	'row_id' => 'unique:registers,id_type_Register'
	// 	// ]);
	// 	// if ($validator->fails()) {
	// 	// 	$err['delete'] = "Є посилання інших довідників на поточний запис.\nВидалення неможливе.";
	// 	//  	return $err;
	// 	// }

		return $err;
	}

}