<?php

namespace App\Controllers\Admin;

use Core\View;
use App\models\User;
use App\models\Room;
use Core\Http\Request;
use Core\Http\ResponseTrait;

class AdminController extends AppController
{
    use ResponseTrait;

    public array $data_ary;

    public $title = 'Chủ';

    public function __construct() {
        $this->obj_model = new User;
    }

    public function indexAction() {
        $this->data_ary['content'] = 'admin/dashboard';
    }

    public function showAction(Request $request) {   
        $user = $request->getUser();
        $user_ary = $this->obj_model->getById($user['id'])[0];

        $this->data_ary['content'] = 'show';
        $this->data_ary['user'] = $user_ary;
    }

    public function uploadAvatar(Request $request) {
        try {
            $image_file = $request->getFiles()->get('image');

            if (empty($image_file['name'])) {
                return $this->errorResponse('Undefined image');
            }

            $user = $request->getUser();
            $id = $user['id'];
            
            $before_avatar = $this->obj_model->getById($id)[0]['avatar_image'];

            $image_dir = 'ckfinder/userfiles/images/avatars/';
            $name = $id . '_' . date("Y-m-d_h-i-s") . '_' . $image_file['name'];
            move_uploaded_file($image_file["tmp_name"], $image_dir . $name);

            $this->obj_model->updateOne(
                [
                    'avatar_image' => $image_dir . $name,
                ],
                "id = $id"
            );
            $user['avatar_image'] = $image_dir . $name;
            $request->saveUser($user);

            if (file_exists($before_avatar) && !empty($before_avatar)) {
                unlink($before_avatar);
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse('An error occurred during upload');
        };
    }

    public function deleteAvatar(Request $request) {
        $user = $request->getUser();
        if (empty($user['avatar_image'])) {
            return $this->errorResponse('Please update avatar');
        }
        $id = $user['id'];

        $before_avatar = $this->obj_model->getById($id);
        $before_avatar = $before_avatar[0]['avatar_image'];
        $this->obj_model->updateOne(
            [
                'avatar_image' => NULL,
            ],
            "id = $id"
        );
        $user['avatar_image'] = '';
        $request->saveUser($user);

        unlink($before_avatar);
        return $this->successResponse();
    }

    public function diffAction()
    {
        $this->data['content'] = 'diff-file/diff';
    }

    public function compareAction()
    {
        if (isset($_POST['importSubmit'])) {

            $fileAccept = array('application/octet-stream', 'application/inc', 'application/php');

            if (
                is_uploaded_file($_FILES['file1']['tmp_name']) && is_uploaded_file($_FILES['file2']['tmp_name'])
                && in_array($_FILES['file1']['type'], $fileAccept) && in_array($_FILES['file2']['type'], $fileAccept)
            ) {

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
                        $inBefore[$match[1]] = array($match[2], $line);
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
    public function hehe($data, $index)
    {
        for ($line = 0; $line < $index; $line++) {
            if (preg_match('/\$(.+?)( = array\()/i', $data[$line], $match)) {
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


    public function executeImportFile($fileImport, $variableInFile, $variableGLOBALS)
    {
        while (($line  = fgets($fileImport))) {
            if (preg_match('/define\("(.+?)\", \"(.+?)\"/i', $line, $match)) {
                $i = 1;
                if (isset($variableInFile[$match[1]])) {
                    $variableInFile[$match[1] . '[' . $i++ . ']'] = $match[2];
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

    public function getDefineArray($data, $line)
    {
        if (preg_match('/setDefineArray\(\'(.+?)\'/i', $data[$line], $match)) {
            // $variableGLOBALS[] = $match[1];
            print_r($match);
            echo $data[$line];
        };
    }
}
