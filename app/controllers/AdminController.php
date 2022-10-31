<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\ResponseTrait;

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
     * Import and compare two files
     *
     * @return view with status and variables
     */
    public function compareAction() {
        $this->data['content'] = 'diff-file/result';

        if (isset($_POST['importSubmit'])) {

            $file_accept = array('application/octet-stream', 'application/x-httpd-php', 'text/plain');

            if (
                !empty($_FILES['file1']['tmp_name']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK
                && !empty($_FILES['file2']['tmp_name']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK
                && in_array($_FILES['file1']['type'], $file_accept) && in_array($_FILES['file2']['type'], $file_accept)
            ) {

                $this->data['uploadStatus'] = 'Success';

                // Set content in file import to array.
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
                list($globals_file1, $constants_file1) = $this->setVariableWithLine($data_before, $glo_in_file1);
                list($globals_file2, $constants_file2) = $this->setVariableWithLine($data_after, $glo_in_file2);

                // Check that the empty.
                if ((empty($const_in_file1) || empty($const_in_file2)) && (empty($glo_in_file1) || empty($glo_in_file2))) {
                    $this->data['uploadStatus'] = 'Success. No variable found';
                } else {
                    // Check a same variable name in 2 files.
                    $glo_ary = array_intersect($glo_in_file1, $glo_in_file2);
                    $const_ary = array_intersect($const_in_file1, $const_in_file2);
                    if (empty($glo_ary) && empty($const_ary)) {
                        $this->data['uploadStatus'] = 'Success. Nothing to compare';
                        $this->data['warning_in_file1'] = $warning_in_file1;
                        $this->data['warning_in_file2'] = $warning_in_file2;
                        // return all globals and constants in 2 files.
                        $this->data['globals_file1'] = $globals_file1;
                        $this->data['globals_file2'] = $globals_file2;
                        $this->data['constants_file1'] = $constants_file1;
                        $this->data['constants_file2'] = $constants_file2;
                    } else {
                        // return a same globals and constants in 2 files.
                        $this->data['arr'] = $glo_ary;
                        $this->data['in_file1'] = $in_file1;
                        $this->data['in_file2'] = $in_file2;
                        $this->data['by_text1'] = $by_text1;
                        $this->data['by_text2'] = $by_text2;
                        $this->data['const_in_file1'] = $const_in_file1;
                        $this->data['const_in_file2'] = $const_in_file2;
                        $this->data['warning_in_file1'] = $warning_in_file1;
                        $this->data['warning_in_file2'] = $warning_in_file2;

                        // return all globals and constants in 2 files.
                        $this->data['globals_file1'] = $globals_file1;
                        $this->data['globals_file2'] = $globals_file2;
                        $this->data['constants_file1'] = $constants_file1;
                        $this->data['constants_file2'] = $constants_file2;
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
     * Get the variable in import file
     *
     * @param  array  $data, $glo_in_file, $const_in_file, $in_file
     * @return array $glo_in_file, $const_in_file, $in_file
     */
    public function setVariable($data, $glo_in_file = [], $const_in_file = [], $in_file = [], $check_distinct = []) {
        // Check $data, $glo_in_file, $const_in_file, $in_file
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
            for ($line = $index; $line > 0; $line--) {
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
     * Same as above(getVariable) but set variable value by text instead
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
            for ($line = $index; $line > 0; $line--) {
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
     * Set variable value by text with line number
     *
     * @param  array  $data (array content in file upload)
     * @param  array  $glo_in_file
     * @return array  $globals_ary, $constants_ary
     */
    public function setVariableWithLine($data, $glo_in_file, $globals_ary = [], $constants_ary = []) {
        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                if (!isset($globals_ary[$match[1]])) {
                    $globals_ary[$match[1]] = array($match[2], $line);
                }
            } else if (preg_match('/^define\("(.+?)\", (.+?)\)/i', $data[$line], $match)) {
                if (!isset($constants_ary[$match[1]])) {
                    $constants_ary[$match[1]] = array($match[2], $line);
                }
            }
        }
        foreach ($glo_in_file as $each) {
            // The variable assigned to the global variable.
            $check = $globals_ary[$each][0];
            // Line have setDefineArray function.   
            $index = $globals_ary[$each][1];
            $globals_ary[$each][0] = array();
            for ($line = $index; $line > 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    for ($i = $line + 1; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            break;
                        } else {
                            $result = str_replace(' ', '&nbsp;', $data[$i]);
                            $globals_ary[$each][0][$i] = $result;
                        }
                    }
                    break;
                }
            }
        }
        
        return array($globals_ary, $constants_ary);
    }
}
