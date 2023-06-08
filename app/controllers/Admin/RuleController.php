<?php

namespace App\Controllers\Admin;

use Core\Http\Request;
use Core\Http\ResponseTrait;
use App\models\Rule;
use App\Models\TypeRule;
use  PhpOffice\PhpSpreadsheet\Spreadsheet;
use  PhpOffice\PhpSpreadsheet\Reader\Xls;
use  PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RuleController extends AppController
{
    use ResponseTrait;

    public $title = 'Rules';

    public object $obj_rule_model;
    public object $obj_type_rule_model;

    public array $data_ary;

    public function __construct()
    {
        $this->obj_rule_model = new Rule;
        $this->obj_type_rule_model = new TypeRule;
    }

    public function indexAction(Request $request)
    {

        if (isset($_POST['btn-import'])) {
            $this->import($request);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
        $types_rule = $this->obj_type_rule_model->getAll();
        $this->data_ary['types_rule'] = $types_rule;
        $this->data_ary['content'] = "rule/index";
    }

    public function createAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $type_rule = $this->obj_type_rule_model->getById($type_rule_id);
        $this->data_ary['type_rule'] = $type_rule;
        $this->data_ary['content'] = "rule/create";
    }
    public function editAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $rule_edit = $this->obj_rule_model->getById($rule_id);
        $type_rule = $this->obj_type_rule_model->getById($rule_edit['type_rule_id']);

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
            if ($this->obj_rule_model->create($data_ary)) {
                header("Location: /admin/rule/rulesDetail?type_rule_id=" . $type_rule_id . '&page=1');
            } else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } catch (\Throwable $th) {
            $_SESSION['msg']  = [
                'type' => "danger",
                'message' => "Creation failed! Please try again!"
            ];
        }
    }
    public function updateAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $data_ary = $request->getPost()->all();

        try {
            if ($this->obj_rule_model->updateOne($data_ary, "id ='$rule_id'")) {
                header("Location: /admin/rule/rulesDetail?type_rule_id=" . $type_rule_id . '&page=1');
            } else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } catch (\Throwable $th) {
            $_SESSION['msg']  = [
                'type' => "danger",
                'message' => "Update failed! Please try again!"
            ];
        }
    }

    public function rulesDetailAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('type_rule_id');
        $type_rule =  $this->obj_type_rule_model->getById($type_rule_id);
        $rules_by_type_ary = $this->obj_rule_model->getBy('type_rule_id', '=', $type_rule_id, '*');
        $all_categories = $this->obj_rule_model->getAllCategories($type_rule_id);

        $get_ary = $request->getGet()->all();
        $results_per_page = 5;
        array_shift($get_ary);
        $results_ary = $this->obj_rule_model->getAllRelation($get_ary, $results_per_page);

        $numbers_of_result = $results_ary['numbers_of_result'];
        $numbers_of_pages = ceil($numbers_of_result / $results_per_page);

        $current_page = (int) $request->getGet()->get('page');
        $previous_order = ($current_page - 1) * $results_per_page;
        $max_pagination_item = 3;

        $this->data_ary['previous_order'] = $previous_order;
        $this->data_ary['current_page'] = $current_page;
        $this->data_ary['numbers_of_pages'] = $numbers_of_pages;
        $this->data_ary['max_pagination_item'] = $max_pagination_item;
        $this->data_ary['rules_in_one_page_ary'] = $results_ary['results'];
        $this->data_ary['all_categories'] = $all_categories;
        $this->data_ary['rules_by_type_ary'] = $rules_by_type_ary;
        $this->data_ary['type_rule_name'] = $type_rule['name'];
        $this->data_ary['type_rule_id'] = $type_rule_id;
        $this->data_ary['content'] = "rule/detail";
    }

    public function deleteListAction(Request $request)
    {
        $type_rule_id = $request->getGet()->get('id');
        $this->obj_type_rule_model->destroyOne("id = $type_rule_id");
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    public function deleteAction(Request $request)
    {
        $rule_id = $request->getGet()->get('id');
        $this->obj_rule_model->destroyOne("id = $rule_id");
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }


    public function import(Request $request)
    {
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['file_upload']['name']) && in_array($_FILES['file_upload']['type'], $file_mimes)) {
            try {
                $inputFileType = IOFactory::identify($_FILES['file_upload']['tmp_name']);
                if ('xlsx' == lcfirst($inputFileType)) {
                    $reader = new Xlsx();
                } else if ('xls' == lcfirst($inputFileType)) {
                    $reader = new Xls();
                } else if ('csv' == lcfirst($inputFileType)) {
                    $reader = new Csv();
                }

                $spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
                $spreadsheet =  $spreadsheet->getActiveSheet();
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

                $sheetData_ary = $spreadsheet->toArray(null, true, true, true);
                $sheetData_ary = array_filter($sheetData_ary, function ($row) {
                    return !empty(array_filter($row));
                });

                if (!empty($sheetData_ary)) {
                    try {
                        unset($sheetData_ary[1]);
                        if (count($this->obj_type_rule_model->getBy('name', '=', $type_rule_name, '*')) == 0) {
                            $this->obj_type_rule_model->create(['name' => $type_rule_name]);
                            $type_rule = $this->obj_type_rule_model->getBy('name', '=', $type_rule_name, '*');

                            foreach ($sheetData_ary as $row) {
                                if (!(empty($row['B']) && empty($row['C']) && empty($row['D']) && empty($row['E']))) {
                                    $large_category = $row['B'] ? $row['B'] : "";
                                    $middle_category = $row['C'] ? $row['C'] : "";
                                    $small_category = $row['D'] ? $row['D'] : "";
                                    $content = $row['E'] ? $row['E'] : "";
                                    $detail = $row['F'] ? $row['F'] : "";
                                    $note = $row['G'] ? $row['G'] : "";
                                    $result = $this->obj_rule_model->create(
                                        [
                                            'type_rule_id' => $type_rule[0]['id'],
                                            'large_category' => $large_category,
                                            'middle_category' => $middle_category,
                                            'small_category' => $small_category,
                                            'content' => $content,
                                            'detail' => $detail,
                                            'note' => $note,
                                        ]
                                    );
                                    if ($result) {
                                        $_SESSION['msg']  = [
                                            'type' => "success",
                                            'message' => "Import success!"
                                        ];
                                    } else {
                                        $_SESSION['msg']  = [
                                            'type' => "danger",
                                            'message' => "Import failed!"
                                        ];
                                    }
                                }
                            }
                        } else {
                            $_SESSION['msg']  = [
                                'type' => "danger",
                                'message' => "Rule list name already exits. Please enter another name!"
                            ];
                        }
                    } catch (\Throwable $th) {
                        $_SESSION['msg']  = [
                            'type' => "danger",
                            'message' => "Import failed!"
                        ];
                    };
                }
            } catch (\Throwable $th) {
                $_SESSION['msg']  = [
                    'type' => "danger",
                    'message' => "Please check file again! Choose the correct file format (xlsx, xls, csv)!"
                ];
            }
        } else {
            $_SESSION['msg']  = [
                'type' => "danger",
                'message' => "Please choose the correct file format (xlsx, xls, csv)!"
            ];
        }
    }
    public function exportAction(Request $request)
    {
        $type_rule_id = $request->getPost()->get('type_rule_id');
        $type_rule_name = $request->getPost()->get('type_rule_name');
        $rules_by_type_ary = $this->obj_rule_model->getBy('type_rule_id', '=', $type_rule_id, '*');
        $spread_sheet = new Spreadsheet();
        $sheet = $spread_sheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Large category');
        $sheet->setCellValue('C1', 'Middle category');
        $sheet->setCellValue('D1', 'Small category');
        $sheet->setCellValue('E1', 'Content');
        $sheet->setCellValue('F1', 'Detail');
        $sheet->setCellValue('G1', 'Note');
        $row_count = 1;
        foreach ($rules_by_type_ary as $row) {
            $row_count++;
            $sheet->setCellValue('A' . $row_count, $row_count - 1);
            $sheet->setCellValue('B' . $row_count, $row['large_category']);
            $sheet->setCellValue('C' . $row_count, $row['middle_category']);
            $sheet->setCellValue('D' . $row_count, $row['small_category']);
            $sheet->setCellValue('E' . $row_count, $row['content']);
            $sheet->setCellValue('F' . $row_count, $row['detail']);
            $sheet->setCellValue('G' . $row_count, $row['note']);
        }

        $styles_body_ary = [
            'borders'   => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
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
            ],
        ];
        $spread_sheet->getActiveSheet()->getStyle("A1:G1")->applyFromArray($styles_header_ary);
        $spread_sheet->getActiveSheet()->getStyle("A2:G$row_count")->applyFromArray($styles_body_ary);
        $spread_sheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        foreach (range('A', 'G') as $column) {
            switch ($column) {
                case 'B':
                case 'C':
                case 'D':
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(20);
                    break;
                case 'E':
                case 'F':
                case 'G':
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(50);
                    break;
                default:
                    $spread_sheet->getActiveSheet()->getColumnDimension($column)->setWidth(5);
                    break;
            }
        }
        $spread_sheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spread_sheet->getDefaultStyle()->getFont()->setSize(10);

        $writer =  new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spread_sheet);
        $file_name = str_replace(' ', '_', $type_rule_name) . date('_Y_m_d_') . time() . ".xlsx";
        $writer->save($file_name);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="' . urlencode($file_name) . '"');
        readfile($file_name);
    }
}
