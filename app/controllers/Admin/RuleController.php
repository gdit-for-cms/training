<?php

namespace App\Controllers\Admin;

use App\Models\Image;
use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\models\Rule;
use App\Models\TypeRule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RuleController extends AppController
{
    use ResponseTrait;

    public $title = 'Rules';
    public object $obj_rule;
    public object $obj_type_rule;
    public object $obj_image;
    public array $data_ary;

    public function __construct()
    {
        $this->obj_rule = new Rule;
        $this->obj_type_rule = new TypeRule;
        $this->obj_image = new Image;
    }

    public function indexAction(Request $request)
    {
        if (isset($_POST['btn-import'])) {
            $this->import($request);
            header('Location:/admin/rule/index');
            exit;
        }
        $types_rule = $this->obj_type_rule->getAll();
        $this->data_ary['types_rule'] = $types_rule;
        $this->data_ary['content'] = "rule/index";
    }

    public function createAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $type_rule = $this->obj_type_rule->getById($type_rule_id);
        $all_categories = $this->obj_rule->getAllCategories($type_rule_id);
        $this->data_ary['all_categories'] = $all_categories;
        $this->data_ary['type_rule'] = $type_rule;
        $this->data_ary['content'] = "rule/create";
    }
    public function editAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $rule_edit = $this->obj_rule->getById($rule_id);
        $type_rule = $this->obj_type_rule->getById($rule_edit['type_rule_id']);
        $all_categories = $this->obj_rule->getAllCategories($rule_edit['type_rule_id']);
        $getImageResults = $this->obj_image->getAllRelation([], 5);
        $this->data_ary['library_images'] = $getImageResults['images'];
        $this->data_ary['numberAllImage'] = $getImageResults['numbers_of_result'];
        $this->data_ary['all_categories'] = $all_categories;
        $this->data_ary['type_rule'] = $type_rule;
        $this->data_ary['rule_edit'] = $rule_edit;
        $this->data_ary['content'] = "rule/edit";
    }

    public function storeAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $data_ary = $request->getPost()->all();
        $data_ary['type_rule_id'] = $type_rule_id;
        try {
            if ($this->obj_rule->create($data_ary)) {
                header("Location: /admin/rule/rulesDetail?type_rule_id=" . $type_rule_id . '&page=1&results_per_pages=5');
            } else {
                header('Location: /admin/rule/create?type_rule_id=' . $type_rule_id);
            }
        } catch (\Throwable $th) {
            $this->createMessage('danger', 'Creation failed! Please try again!');
        }
    }
    public function updateAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $data_ary = $request->getPost()->all();
        try {
            if ($this->obj_rule->updateOne($data_ary, "id ='$rule_id'")) {
                header("Location: /admin/rule/rulesDetail?type_rule_id=" . $type_rule_id . '&page=1&results_per_pages=5');
            } else {
                header('Location: /admin/rule/edit?id=' . $rule_id);
            }
        } catch (\Throwable $th) {
            $this->createMessage('danger', 'Update failed! Please try again!');
        }
    }
    public function updateListAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('id');
        $file_mimes = $this->getFileMimes();
        if (isset($_FILES['file_upload']['name']) && in_array($_FILES['file_upload']['type'], $file_mimes)) {
            try {
                $sheet_data_ary = $this->fileToArray($_FILES['file_upload']['tmp_name']);
                if (!empty($sheet_data_ary)) {
                    try {
                        unset($sheet_data_ary[1]);
                        $this->obj_rule->destroyBy("type_rule_id='$type_rule_id'");
                        $this->insertData($sheet_data_ary, $type_rule_id);
                    } catch (\Throwable $th) {
                        $this->createMessage('danger', 'Update failed!');
                    };
                }
            } catch (\Throwable $th) {
                $this->createMessage('danger', 'Please check file again! Choose the correct file format (xlsx, xls, csv)!');
            }
        } else {
            $this->createMessage('danger', 'Please choose the correct file format (xlsx, xls, csv)!');
        }
        header('Location:/admin/rule/index');
        exit;
    }

    public function rulesDetailAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $type_rule =  $this->obj_type_rule->getById($type_rule_id);
        $all_categories = $this->obj_rule->getAllCategories($type_rule_id);

        $get_results_per_page =  $request->getGet()->get('results_per_pages');
        $results_per_page =  $get_results_per_page ? $get_results_per_page : '5';
        $options_select_ary = [5, 10, 15];
        $get_ary = $request->getGet()->all();
        array_shift($get_ary);
        $results_ary = $this->obj_rule->getAllRelation($get_ary, $results_per_page);

        $numbers_of_result = $results_ary['numbers_of_result'];
        $numbers_of_pages = ceil($numbers_of_result / $results_per_page);
        $current_page = (int) $request->getGet()->get('page');
        $previous_order = ($current_page - 1) * $results_per_page;
        $max_pagination_item = 4;


        $this->data_ary['previous_order'] = $previous_order;
        $this->data_ary['current_page'] = $current_page;
        $this->data_ary['results_per_page'] = $results_per_page;
        $this->data_ary['numbers_of_pages'] = $numbers_of_pages;
        $this->data_ary['numbers_of_result'] = $numbers_of_result;
        $this->data_ary['options_select_ary'] = $options_select_ary;
        $this->data_ary['max_pagination_item'] = $max_pagination_item;
        $this->data_ary['rules_in_one_page_ary'] = $results_ary['results'];
        $this->data_ary['all_categories'] = $all_categories;
        $this->data_ary['type_rule_name'] = $type_rule['name'];
        $this->data_ary['type_rule_id'] = $type_rule_id;
        $this->data_ary['content'] = "rule/detail";
    }

    public function deleteListAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('id');
        $this->obj_type_rule->destroyOne("id = $type_rule_id");
    }

    public function deleteAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $this->obj_rule->destroyBy("id = $rule_id");
    }

    public function showAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $rule = $this->obj_rule->getById($rule_id);
        if ($rule) {
            return $this->responseShowRule(true, $rule);
        } else {
            return $this->responseShowRule(false);
        }
    }

    public function import(Request $request)
    {
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $file_mimes = $this->getFileMimes();
        if (isset($_FILES['file_upload']['name']) && in_array($_FILES['file_upload']['type'], $file_mimes)) {
            try {
                $sheet_data_ary = $this->fileToArray($_FILES['file_upload']['tmp_name']);
                if (!empty($sheet_data_ary)) {
                    try {
                        unset($sheet_data_ary[1]);
                        if (count($this->obj_type_rule->getBy('name', '=', $type_rule_name, '*')) != 0) {
                            $this->createMessage('danger', 'Rule list name already exits. Please enter another name!');
                            header('Location:/admin/rule/index');
                            exit;
                        }
                        $this->obj_type_rule->create(['name' => $type_rule_name]);
                        $type_rule = $this->obj_type_rule->getBy('name', '=', $type_rule_name, '*');
                        $this->insertData($sheet_data_ary, $type_rule[0]['id']);
                    } catch (\Throwable $th) {
                        $this->createMessage('danger', 'Import failed!');
                    };
                }
            } catch (\Throwable $th) {
                $this->createMessage('danger', 'Please check file again! Choose the correct file format (xlsx, xls, csv)!');
            }
        } else {
            $this->createMessage('danger', 'Please choose the correct file format (xlsx, xls, csv)!');
        }
    }
    public function exportAction(Request $request)
    {
        $type_rule_id = $request->getPost()->get('type_rule_id');
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $rules_by_type_ary = $this->obj_rule->getBy('type_rule_id', '=', $type_rule_id, '*');
        $spreadsheet = $this->arrayToSheet($rules_by_type_ary);
        $writer =  new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_name = str_replace(' ', '_', $type_rule_name) . date('_Y_m_d_') . time() . ".xlsx";
        $writer->save($file_name);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="' . urlencode($file_name) . '"');
        readfile($file_name);
        exit;
    }
    public function createMessage($type, $message)
    {
        $_SESSION['msg']  = [
            'type' => "$type",
            'message' => "$message"
        ];
    }
    public function unmergeCellsHandle($spreadsheet)
    {
        $mergedCells = $spreadsheet->getMergeCells();
        foreach ($mergedCells as $mergedCell) {
            $cells = explode(':', $mergedCell);
            $startCell = $cells[0];
            $endCell = $cells[1];

            $mergedCellValue = $spreadsheet->getCell($startCell)->getValue();
            $startCell_number = ltrim($startCell, $startCell[0]);
            $endCell_number = ltrim($endCell, $endCell[0]);

            for ($row = $startCell_number; $row <= $endCell_number; $row++) {
                for ($col = $startCell[0]; $col <= $endCell[0]; $col++) {
                    $currentCell = $col . $row;
                    $spreadsheet->getCell($currentCell)->setValue($mergedCellValue);
                }
            }
            $spreadsheet->unmergeCells($mergedCell);
        }
        return  $spreadsheet;
    }
    public function createReader($inputFileType)
    {
        $reader = new Xlsx();
        if ('xlsx' == lcfirst($inputFileType)) {
            $reader = new Xlsx();
        } else if ('xls' == lcfirst($inputFileType)) {
            $reader = new Xls();
        } else if ('csv' == lcfirst($inputFileType)) {
            $reader = new Csv();
        }
        return $reader;
    }
    public function sheetToArray($spreadsheet)
    {
        $sheet_data_ary = $spreadsheet->toArray(null, true, true, true);
        $sheet_data_ary = array_filter($sheet_data_ary, function ($row) {
            return !empty(array_filter($row));
        });
        return $sheet_data_ary;
    }
    public function insertData($sheet_data_ary, $type_rule_id)
    {
        foreach ($sheet_data_ary as $row) {
            if (!(empty($row['B']) && empty($row['C']) && empty($row['D']) && empty($row['E']))) {
                $large_category = $row['B'] ? $row['B'] : "";
                $middle_category = $row['C'] ? $row['C'] : "";
                $small_category = $row['D'] ? $row['D'] : "";
                $content = $row['E'] ? $row['E'] : "";
                $detail = $row['F'] ? $row['F'] : "";
                $note = $row['G'] ? $row['G'] : "";
                $result = $this->obj_rule->create(
                    [
                        'type_rule_id' => $type_rule_id,
                        'large_category' => $large_category,
                        'middle_category' => $middle_category,
                        'small_category' => $small_category,
                        'content' => $content,
                        'detail' => $detail,
                        'note' => $note,
                    ]
                );
                if ($result) {
                    $this->createMessage('success', 'Updated success!');
                } else {
                    $this->createMessage('danger', 'Updated failed!');
                }
            }
        }
    }
    public function fileToArray($file)
    {
        $inputFileType = IOFactory::identify($file);
        $reader = $this->createReader($inputFileType);
        $spreadsheet = $reader->load($file);
        $spreadsheet =  $spreadsheet->getActiveSheet();
        $spreadsheet = $this->unmergeCellsHandle($spreadsheet);
        $sheet_data_ary = $this->sheetToArray($spreadsheet);
        return $sheet_data_ary;
    }
    public function getFileMimes()
    {
        return array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
    public function setHeaderValue($sheet)
    {
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Large category');
        $sheet->setCellValue('C1', 'Middle category');
        $sheet->setCellValue('D1', 'Small category');
        $sheet->setCellValue('E1', 'Content');
        $sheet->setCellValue('F1', 'Detail');
        $sheet->setCellValue('G1', 'Note');
        return $sheet;
    }
    public function getStyles()
    {
        $styles_header_ary = [
            'borders'   => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'C0C0C0']
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Times New Roman'
            ], 'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $styles_body_ary = [
            'borders'   => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ], 'font' => [
                'size' => 10,
                'name' => 'Times New Roman'
            ]
        ];
        return $styles = [
            'styles_header_ary' => $styles_header_ary,
            'styles_body_ary' => $styles_body_ary,
        ];
    }
    public function arrayToSheet($rules_ary)
    {
        $spread_sheet = new Spreadsheet();
        $sheet = $spread_sheet->getActiveSheet();
        $sheet = $this->setHeaderValue($sheet);
        $first_row_to_read = 2;
        $row_number_large = $first_row_to_read;
        $row_number_middle = $first_row_to_read;
        $row_number_small = $first_row_to_read;

        $start_row_large = -1;
        $start_row_middle = -1;
        $start_row_small = -1;

        $previous_large = '';
        $previous_middle = '';
        $previous_small = '';

        foreach ($rules_ary as $index => $row) {
            if ($start_row_large == -1) {
                $start_row_large = $row_number_large;
                $previous_large = $row['large_category'];
            }
            if ($start_row_middle == -1) {
                $start_row_middle = $row_number_middle;
                $previous_middle = $row['middle_category'];
            }
            if ($start_row_small == -1) {
                $start_row_small = $row_number_small;
                $previous_small = $row['small_category'];
            }
            $sheet->setCellValue('A' . $index + 2, $index + 1);
            $sheet->setCellValue('B' . $index + 2, $row['large_category']);
            $sheet->setCellValue('C' . $index + 2, $row['middle_category']);
            $sheet->setCellValue('D' . $index + 2, $row['small_category']);
            $sheet->setCellValue('E' . $index + 2, $row['content']);
            $sheet->setCellValue('F' . $index + 2, $row['detail']);
            $sheet->setCellValue('G' . $index + 2, $row['note']);
            $next_large = isset($rules_ary[$index + 1]) ? $rules_ary[$index + 1]['large_category'] : null;
            $next_middle = isset($rules_ary[$index + 1]) ? $rules_ary[$index + 1]['middle_category'] : null;
            $next_small = isset($rules_ary[$index + 1]) ? $rules_ary[$index + 1]['small_category'] : null;

            if ($row_number_large >= $start_row_large && (($previous_large <> $next_large) || ($next_large == null))) {
                $cellToMerge = 'B' . $start_row_large . ':B' . $row_number_large;
                $sheet->mergeCells($cellToMerge);
                $start_row_large = -1;
            }
            if ($row_number_middle >= $start_row_middle && (($previous_middle <> $next_middle) || ($next_middle == null))) {
                $cellToMerge = 'C' . $start_row_middle . ':C' . $row_number_middle;
                $sheet->mergeCells($cellToMerge);
                $start_row_middle = -1;
            }
            if ($row_number_small >= $start_row_small && (($previous_small <> $next_small) || ($next_small == null))) {
                $cellToMerge = 'D' . $start_row_small . ':D' . $row_number_small;
                $sheet->mergeCells($cellToMerge);
                $start_row_small = -1;
            }
            $row_number_large++;
            $row_number_middle++;
            $row_number_small++;
        }
        $row_count = count($rules_ary) + 1;
        $spread_sheet->getActiveSheet()->getStyle("A1:G1")->applyFromArray($this->getStyles()['styles_header_ary']);
        $spread_sheet->getActiveSheet()->getStyle("A2:G$row_count")->applyFromArray($this->getStyles()['styles_body_ary']);
        $spread_sheet->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        foreach (range('A', 'G') as $column) {
            switch ($column) {
                case 'B':
                case 'C':
                case 'D':
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(10);
                    break;
                case 'E':
                case 'F':
                case 'G':
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(40);
                    break;
                default:
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(5);
                    break;
            }
        }

        return $spread_sheet;
    }

    public function responseShowRule($status, $result = [])
    {
        $res = [
            "success" => $status,
            "result" => $result
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }
}
