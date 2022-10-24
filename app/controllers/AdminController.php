<?php

namespace App\Controllers;

class AdminController extends AppController
{
    public array $data;

    public function indexAction()
    {
        $this->data['content'] = 'admin/dashboard';
    }

    public function testAction()
    {
        $this->data['content'] = 'diff-file/test';
    }

    public function diffAction()
    {
        $this->data['content'] = 'diff-file/diff';
    }

    /**
     * Import and compare two files
     *
     * @return view with status and variables
     */
    public function compareAction()
    {
        $this->data['content'] = 'diff-file/result';

        if (isset($_POST['importSubmit'])) {

            $file_accept = array('application/octet-stream');

            if (
                !empty($_FILES['file1']['tmp_name']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK
                && !empty($_FILES['file2']['tmp_name']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK
                && in_array($_FILES['file1']['type'], $file_accept) && in_array($_FILES['file2']['type'], $file_accept)
            ) {

                $this->data['uploadStatus'] = 'Upload status: success';

                // Set content in file import to array
                $data_before = file_get_contents($_FILES['file1']['tmp_name']);
                $data_before = explode("\n", $data_before);

                $data_after = file_get_contents($_FILES['file2']['tmp_name']);
                $data_after = explode("\n", $data_after);

                // Set constants and variables in file
                list($global_in_file1, $const_in_file1, $in_file1, $check_distinct_in_file1) = $this->getVariableInFile($data_before);
                list($global_in_file2, $const_in_file2, $in_file2, $check_distinct_in_file2) = $this->getVariableInFile($data_after);
                
                // Check duplicate variables and constants in file
                $warning_in_file1 = array_count_values($check_distinct_in_file1);
                $warning_in_file2 = array_count_values($check_distinct_in_file2);

                // Check that the empty 
                if ((empty($const_in_file1) || empty($const_in_file2)) && (empty($global_in_file1) || empty($global_in_file1))) {
                    $this->data['uploadStatus'] = 'Upload status: success. Nothing to compare';
                } else {
                    // Check a same variable name in 2 files.
                    $arr = array_intersect($global_in_file1, $global_in_file2);
                    $this->data['arr'] = $arr;
                    $this->data['in_file1'] = $in_file1;
                    $this->data['in_file2'] = $in_file2;
                    $this->data['const_in_file1'] = $const_in_file1;
                    $this->data['const_in_file2'] = $const_in_file2;
                    $this->data['warning_in_file1'] = $warning_in_file1;
                    $this->data['warning_in_file2'] = $warning_in_file2;
                }
            } else {
                $this->data['uploadStatus'] = 'Upload status: Failed';
            }
        } else {
            $this->data['uploadStatus'] = "you haven't imported the file yet.";
        }
    }

    /**
     * Get the variable in import file 
     *
     * @param  array  $data, $global_in_file, $const_in_file, $in_file
     * @return array $global_in_file, $const_in_file, $in_file
     */
    public function getVariableInFile($data, $global_in_file = [], $const_in_file = [], $in_file = [], $check_distinct = [])
    {
        // Check $data, $global_in_file, $const_in_file, $in_file
        // $check_distinct['globals'] = [];
        // $check_distinct['constants'] = [];
        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                if (isset($in_file[$match[1]])) {
                    array_push($check_distinct, $match[1]);
                } else {
                    array_push($global_in_file, $match[1]);
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
        // Removes duplicate values from an array 
        $global_in_file = array_unique($global_in_file);
        foreach ($global_in_file as $each) {
            // The variable assigned to the global variable
            $check = $in_file[$each][0];
            // Line have setDefineArray function
            $index = $in_file[$each][1];
            $in_file[$each][0] = array();
            for ($line = $index; $line > 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    for ($i = $line + 1, $line_skip = $i; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            break;
                        // Set value to the variable
                        } else if (preg_match('/(array\()/i', $data[$i])) {
                            for ($j = $i + 1; $j < $index; $j++) {
                                $line_skip = $j;
                                if (preg_match('/\)/i', $data[$j])) {
                                    break;
                                } else if (preg_match('/\'(.+?)\' => (.+?),?/i', $data[$j], $matches)) {
                                    $arr = explode('=>', rtrim(trim($data[$j]), ','));
                                    $key = trim($arr[0]);
                                    $value = trim($arr[1]);
                                    $temp[trim($key, "'")] = trim($value, "'");
                                }
                            }
                            array_push($in_file[$each][0], $temp);
                        } else if ($i > $line_skip && (preg_match('/\'(.+?)\' => (.+?),?/i', $data[$i], $matcarrs))) {
                            $temp = array();
                            $arr = explode('=>', rtrim(trim($data[$i]), ','));
                            $key = trim($arr[0]);
                            $value = trim($arr[1]);
                            $temp[trim($key, "'")] = trim($value, "'");
                            array_push($in_file[$each][0], $temp);
                        }
                    }
                    break;
                }
            }
        }

        return array($global_in_file, $const_in_file, $in_file, $check_distinct);
    }
}
