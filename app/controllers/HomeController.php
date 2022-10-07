<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class HomeController extends Controller
{
    use ResponseTrait;

    public $data = [];
    public $session;

    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
       $this->session = Session::getInstance();
    }
 
    public function homepage()
    {
        $this->data['content'] = 'home/homepage';
        View::render('front-layouts/master.php',$this->data);

    }
    
    public function loginAction(Request $request)
    {
        $email = htmlspecialchars(addslashes($request->getPost()['email']));
        $password = addslashes($request->getPost()['password']);

        $user = new User();
        $currentUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->get();
        $number_rows = count($currentUser);

        if ($number_rows == 1) {
            $data = [
                'name' => $currentUser[0]['name'],
                'email' => $currentUser[0]['email'],
                'role_id' => $currentUser[0]['role_id'],
                'room_id' => $currentUser[0]['room_id'],
            ];
            $this->session->__unset('error');
            $this->session->__set('currentUser', $data);

            echo $this->successResponse();
        } else {

            echo $this->errorResponse($message = 'failed');
        }
    }

    public function logoutAction()
    {   
        $this->session->__unset('currentUser');

        setcookie('remember',null,-1);

        header('location: /home/homepage');
        exit;
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
                
                function ExecuteImportFile($fileroot, $fileinit ,$variablesFile, $variableGLOBALS ) {
                    while (($line  = fgets($fileroot))) {
                        if (preg_match('/define\("(.+?)\", \"(.+?)\"/i', $line, $match)) {
                            $i = 1 ;
                            if (isset($variablesFile[$match[1]])) {
                                $variablesFile[$match[1].'['.$i++.']'] = $match[2];
                            } else {
                                $variablesFile[$match[1]] = $match[2];
                            }
                        } else if (preg_match('/define\("(.+?)\", \"\"/i', $line, $match)) {
                            $variablesFile[$match[1]] = '';
                        } else if (preg_match('/setDefineArray\(\'(.+?)\'/i', $line, $match)) {
                            $variableGLOBALS[] = $match[1];
                        };
    
                        // Write data to init file
                        if (!preg_match('/define\(/i', $line)) {
                            fwrite($fileinit, $line); 
                        };
                    }

                    return array( $variablesFile, $variableGLOBALS );
                };

                list($variablesFile1, $variableGLOBALS1) = ExecuteImportFile($fileroot1, $fh1, $variablesFile1, $variableGLOBALS1);
                list($variablesFile2, $variableGLOBALS2) = ExecuteImportFile($fileroot2, $fh2, $variablesFile2, $variableGLOBALS2);
                
                fclose($fh1);
                fclose($fh2);   

                require_once '../core/inc/setDefineArray.php' ;

                // Get the array of variables in file1
                require_once '../core/inc/file1.inc';
                $tempGlobal1 = [];
                $globalsVarName1 = [];
                list($globalsVarName1, $tempGlobal1) = setTempGlobal($variableGLOBALS1, $globalsVarName1, $tempGlobal1);

                // Get the array of variables in file2
                require_once '../core/inc/file2.inc';
                $tempGlobal2 = [];
                $globalsVarName2 = [];
                list($globalsVarName2, $tempGlobal2) = setTempGlobal($variableGLOBALS2, $globalsVarName2, $tempGlobal2);

                $this->data['variablesFile1'] = $variablesFile1;
                $this->data['variablesFile2'] = $variablesFile2;
                $this->data['globalsVarName1'] = $globalsVarName1;
                $this->data['tempGlobal1'] = $tempGlobal1;
                $this->data['globalsVarName2'] = $globalsVarName2;
                $this->data['tempGlobal2'] = $tempGlobal2;
                View::render('default/compare.php',$this->data);

               
            }else {
                echo 'Uploaded file failed';
            }
        }
    }
}
