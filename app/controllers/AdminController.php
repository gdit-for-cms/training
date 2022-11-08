<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\ResponseTrait;
use Core\View;

class AdminController extends AppController
{
    use ResponseTrait;
    public array $data;

    public function indexAction() {
        $this->data['content'] = 'admin/dashboard';
    }

    public function diffAction() {
        $this->data['content'] = 'diff-file/diff';
    }

    /**
     * Output a file containing the variables from file upload.
     * Note: Not use AJAX for this method. Call it by "href" and it will automatically return the output file.
     */
    public function export(Request $request) {
        $name = $request->getGet()->get('name');
        $extension = $request->getGet()->get('ext');

        $file_name = "diff_file_" . time() . '.' . $extension;

        $f = fopen('php://memory', 'w'); 

        if ($name == 'file1') {
            $data = $_SESSION['data_export1'];
        } else if ($name == 'file2') {
            $data = $_SESSION['data_export2'];
        }

        fwrite($f , "<?php \r");
        foreach($data as $key => $value) {
            
            fwrite($f , $value);
        }

        fseek($f, 0); 
        
        // Set headers to download file rather than displayed.
        header('Content-Type: text/plain'); 
        header("Content-Disposition: attachment; filename=$file_name"); 
        
        // Output all remaining data on a file pointer.
        fpassthru($f);
  
        fclose($f);
    }

    /**
     * Output a file containing the variables to export that have been selected from view.
     * Note: Not use AJAX for this method. Call it by "href" and it will automatically return the output file.
     */
    public function exportSelect(Request $request) {
        $extension = $request->getGet()->get('ext');
        $not_pick_line1 = $request->getGet()->get('file1');
        $not_pick_line2 = $request->getGet()->get('file2');
        
        $not_pick_line1 = json_decode($not_pick_line1);
        $not_pick_line2 = json_decode($not_pick_line2);

        $file_name = "diff_file_" . time() . '.' . $extension;

        $f = fopen('php://memory', 'w'); 

        $data_export1  = $_SESSION['data_export1'];
        $data_export2  = $_SESSION['data_export2'];

        $data1 = $this->setDataForExport($data_export1, $not_pick_line1);
        $data2 = $this->setDataForExport($data_export2, $not_pick_line2);

        fwrite($f , "<?php \r");
        foreach($data1 as $key => $val) {
            fwrite($f , $val);
        }

        foreach($data2 as $key => $val) {
            fwrite($f , $val);
        }

        fseek($f, 0); 
        
        // Set headers to download file rather than displayed.
        header('Content-Type: text/plain'); 
        header("Content-Disposition: attachment; filename=$file_name"); 
        
        // Output all remaining data on a file pointer.
        fpassthru($f);
  
        fclose($f);
    }

    /**
     * Import and compare two files
     *
     * @return view with status and variables
     */
    public function compareAction(Request $request) {
        $this->data['content'] = 'diff-file/result';

        if (isset($_POST['importSubmit'])) {

            $file_accept = array('application/octet-stream', 'application/x-httpd-php', 'text/plain');

            if (
                !empty($_FILES['file1']['tmp_name']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK
                && !empty($_FILES['file2']['tmp_name']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK
                && in_array($_FILES['file1']['type'], $file_accept) && in_array($_FILES['file2']['type'], $file_accept)
            ) {

                $this->data['uploadStatus'] = 'Success';

                // Set content in file upload to array.
                $data_before = file_get_contents($_FILES['file1']['tmp_name']);
                $data_before = explode("\n", $data_before);

                $data_after = file_get_contents($_FILES['file2']['tmp_name']);
                $data_after = explode("\n", $data_after);

                // Set constants and variables in file.
                list($glo_in_file1, $const_in_file1, $in_file1, $check_distinct_in_file1) = $this->setVariable($data_before);
                list($glo_in_file2, $const_in_file2, $in_file2, $check_distinct_in_file2) = $this->setVariable($data_after);
                
                // Check duplicate variables and constants in file.
                $warning_in_file1 = array_count_values($check_distinct_in_file1);
                $warning_in_file2 = array_count_values($check_distinct_in_file2);

                // Set constants and variables in file by text.
                $by_text1 = $this->setVariableByText($data_before, $glo_in_file1);
                $by_text2 = $this->setVariableByText($data_after, $glo_in_file2);

                // Set constants and variables in file by text with line number.
                list($globals_file1, $constants_file1, $export_file1) = $this->setVariableWithLine($data_before, $glo_in_file1);
                list($globals_file2, $constants_file2, $export_file2) = $this->setVariableWithLine($data_after, $glo_in_file2);

                // Check that the empty.
                if ((empty($const_in_file1) || empty($const_in_file2)) && (empty($glo_in_file1) || empty($glo_in_file2))) {
                    $this->data['uploadStatus'] = 'Success. No variable found';
                } else {
                    // Session
                    $session = $request->getSession();
                    $session->data_export1 = $export_file1;
                    $session->data_export2 = $export_file2;
                   
                    // return warning variable in 2 files.
                    $this->data['warning_in_file1'] = $warning_in_file1;
                    $this->data['warning_in_file2'] = $warning_in_file2;

                    // return array of data for export.
                    $this->data['export_file1'] = $export_file1;
                    $this->data['export_file2'] = $export_file2;

                    // return all globals and constants in 2 files.
                    $this->data['globals_file1'] = $globals_file1;
                    $this->data['globals_file2'] = $globals_file2;
                    $this->data['constants_file1'] = $constants_file1;
                    $this->data['constants_file2'] = $constants_file2;

                    // Check a same variable name in 2 files.
                    $glo_ary = array_intersect($glo_in_file1, $glo_in_file2);
                    $const_ary = array_intersect($const_in_file1, $const_in_file2);

                    if (empty($glo_ary) && empty($const_ary)) {
                        $this->data['uploadStatus'] = 'Success. Nothing to compare';
                    } else {
                        // return a same globals and constants in 2 files.
                        $this->data['arr'] = $glo_ary;
                        $this->data['in_file1'] = $in_file1;
                        $this->data['in_file2'] = $in_file2;
                        $this->data['by_text1'] = $by_text1;
                        $this->data['by_text2'] = $by_text2;
                        $this->data['const_in_file1'] = $const_in_file1;
                        $this->data['const_in_file2'] = $const_in_file2;
                    }
                }
            } else {
                $this->data['uploadStatus'] = 'Failed';
            }
        } else {
            $this->data['uploadStatus'] = "You haven't imported the file yet.";
        }
    }

    /**
     * Get the variable in upload file
     *
     * @param  array  $data
     * @return array $glo_in_file, $const_in_file, $in_file, $check_distinct
     */
    public function setVariable($data) {
        // Check $data, $glo_in_file, $const_in_file, $in_file
        $glo_in_file = array();
        $const_in_file = array();
        $in_file = array();
        $check_distinct = array();

        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                if (isset($in_file[$match[1]])) {
                    array_push($check_distinct, $match[1]);
                } else {
                    array_push($glo_in_file, $match[1]);
                    $in_file[$match[1]] = array($match[2], $line);
                }
            } else if (preg_match('/^define\("(.+?)\", (.+?)\)/i', $data[$line], $match)) {
                if (isset($const_in_file[$match[1]])) {
                    array_push($check_distinct, $match[1]);
                } else {
                    $const_in_file[$match[1]] = $match[2];
                }
            }
        }
        // Removes duplicate values from an array.
        $glo_in_file = array_unique($glo_in_file);
        foreach ($glo_in_file as $each) {
            // The variable assigned to the glo variable.
            $check = $in_file[$each][0]; 
            // Line have setDefineArray function. 
            $index = $in_file[$each][1]; 
            $in_file[$each][0] = array();
            for ($line = $index; $line >= 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    for ($i = $line + 1, $line_skip = $i; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            break;
                        // Set value to the variable.
                        } else if (preg_match('/(array\()/i', $data[$i])) {
                            for ($j = $i + 1; $j < $index; $j++) {
                                $line_skip = $j;
                                if (preg_match('/\)/i', $data[$j])) {
                                    break;
                                } else if (preg_match('/\'(.+?)\' => (.+?),?/i', $data[$j])) {
                                    $temp = setKeyValueAry($data[$j]);
                                }
                            }
                            array_push($in_file[$each][0], $temp);
                        } else if ($i > $line_skip && (preg_match('/\'(.+?)\' => (.+?),?/i', $data[$i]))) {
                            $temp = setKeyValueAry($data[$i]);
                            array_push($in_file[$each][0], $temp);
                        }
                    }
                    break;
                }
            }
        }

        return array($glo_in_file, $const_in_file, $in_file, $check_distinct);
    }

    /**
     * Same as above(setVariable) but set variable value by text instead
     *
     * @param  array  $data (array content in file upload)
     * @param  array  $glo_in_file
     * @return array  $in_file
     */
    public function setVariableByText($data, $glo_in_file, $in_file = []) {
        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                if (!isset($in_file[$match[1]])) {
                    $in_file[$match[1]] = array($match[2], $line);
                }
            }
        }
        foreach ($glo_in_file as $each) {
            // The variable assigned to the global variable.
            $check = $in_file[$each][0];
            // Line have setDefineArray function.   
            $index = $in_file[$each][1];
            $in_file[$each][0] = array();
            for ($line = $index; $line >= 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    for ($i = $line + 1; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            break;
                        } else {
                            $result = str_replace(' ', '&nbsp;', $data[$i]);
                            array_push($in_file[$each][0], $result);
                        }
                    }
                    break;
                }
            }
        }
        
        return $in_file;
    }

    /**
     * Set variable value by text with line number and set array of data for export
     *
     * @param  array  $data (array content in file upload)
     * @param  array  $glo_in_file
     * @return array  $globals_ary, $constants_ary, $export_file
     */
    public function setVariableWithLine($data, $glo_in_file) {
        $globals_ary = array();
        $constants_ary = array();
        $export_file = array();

        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                if (!isset($globals_ary[$match[1]])) {
                    $globals_ary[$match[1]] = array($match[2], $line);
                    $export_file[$line] = $data[$line];
                }
            } else if (preg_match('/^define\("(.+?)\", (.+?)\)/i', $data[$line], $match)) {
                if (!isset($constants_ary[$match[1]])) {
                    $constants_ary[$match[1]] = array($match[2], $line);
                    $export_file[$line] = $data[$line];
                }
            }
        }
        foreach ($glo_in_file as $each) {
            // The variable assigned to the global variable.
            $check = $globals_ary[$each][0];
            // Line contain setDefineArray function.   
            $index = $globals_ary[$each][1];
            $globals_ary[$each][0] = array();
            for ($line = $index; $line >= 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    $export_file[$line] = $data[$line];
                    for ($i = $line + 1; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            $export_file[$i] = $data[$i];
                            break;
                        } else {
                            $result = str_replace(' ', '&nbsp;', $data[$i]);
                            $globals_ary[$each][0][$i] = $result;
                            $export_file[$i] = $data[$i];
                        }
                    }
                    break;
                }
            }
        }

        // Set array of data for export
        ksort($export_file);

        return array($globals_ary, $constants_ary, $export_file);
    }

    /**
     * Set array data for export without the line from array($not_pick_line)
     *
     * @param  array  $data_session (array content from export data)
     * @param  array  $not_pick_line (lines containing variables that you don't want to export)
     * @return array  $result
     */
    public function setDataForExport($data_session, $not_pick_line) {
        $data = array();
        $result = array();
        $temp = array();

        foreach ($data_session as $key => $value) {
            if (!in_array($key, $not_pick_line)) {
                array_push($data, $value);
            }
        }

        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                $result[$line] = $data[$line];
                $temp[$match[1]] = array($match[2], $line);
            } else if (preg_match('/^define\("(.+?)\", (.+?)\)/i', $data[$line], $match)) {
                $result[$line] = $data[$line];
            }
        } 
        
        foreach ($temp as $each) {
            $check = $each[0];
            $index = $each[1];
            for ($j = $index; $j >= 0 ; $j = $j - 1) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$j])) {
                    $result[$j] = $data[$j];
                    for ($i = $j + 1; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            $result[$i] = $data[$i];
                            break;
                        } else {
                            $result[$i] = $data[$i];
                        }
                    }
                    break;
                }
            }
        }
        ksort($result);

        return $result;
    }
}
