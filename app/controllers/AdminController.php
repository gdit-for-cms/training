<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use App\models\Room;
use Core\Http\Request;

class AdminController extends Controller
{
    public $data = [];


    protected function before() 
    {
        if (!checkUser()) {
            header('Location: /default/index');
            exit;
        }
    }

    protected function after() 
    {
        View::render('admin/back-layouts/master.php',$this->data);
    }

    public function indexAction()
    {   
        $this->data['content'] = 'default/dashboard';
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

                // Open 2 files init
                $fh1 = fopen("../storage/inc/file1.inc", 'r+');
                $fh2 = fopen("../storage/inc/file2.inc", 'r+');
                
                // Clear content in init file to 0 bits
                ftruncate($fh1, 0);
                ftruncate($fh2, 0);

                // Set variables form import file
                $variableInFile1 = [];
                $variableInFile2 = [];

                // Set variables in init file
                $variableGLOBALS1 = [];
                $variableGLOBALS2 = [];
                
                list($variableInFile1, $variableGLOBALS1) = $this->ExecuteImportFile($before, $fh1, $variableInFile1, $variableGLOBALS1);
                list($variableInFile2, $variableGLOBALS2) = $this->ExecuteImportFile($after, $fh2, $variableInFile2, $variableGLOBALS2);
                
                fclose($fh1);
                fclose($fh2);   
                
                // Get the array of variables in file1 
                require_once '../storage/inc/file1.inc';
                $tempGlobal1 = [];
                $globalsVarName1 = [];
                list($globalsVarName1, $tempGlobal1) = setTempGlobal($variableGLOBALS1, $globalsVarName1, $tempGlobal1);

                // Get the array of variables in file2 
                require_once '../storage/inc/file2.inc';
                $tempGlobal2 = [];
                $globalsVarName2 = [];
                list($globalsVarName2, $tempGlobal2) = setTempGlobal($variableGLOBALS2, $globalsVarName2, $tempGlobal2);

                $this->data['variableInFile1'] = $variableInFile1;
                $this->data['variableInFile2'] = $variableInFile2;
                $this->data['globalsVarName1'] = $globalsVarName1;
                $this->data['globalsVarName2'] = $globalsVarName2;
                $this->data['tempGlobal1'] = $tempGlobal1;
                $this->data['tempGlobal2'] = $tempGlobal2;
                
                $this->data['content'] = 'diff-file/compare';
                View::render('admin/back-layouts/master.php', $this->data);
               
            } else {
                $this->data['uploadStatus'] = 'failed';
                $this->data['content'] = 'diff-file/compare';
                View::render('admin/back-layouts/master.php', $this->data);
            }
        }
    }

    public function ExecuteImportFile($fileImport, $fileInit, $variableInFile, $variableGLOBALS) {
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
            if (!preg_match('/define\(/i', $line)) {
                fwrite($fileInit, $line); 
            };
        }

        return array($variableInFile, $variableGLOBALS);
    }
}