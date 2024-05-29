<?php

namespace App\Services\Reports;

// require 'vendor/autoload.php';

use App\Models\DocType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AoDetail2Service {

  public function makeReport() {

		// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
		// // Отримання цифрового індексу за символьним індексом
		// $columnIndex = Coordinate::columnIndexFromString('AB'); // $columnIndex буде 28
		// // Отримання символьного індексу за цифровим індексом
		// $columnLetter = Coordinate::stringFromColumnIndex(28); // $columnLetter буде 'AB'

		$dsRegister = DB::select("
				SELECT r.id, ss.code_so, sr.code_rem, 
				ss.name AS so, sr.name AS rem,
				s.code AS sap_code_substation, s.name AS substation, obts.name AS object_type_substation,
				l.code AS sap_code_line, l.name AS line, obtl.name AS object_type_line, 
				cs.code AS sap_code_connected_substation, cs.name AS connected_substation, 
				cl.code AS sap_code_connected_line, cl.name AS connected_line, 
				o.sap_code AS sap_code_owner, o.name AS owner, o.ab_inn AS code_owner, ot.name AS owner_type,
				ct.name AS contract_type, c.code AS sap_code_contract, 
				c.start_date AS start_date_contract, c.end_date AS end_date_contract, 
				cst.name AS contract_status_type, cft.name AS contract_failure_type -- , cit.name AS contract_inexpediency_type
			FROM registers r
			INNER JOIN sap_sos ss ON r.sap_so_id = ss.id
			INNER JOIN sap_rems sr ON r.sap_rem_id = sr.id
			LEFT JOIN substations s ON r.substation_id = s.id
			LEFT JOIN `lines` l ON r.line_id = l.id
			
			LEFT JOIN object_types obts ON s.object_type_id = obts.id
			LEFT JOIN object_types obtl ON l.object_type_id = obtl.id
			
			LEFT JOIN substations cs ON r.connected_substation_id = cs.id 
			LEFT JOIN `lines` cl ON r.connected_line_id = cl.id 

			LEFT JOIN owners o ON r.owner_id = o.id
			LEFT JOIN owner_types ot ON o.id_type_owner = ot.id
			
			LEFT JOIN contracts c ON r.contract_id = c.id
			LEFT JOIN contract_types ct ON r.contract_type_id = ct.id
			
			LEFT JOIN contract_status_types cst ON r.contract_status_type_id = cst.id
			LEFT JOIN contract_failure_types cft ON r.contract_failure_type_id = cft.id
			-- LEFT JOIN contract_inexpediency_types cit ON r.contract_inexpediency_type_id = cit.id
			
			WHERE NOT r.is_deleted AND ss.active AND sr.active
			ORDER BY ss.code_so, sr.code_rem
		");

		$dsDocument = DB::select("
			SELECT DISTINCT d.register_id, d.doc_type_id FROM documents d
			ORDER BY d.register_id, d.doc_type_id
		");

		$arrDocument = [];
		foreach($dsDocument as $document) {
			$arrDocument[$document->register_id] = $document->doc_type_id;
		}

		$dsDocType = DB::select("
			SELECT dt.id, dt.name FROM doc_types dt
			WHERE NOT dt.is_deleted
		");

		$iNpp = 1;
		$iStartRowIdx = 8;
		$iFinishRow = count($dsRegister) + $iStartRowIdx - 1;
		// $iStartColIdx = 20;
		$iStartColIdx = 20;
		$iFinishColIdx = count($dsDocType) + $iStartColIdx - 1;
		$sFinishCol = Coordinate::stringFromColumnIndex($iFinishColIdx);

		$spreadsheet = new Spreadsheet();
		$activeWorksheet = $spreadsheet->getActiveSheet();
		$activeWorksheet->setTitle('АО (документи)');

		$activeWorksheet->getStyle("A4:{$sFinishCol}7")->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$activeWorksheet->getStyle('A1')
			->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKBLUE);
		$activeWorksheet->getStyle('A1')->getFont()->setSize(16);
		$activeWorksheet->getStyle('A1')->getFont()->setBold(true);
		$activeWorksheet->setCellValue("A1", "Звіт Абонентське обладнання / МСР - Малі Системи Розподілу (документи)");

		$activeWorksheet->mergeCells('A4:A7');

		$activeWorksheet->mergeCells('B4:C4');
		$activeWorksheet->mergeCells('D4:E4');
		$activeWorksheet->mergeCells('B5:B7');
		$activeWorksheet->mergeCells('C5:C7');
		$activeWorksheet->mergeCells('D5:D7');
		$activeWorksheet->mergeCells('E5:E7');
		$activeWorksheet->mergeCells('F4:I4');
		$activeWorksheet->mergeCells('J4:M4');
		$activeWorksheet->mergeCells('N4:P4');
		$activeWorksheet->mergeCells('Q4:S4');
		$activeWorksheet->mergeCells("T4:{$sFinishCol}4");

		$activeWorksheet->mergeCells('F5:F7');
		$activeWorksheet->mergeCells('G5:G7');
		$activeWorksheet->mergeCells('H5:H7');
		$activeWorksheet->mergeCells('I5:I7');
		$activeWorksheet->mergeCells('J5:J7');
		$activeWorksheet->mergeCells('K5:K7');
		$activeWorksheet->mergeCells('L5:L7');
		$activeWorksheet->mergeCells('M5:M7');
		$activeWorksheet->mergeCells('N5:N7');
		$activeWorksheet->mergeCells('O5:O7');
		$activeWorksheet->mergeCells('P5:P7');
		$activeWorksheet->mergeCells('Q5:Q7');
		$activeWorksheet->mergeCells('R5:R7');
		$activeWorksheet->mergeCells('S5:S7');

		for ($i = $iStartColIdx; $i <= $iFinishColIdx; $i++) {
			$col = Coordinate::stringFromColumnIndex($i);
			$activeWorksheet->mergeCells("{$col}5:{$col}7");
		}

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
		$activeWorksheet->setCellValue("M5", "Підключення до");

		$activeWorksheet->setCellValue("N4", "Договір");
		$activeWorksheet->setCellValue("N5", "№ SAP договору");
		$activeWorksheet->setCellValue("O5", "Дата початку");
		$activeWorksheet->setCellValue("P5", "Дата завершення");

		$activeWorksheet->setCellValue("Q4", "Інформація по договору");
		$activeWorksheet->setCellValue("Q5", "Статус");
		$activeWorksheet->setCellValue("R5", "Тип");
		$activeWorksheet->setCellValue("S5", "Відмова");
		// $activeWorksheet->setCellValue("S5", "Недоцільність заключення договору");

		// $activeWorksheet->setCellValue("T4", "Наявність документів");
		$activeWorksheet->setCellValue("T4", "Наявність документів");

		$iCol = $iStartColIdx;
		foreach($dsDocType as $docType) {
			$activeWorksheet->getCell([$iCol++, 5])->setValue($docType->name);
		}

		$activeWorksheet->getStyle("A{$iStartRowIdx}:B{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("D{$iStartRowIdx}:D{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("F{$iStartRowIdx}:F{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("H{$iStartRowIdx}:H{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("I{$iStartRowIdx}:I{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("J{$iStartRowIdx}:J{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("L{$iStartRowIdx}:L{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeWorksheet->getStyle("N{$iStartRowIdx}:{$sFinishCol}{$iFinishRow}")
    	->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
		$activeWorksheet->getColumnDimension('C')->setWidth(20);
		$activeWorksheet->getColumnDimension('E')->setWidth(20);
		$activeWorksheet->getColumnDimension('F')->setWidth(10);
		$activeWorksheet->getColumnDimension('G')->setWidth(36);
		$activeWorksheet->getColumnDimension('H')->setWidth(12);
		$activeWorksheet->getColumnDimension('I')->setWidth(16);
		$activeWorksheet->getColumnDimension('J')->setWidth(16);
		$activeWorksheet->getColumnDimension('K')->setWidth(20);
		$activeWorksheet->getColumnDimension('L')->setWidth(14);
		$activeWorksheet->getColumnDimension('M')->setWidth(30);

		$activeWorksheet->getColumnDimension('N')->setWidth(12);
		$activeWorksheet->getColumnDimension('O')->setWidth(14);
		$activeWorksheet->getColumnDimension('P')->setWidth(14);
		$activeWorksheet->getColumnDimension('Q')->setWidth(30);
		$activeWorksheet->getColumnDimension('R')->setWidth(30);
		$activeWorksheet->getColumnDimension('S')->setWidth(30);
		// $activeWorksheet->getColumnDimension('S')->setWidth(30);

		for ($i = $iStartColIdx; $i <= $iFinishColIdx; $i++) {
			$col = Coordinate::stringFromColumnIndex($i);
			$activeWorksheet->getColumnDimension("{$col}")->setWidth(14);
		}

		$activeWorksheet->getRowDimension(4)->setRowHeight(18);
		$activeWorksheet->getRowDimension(7)->setRowHeight(18);

		// https://phpspreadsheet.readthedocs.io/en/latest/

		// $activeWorksheet->getStyle("A{$iStartRow}:G{$iFinishRow}")
    // 	->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $activeWorksheet->getStyle("A{$iStartRow}:M{$iFinishRow}")
		// 	->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);		
		// $activeWorksheet->getStyle("A{$iStartRow}:M{$iFinishRow}")
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
		$activeWorksheet->getStyle("A4:{$sFinishCol}{$iFinishRow}")
			->applyFromArray($arrRowStyle);
		$activeWorksheet->getStyle("A4:{$sFinishCol}7")
				->applyFromArray($arrHeaderStyle);

		foreach($dsRegister as $register) {

			$iCurrRow = $iNpp + $iStartRowIdx - 1;

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
			}
			else {
				$activeWorksheet->setCellValue("J{$iCurrRow}", $register->sap_code_line);
				$activeWorksheet->setCellValue("K{$iCurrRow}", $register->line);
				$activeWorksheet->setCellValue("L{$iCurrRow}", $register->object_type_line);
			}
			if ($register->sap_code_connected_substation) {
				$activeWorksheet->setCellValue("M{$iCurrRow}", 
					$register->sap_code_connected_substation . "\n" . $register->connected_substation);
			}
			else {
				$activeWorksheet->setCellValue("M{$iCurrRow}", 
					$register->sap_code_connected_line . "\n" . $register->connected_line);
			}

			$activeWorksheet->setCellValue("N{$iCurrRow}", $register->sap_code_contract);
			$activeWorksheet->setCellValue("O{$iCurrRow}", $register->start_date_contract);
			$activeWorksheet->setCellValue("P{$iCurrRow}", $register->end_date_contract);
			$activeWorksheet->setCellValue("Q{$iCurrRow}", 
				$register->contract_status_type === "Невизначено" ? "" : $register->contract_status_type);
			$activeWorksheet->setCellValue("R{$iCurrRow}", $register->contract_type);
			$activeWorksheet->setCellValue("S{$iCurrRow}", $register->contract_failure_type);
			// $activeWorksheet->setCellValue("S{$iCurrRow}", $register->contract_inexpediency_type);

			$arrDocs = array_filter($dsDocument, fn($v, $k) => $v->register_id === $register->id, ARRAY_FILTER_USE_BOTH);

			foreach ($arrDocs as $doc) {
				$arrDocType = array_filter($dsDocType, fn($v, $k) => $v->id === $doc->doc_type_id, ARRAY_FILTER_USE_BOTH);
				$arrDocTypeIndexes = array_keys($arrDocType);
				if (count($arrDocTypeIndexes) > 0) {
					// Log::error([$arrDocTypeIndexes, $iStartColIdx + $arrDocTypeIndexes[0], $iCurrRow]);
					$activeWorksheet->getCell([$iStartColIdx + $arrDocTypeIndexes[0], $iCurrRow])->setValue("+");
				}
			}

			$iNpp++;
		}

		$randName = uniqid(/*'temp_',*/ true) . ".xlsx";

		$writer = new Xlsx($spreadsheet);
		$writer->save(storage_path("app/public/{$randName}"));

		return $randName;
	}

}