<?php

namespace App\Controllers;

class AdminController extends AppController
{
    public array $data;

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
        $this->data['content'] = 'diff-file/compare';

        if (isset($_POST['importSubmit'])) {

            $fileAccept = array('application/octet-stream');
            
            if (!empty($_FILES['file1']['tmp_name']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK 
                && !empty($_FILES['file2']['tmp_name']) && $_FILES['file2']['error'] === UPLOAD_ERR_OK 
                && in_array($_FILES['file1']['type'], $fileAccept) && in_array($_FILES['file2']['type'], $fileAccept)) {

                $this->data['uploadStatus'] = 'Upload status: success';
                
                // Set content in file import to array
                $dataBefore = file_get_contents($_FILES['file1']['tmp_name']); 
                $dataBefore = explode("\n", $dataBefore); 

                $dataAfter = file_get_contents($_FILES['file2']['tmp_name']); 
                $dataAfter = explode("\n", $dataAfter); 

                // Set constants and variables in file
                $constInFile1 = [];
                $constInFile2 = [];

                $globalInFile1 = [];
                $globalInFile2 = [];

                $inFile1 = [];
                $inFile2 = [];

                list($globalInFile1, $constInFile1, $inFile1) = $this->getVariableInFile($dataBefore, $globalInFile1, $constInFile1, $inFile1);
                list($globalInFile2, $constInFile2, $inFile2) = $this->getVariableInFile($dataAfter, $globalInFile2, $constInFile2, $inFile2);
                
                // Check that the empty 
                if ((empty($constInFile1) || empty($constInFile2)) && (empty($globalInFile1) || empty($globalInFile1))) {
                    $this->data['uploadStatus'] = 'Upload status: success. Nothing to compare';
                } else {
                    // Check a same variable name in 2 files.
                    $arr = array_intersect($globalInFile1, $globalInFile2);
                    $this->data['arr'] = $arr;
                    $this->data['constInFile1'] = $constInFile1;
                    $this->data['constInFile2'] = $constInFile2;
                    $this->data['inFile1'] = $inFile1;
                    $this->data['inFile2'] = $inFile2;
                }
            } else {
                $this->data['uploadStatus'] = 'Upload status: Failed';
            }
        } else {
            $this->data['uploadStatus'] = "you haven't imported the file yet.";
        }
    }


    public function getVariableInFile($data, $globalInFile, $constInFile, $inFile)
    {
        for ($line = 0; $line < count($data); $line++) {
            if (preg_match('/^setDefineArray\(\'(.+?)\', \$(.+?)\)/i', $data[$line], $match)) {
                $globalInFile[] = $match[1];
                $inFile[$match[1]] = array($match[2] , $line);
            } else if (preg_match('/^define\("(.+?)\", (.+?)\)/i', $data[$line], $match)) {
                $i = 2 ;
                if (isset($constInFile[$match[1]])) {
                    $constInFile[$match[1] . '(' . $i++ . ')'] = $match[2];

                } else {
                    $constInFile[$match[1]] = $match[2];
                }
            } 
        }
        $globalInFile = array_unique($globalInFile);
        foreach ($globalInFile as $each) {
            $check = $inFile[$each][0];
            $inFile[$each][0] = array();
            $index = $inFile[$each][1];
            for ($line = $index; $line > 0; $line--) {
                if (preg_match('/^\$' . $check . '( = array\()/i', $data[$line])) {
                    for ($i = $line + 1; $i < $index; $i++) {
                        if (preg_match('/^\)\;/i', $data[$i])) {
                            break;
                        } else {
                            array_push($inFile[$each][0], $data[$i]);
                        }
                    }
                    break;
                }
            }
        }
        
        return array($globalInFile, $constInFile, $inFile);
    }
}
