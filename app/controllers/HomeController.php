<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\models\User;
use Core\Http\Session;
use Core\Http\Request;

class HomeController extends Controller
{
    public $data =[] ;
    public $session  ;
    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct()
    {
       $this->session =  Session::getInstance();
    }
    /**
     * Show the index page
     *
     * @return void
     */

    public function homepage()
    {

        View::render('home/homepage.php');

    }
    public function login(Request $request)
    {

        $email = htmlspecialchars(addslashes($request->getPost()['email']));
        $password = htmlspecialchars(addslashes($request->getPost()['password']));

        $user = new User();
        $currentUser = $user->table('user')
                     ->where('email', '=', $email)
                     ->where('password', '=', $password)
                     ->get('');

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

            $token = uniqid('user_', true) . time();
            $user->table('user')->where('id', '=', $currentUser[0]['id'])->update(['token' => $token]);

            setcookie('remember', $token, time() + 86400*30, '/');
            header("location: /index");
        } else {
            $this->session->__set('error', 'email or password is incorrect');
            header('Location: /');
        }
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
