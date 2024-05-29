<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\UserService;

class DashboardController extends Controller
{
  public function show(Request $req): View {
		$so_id = Auth::user()->so_id;
		$rem_id = Auth::user()->rem_id;
		$bo_id = Auth::user()->bo_id;

		$so_code = $so_name = $rem_code = $rem_name = $bo_code = $bo_name = "";
		if (($so_id && $so_id !== -1 || $bo_id && $bo_id !== -1 )) {
			$req["row_id"] = Auth::user()->id;
			$dsUser = (new UserService())->dispatch($req, 'show');
			$arrUser = json_decode($dsUser)[0];
			// dd($arrUser);
			if ($so_id > 0) {
				$so_code = $arrUser->sap_sos->code_so;
				$so_name = $arrUser->sap_sos->name;

				if ($rem_id > 0) {
					$rem_code = $arrUser->sap_rems->code_rem;
					$rem_name = $arrUser->sap_rems->name;
				}
			}
			if ($bo_id > 0) {
				$bo_code = $arrUser->sap_bos->code_bo;
				$bo_name = $arrUser->sap_bos->name;
			}
		}

		return view('dashboard', [
			'so_id' => $so_id, 
			'rem_id' => $rem_id,
			'bo_id' => $bo_id,
			'so_code' => $so_code, 
			'rem_code' => $rem_code,
			'bo_code' => $bo_code,
			'so_name' => $so_name, 
			'rem_name' => $rem_name,
			'bo_name' => $bo_name,
			'user_name' => Auth::user()->name,
		]);
		// return view('dashboard', [
		// 	'so_id' => 37, 
		// 	'rem_id' => 78,
		// 	'bo_id' => 115,
		// 	'so_code' => "V33M", 
		// 	'rem_code' => "V33M01",
		// 	'bo_code' => "VN34",
		// 	'so_name' => "Вінницькі центральні ЕМ", 
		// 	'rem_name' => "Замостянська дільниця",
		// 	'bo_name' => "СО \"Вінницькі східні ЕМ\"",
		// 	'user_name' => Auth::user()->name,
		// ]);
  }
}
