<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class HomeController extends Controller
{
    public $data =[] ;
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::render('default/index.php1');
    }
    public function diffAction()
    {
        View::render('default/diff.php');
    }

    public function compareAction()
    {
        if(isset($_POST['importSubmit'])){
            if(is_uploaded_file($_FILES['file1']['tmp_name']) && is_uploaded_file($_FILES['file2']['tmp_name'])){
                echo 'Uploaded file successfully';

                // Read the import file contents
                $fileroot1 = fopen($_FILES['file1']['tmp_name'], 'r');
                $fileroot2 = fopen($_FILES['file2']['tmp_name'], 'r');

                // Open 2 files init
                $fh1 = fopen("../core/inc/file1.inc", 'r+');
                $fh2 = fopen("../core/inc/file2.inc", 'r+');

                // Clear content in init file to 0 bits
                ftruncate($fh1, 0);
                ftruncate($fh2, 0);

                // Set variables form import file
                $variablesFile1 = [];
                $variablesFile2 = [];

                // Set variables in init file
                $variableGLOBALS1 = [];
                $variableGLOBALS2 = [];
    
                while(($line1  = fgets($fileroot1)) !== false) {

                    if(preg_match('/define\("(.+?)\", \"(.+?)\"/i', $line1 , $match)){

                        if(isset($variablesFile1[$match[1]])){

                            $variablesFile1[$match[1].'no2'] = $match[2];
                        }else {

                            $variablesFile1[$match[1]] = $match[2];
                        }
                        
                    }else if (preg_match('/define\("(.+?)\", \"\"/i', $line1 , $match)){

                        $variablesFile1[$match[1]] = '';
                    }else if(preg_match('/setDefineArray\(\'(.+?)\'/i', $line1 , $match)){

                        $variableGLOBALS1[] = $match[1];
                        
                    };

                    // Write data to init file
                    if(!preg_match('/define\(/i', $line1)){
                        fwrite($fh1, $line1); 
                    };

                   
                }
                while(($line2  = fgets($fileroot2)) !== false) {

                    if(preg_match('/define\("(.+?)\", \"(.+?)\"/i', $line2 , $match)){

                        if(isset($variablesFile2[$match[1]])){

                            $variablesFile2[$match[1].'no2'] = $match[2];
                        }else {

                            $variablesFile2[$match[1]] = $match[2];
                        }
                        
                    }else if (preg_match('/define\("(.+?)\", \"\"/i', $line2 , $match)){

                        $variablesFile2[$match[1]] = '';
                    }else if(preg_match('/setDefineArray\(\'(.+?)\'/i', $line2 , $match)){

                        $variableGLOBALS2[] = $match[1];
                        
                    };

                    // Write data to init file
                    if(!preg_match('/define\(/i', $line2)){
                        fwrite($fh2, $line2); 
                    };
                   
                }

   
                fclose($fh1);
                fclose($fh2);   

                $this->data['variableGLOBALS1'] = $variableGLOBALS1;
                $this->data['variableGLOBALS2'] = $variableGLOBALS2;
                $this->data['variablesFile1'] = $variablesFile1;
                $this->data['variablesFile2'] = $variablesFile2;
                View::render('default/compare.php',$this->data);

               
            }else {
                echo 'Uploaded file failed';
            }
        }
    }
}
