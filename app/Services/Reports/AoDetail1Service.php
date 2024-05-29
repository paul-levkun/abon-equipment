<?php

namespace App\Services\Reports;

// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AoDetail1Service {

  public function makeReport() {
		$dsRegister = DB::select("
			SELECT ss.code_so, sr.code_rem, 
				ss.name AS so, sr.name AS rem,
				s.code AS sap_code_substation, s.name AS substation, obts.name AS object_type_substation,
				s.trans_number AS trans_number_substation, s.total_power AS total_power_substation,
				l.code AS sap_code_line, l.name AS line, obtl.name AS object_type_line, l.line_length_route,
				cs.code AS sap_code_connected_substation, cs.name AS connected_substation, 
				cl.code AS sap_code_connected_line, cl.name AS connected_line, 
				lt.name AS location, lst.name AS line_section, tst.name AS tech_state, r.cond_units,
				o.sap_code AS sap_code_owner, o.name AS owner, o.ab_inn AS code_owner, ot.name AS owner_type,
				ct.name AS contract_type, c.code AS sap_code_contract, -- c.status AS status_contract, 
				c.start_date AS start_date_contract, c.end_date AS end_date_contract, 
				c.contract_amount AS contract_amount_contract, c.payment_amount AS payment_amount_contract, 
				c.sales_amount AS sales_amount_contract, cit.name AS contract_inexpediency_type
				-- r.* 
			FROM registers r
			INNER JOIN sap_sos ss ON r.sap_so_id = ss.id
			INNER JOIN sap_rems sr ON r.sap_rem_id = sr.id
			LEFT JOIN substations s ON r.substation_id = s.id
			LEFT JOIN `lines` l ON r.line_id = l.id
			
			LEFT JOIN object_types obts ON s.object_type_id = obts.id
			LEFT JOIN object_types obtl ON l.object_type_id = obtl.id

			LEFT JOIN substations cs ON r.connected_substation_id = cs.id 
			LEFT JOIN `lines` cl ON r.connected_line_id = cl.id 

			LEFT JOIN location_types lt ON r.location_type_id = lt.id
			LEFT JOIN line_section_types lst ON r.line_section_type_id = lst.id
			LEFT JOIN tech_state_types tst ON r.tech_state_type_id = tst.id
			
			LEFT JOIN owners o ON r.owner_id = o.id
			LEFT JOIN owner_types ot ON o.id_type_owner = ot.id
			
			LEFT JOIN contracts c ON r.contract_id = c.id
			LEFT JOIN contract_types ct ON r.contract_type_id = ct.id

			LEFT JOIN contract_inexpediency_types cit ON r.contract_inexpediency_type_id = cit.id
			
			WHERE NOT r.is_deleted AND ss.active AND sr.active
			ORDER BY ss.code_so, sr.code_rem
		");

		$spreadsheet = new Spreadsheet();
		$activeWorksheet = $spreadsheet->getActiveSheet();
		$activeWorksheet->setTitle('АО (детально)');

		$spreadsheet->getActiveSheet()->getStyle("A4:BA7")->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('A1')
			->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$activeWorksheet->setCellValue("A1", "Звіт Абонентське обладнання / МСР - Малі Системи Розподілу (детально)");


		$spreadsheet->getActiveSheet()->mergeCells('A4:A7');

		$spreadsheet->getActiveSheet()->mergeCells('B4:C4');
		$spreadsheet->getActiveSheet()->mergeCells('D4:E4');
		$spreadsheet->getActiveSheet()->mergeCells('B5:B7');
		$spreadsheet->getActiveSheet()->mergeCells('C5:C7');
		$spreadsheet->getActiveSheet()->mergeCells('D5:D7');
		$spreadsheet->getActiveSheet()->mergeCells('E5:E7');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J4:T4');
		$spreadsheet->getActiveSheet()->mergeCells('U4:AA4');

		$spreadsheet->getActiveSheet()->mergeCells('F5:F7');
		$spreadsheet->getActiveSheet()->mergeCells('G5:G7');
		$spreadsheet->getActiveSheet()->mergeCells('H5:H7');
		$spreadsheet->getActiveSheet()->mergeCells('I5:I7');
		$spreadsheet->getActiveSheet()->mergeCells('J5:J7');
		$spreadsheet->getActiveSheet()->mergeCells('K5:K7');
		$spreadsheet->getActiveSheet()->mergeCells('L5:L7');
		$spreadsheet->getActiveSheet()->mergeCells('M5:M7');
		$spreadsheet->getActiveSheet()->mergeCells('N5:N7');
		$spreadsheet->getActiveSheet()->mergeCells('O5:O7');
		$spreadsheet->getActiveSheet()->mergeCells('P5:P7');
		$spreadsheet->getActiveSheet()->mergeCells('Q5:Q7');
		$spreadsheet->getActiveSheet()->mergeCells('R5:R7');
		$spreadsheet->getActiveSheet()->mergeCells('S5:S7');
		$spreadsheet->getActiveSheet()->mergeCells('T5:T7');

		$spreadsheet->getActiveSheet()->mergeCells('U5:U7');
		$spreadsheet->getActiveSheet()->mergeCells('V5:V7');
		$spreadsheet->getActiveSheet()->mergeCells('W5:W7');
		$spreadsheet->getActiveSheet()->mergeCells('X5:X7');
		$spreadsheet->getActiveSheet()->mergeCells('Y5:Y7');
		$spreadsheet->getActiveSheet()->mergeCells('Z5:Z7');
		$spreadsheet->getActiveSheet()->mergeCells('AA5:AA7');

		$activeWorksheet->setCellValue("A4", "№ з/п");
		$activeWorksheet->setCellValue("B4", "СО");
		$activeWorksheet->setCellValue("D4", "Дільниця");
		$activeWorksheet->setCellValue("B5", "Код");
		$activeWorksheet->setCellValue("C5", "Назва");
		$activeWorksheet->setCellValue("D5", "Код");
		$activeWorksheet->setCellValue("E5", "Назва");
		$activeWorksheet->setCellValue("F4", "Власник");
		$activeWorksheet->setCellValue("F5", "Дебітор");
		$activeWorksheet->setCellValue("G5", "Назва");
		$activeWorksheet->setCellValue("H5", "ЄДРПОУ / ІПН");
		$activeWorksheet->setCellValue("I5", "Тип");

		$activeWorksheet->setCellValue("J4", "Обладнання");
		$activeWorksheet->setCellValue("J5", "Функціональне розташування");
		$activeWorksheet->setCellValue("K5", "Назва");
		$activeWorksheet->setCellValue("L5", "Тип");
		$activeWorksheet->setCellValue("M5", "Кільк. транс.");
		$activeWorksheet->setCellValue("N5", "Номінал. потужн. ТП, кВА");
		// $activeWorksheet->setCellValue("O5", "Довжина по трасі, км");
		$activeWorksheet->setCellValue("O5", "Підключення до");
		$activeWorksheet->setCellValue("P5", "Розміщення");
		$activeWorksheet->setCellValue("Q5", "Тип ділянки");
		$activeWorksheet->setCellValue("R5", "Технічний стан");
		$activeWorksheet->setCellValue("S5", "Умовні одиниці");
		$activeWorksheet->setCellValue("T5", "Недоцільність заключення договору");

		$activeWorksheet->setCellValue("U4", "Договір");
		$activeWorksheet->setCellValue("U5", "Тип");
		$activeWorksheet->setCellValue("V5", "№ SAP договору");
		$activeWorksheet->setCellValue("W5", "Дата початку");
		$activeWorksheet->setCellValue("X5", "Дата завершення");
		$activeWorksheet->setCellValue("Y5", "Сума договору, грн");
		$activeWorksheet->setCellValue("Z5", "Сума оплат, грн");
		$activeWorksheet->setCellValue("AA5", "Сума реалізації, грн");

		$iBaseIdx = 7;
		$iNpp = 1;
		$iStartRow = $iBaseIdx + 1;
		$iFinishRow = count($dsRegister) + $iBaseIdx;

		$spreadsheet->getActiveSheet()->getStyle("A{$iStartRow}:B{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("D{$iStartRow}:D{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("F{$iStartRow}:F{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("H{$iStartRow}:H{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("I{$iStartRow}:I{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("J{$iStartRow}:J{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("L{$iStartRow}:L{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("P{$iStartRow}:R{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("U{$iStartRow}:X{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(36);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(16);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(14);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(30);

		// $spreadsheet->getActiveSheet()->getColumnDimension('O')->setVisible(false);

		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(16);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(14);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(16);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(30);

		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(22);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(14);
		$spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(14);
		$spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(12);

		$spreadsheet->getActiveSheet()->getRowDimension(4)->setRowHeight(18);
		$spreadsheet->getActiveSheet()->getRowDimension(7)->setRowHeight(18);

		// https://phpspreadsheet.readthedocs.io/en/latest/

		// $spreadsheet->getActiveSheet()->getStyle("A{$iStartRow}:G{$iFinishRow}")
    // 	->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $spreadsheet->getActiveSheet()->getStyle("A{$iStartRow}:M{$iFinishRow}")
		// 	->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);		
		// $spreadsheet->getActiveSheet()->getStyle("A{$iStartRow}:M{$iFinishRow}")
		// 	->getAlignment()->setWrapText(true);

		$arrRowStyle = [
			'borders' => [
				// 'outline' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '007F7F7F'],
				],
			],
			'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
				'wrapText' => true,
    	],
		];
		$arrHeaderStyle = [
			'font' => [
        'bold' => true,
    	],
			'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    	],
		];
		$spreadsheet->getActiveSheet()->getStyle("A4:AA{$iFinishRow}")
			->applyFromArray($arrRowStyle);
		$spreadsheet->getActiveSheet()->getStyle("A4:AA7")
				->applyFromArray($arrHeaderStyle);

		foreach($dsRegister as $register) {

			$iCurrRow = $iNpp + $iBaseIdx;

			$activeWorksheet->setCellValue("A{$iCurrRow}", $iNpp);
			$activeWorksheet->setCellValue("B{$iCurrRow}", $register->code_so);
			$activeWorksheet->setCellValue("C{$iCurrRow}", $register->so);
			$activeWorksheet->setCellValue("D{$iCurrRow}", $register->code_rem);
			$activeWorksheet->setCellValue("E{$iCurrRow}", $register->rem);
			$activeWorksheet->setCellValue("F{$iCurrRow}", $register->sap_code_owner);
			$activeWorksheet->setCellValue("G{$iCurrRow}", $register->owner);
			$activeWorksheet->setCellValue("H{$iCurrRow}", $register->code_owner);
			$activeWorksheet->setCellValue("I{$iCurrRow}", $register->owner_type);
			if ($register->sap_code_substation) {
				$activeWorksheet->setCellValue("J{$iCurrRow}", $register->sap_code_substation);
				$activeWorksheet->setCellValue("K{$iCurrRow}", $register->substation);
				$activeWorksheet->setCellValue("L{$iCurrRow}", $register->object_type_substation);
				$activeWorksheet->setCellValue("M{$iCurrRow}", $register->trans_number_substation);
				$activeWorksheet->setCellValue("N{$iCurrRow}", $register->total_power_substation);
			}
			else {
				$activeWorksheet->setCellValue("J{$iCurrRow}", $register->sap_code_line);
				$activeWorksheet->setCellValue("K{$iCurrRow}", $register->line);
				$activeWorksheet->setCellValue("L{$iCurrRow}", $register->object_type_line);
				// $activeWorksheet->setCellValue("O{$iCurrRow}", $register->line_length_route);
			}
			if ($register->sap_code_connected_substation) {
				$activeWorksheet->setCellValue("O{$iCurrRow}", 
					$register->sap_code_connected_substation . "\n" . $register->connected_substation);
			}
			else {
				$activeWorksheet->setCellValue("O{$iCurrRow}", 
					$register->sap_code_connected_line . "\n" . $register->connected_line);
			}

			$activeWorksheet->setCellValue("P{$iCurrRow}", $register->location);
			$activeWorksheet->setCellValue("Q{$iCurrRow}", $register->line_section);
			$activeWorksheet->setCellValue("R{$iCurrRow}", $register->tech_state);
			$activeWorksheet->setCellValue("S{$iCurrRow}", $register->cond_units);
			$activeWorksheet->setCellValue("T{$iCurrRow}", 
				$register->contract_inexpediency_type === "Невизначено" ? "" : $register->contract_inexpediency_type);

			$activeWorksheet->setCellValue("U{$iCurrRow}", $register->contract_type);
			$activeWorksheet->setCellValue("V{$iCurrRow}", $register->sap_code_contract);
			$activeWorksheet->setCellValue("W{$iCurrRow}", $register->start_date_contract);
			$activeWorksheet->setCellValue("X{$iCurrRow}", $register->end_date_contract);
			$activeWorksheet->setCellValue("Y{$iCurrRow}", $register->contract_amount_contract);
			$activeWorksheet->setCellValue("Z{$iCurrRow}", $register->payment_amount_contract);
			$activeWorksheet->setCellValue("AA{$iCurrRow}", $register->sales_amount_contract);

			$iNpp++;
		}

		// $activeWorksheet->setCellValue("A1", $iFinishRow);

		$randName = uniqid(/*'temp_',*/ true) . ".xlsx";

		$writer = new Xlsx($spreadsheet);
		$writer->save(storage_path("app/public/{$randName}"));

		return $randName;
	}

}