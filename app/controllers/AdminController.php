<?php

namespace App\Controllers;

use Core\View;
use App\models\User;
use App\models\Room;
use Core\Http\Request;

class AdminController extends AppController
{
    public array $data;

    public $title = 'Chủ';
    
    public function indexAction()
    {   
        $this->data['content'] = 'admin/dashboard';
    }

    public function diffAction()
    {
        $this->data['content'] = 'diff-file/diff';
    }

    public function compareAction()
    {
        if (isset($_POST['importSubmit'])) {

            $fileAccept = array('application/octet-stream', 'application/inc', 'application/php');

            if (is_uploaded_file($_FILES['file1']['tmp_name']) && is_uploaded_file($_FILES['file2']['tmp_name']) 
            && in_array($_FILES['file1']['type'], $fileAccept) && in_array($_FILES['file2']['type'], $fileAccept)) {

                $this->data['uploadStatus'] = 'success';
                
                // Read the import file contents
                $before = fopen($_FILES['file1']['tmp_name'], 'r');
                $after = fopen($_FILES['file2']['tmp_name'], 'r');
                
                // Set variables form import file
                $variableInFile1 = [];
                $variableInFile2 = [];

                // Set variables in init file
                $variableGLOBALS1 = [];
                $variableGLOBALS2 = [];
                
                $findArray = [];
                $inBefore = [];

                $data = file_get_contents($_FILES['file1']['tmp_name']); 
                $data = explode("\n", $data); 
                for ($line = 0; $line < count($data); $line++) { 
                    if (preg_match('/setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                        $variableGLOBALS1[] = $match[1];
                        $inBefore[$match[1]] = array($match[2] , $line);
                    };
                } 

                foreach ($variableGLOBALS1 as $each) {
                    $check = $inBefore[$each][0];
                    $index = $inBefore[$each][1];
                    for ($line = $index; $line > 0; $line--) { 
                        if (preg_match('/\$' . $check . '( = array\()/i', $data[$line])) {
                            for ($i = $line; $i < $index; $i++) {
                               
                                if (preg_match('/^\)\;/i', $data[$i])) { 
                                    print_r($data[$i]);
                                } else {
                                    print_r($data[$i]);
                                }
                            }
                            break;
                        }
                        
                    }
                }
                // $a = $this->hehe($data, $arrIndex[0]);
                // for ($line = 0; $line < $defineFncLine[0]; $line++) { 
                //     if (preg_match('/\$(.+?)( = array\()/i', $data[$line] , $match)) {
                //         $findArray[] = $line;
                //         for ($i = $line + 1; $i < count($data); $i++) {
                //             if (preg_match('/^\)\;/i', $data[$i])) { 
                //                 break;
                //             } else {
                //                 $test[$i] = $data[$i];
                //             }
                //         }
                //         $a = array_fill_keys($findArray, $test);
                //     } else if (preg_match('/^\)\;/i', $data[$line])) { 
                //         break;
                //     }
                // } 
                // print_r($arrIndex);
                // print_r($inBefore);
                // print_r($variableGLOBALS1);
                exit;
               
            } else {
                $this->data['uploadStatus'] = 'failed';
                $this->data['content'] = 'diff-file/compare';
            }
        }
    }
    public function hehe($data, $index){
        for ($line = 0; $line < $index; $line++) { 
            if (preg_match('/\$(.+?)( = array\()/i', $data[$line] , $match)) {
                for ($i = $line + 1; $i < count($data); $i++) {
                    if (preg_match('/^\)\;/i', $data[$i])) { 
                        break;
                    } else {
                        $test[$i] = $data[$i];
                    }
                }
            } else if (preg_match('/^\)\;/i', $data[$line])) { 
                break;
            }
        } 
    }


    public function executeImportFile($fileImport, $variableInFile, $variableGLOBALS) {
        while (($line  = fgets($fileImport))) {
            if (preg_match('/define\("(.+?)\", \"(.+?)\"/i', $line, $match)) {
                $i = 1 ;
                if (isset($variableInFile[$match[1]])) {
                    $variableInFile[$match[1].'['.$i++.']'] = $match[2];
                } else {
                    $variableInFile[$match[1]] = $match[2];
                }
            } else if (preg_match('/define\("(.+?)\", \"\"/i', $line, $match)) {
                $variableInFile[$match[1]] = '';
            } else if (preg_match('/setDefineArray\(\'(.+?)\'/i', $line, $match)) {
                $variableGLOBALS[] = $match[1];
            };

            // Write data to init file

        }

        return array($variableInFile, $variableGLOBALS);
    }

    public function getDefineArray($data, $line) {
        if (preg_match('/setDefineArray\(\'(.+?)\'/i', $data[$line], $match)) {
            // $variableGLOBALS[] = $match[1];
            print_r($match);
            echo $data[$line];
        };
    }
}
