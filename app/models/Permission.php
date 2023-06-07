<?php

namespace App\Models;

use Core\Model;
use PDO;
use Core\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Permission extends Model
{
    use QueryBuilder;

    private $_table = 'permissions';

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        return (new self)->all();
    }

    public static function getChildsByParentId($parent_id)
    {
        return (new self)->getBy('parent_id', '=', $parent_id);
    }
    public function create($data)
    {
        return $this->insert($data);
    }

    public function getBy($column, $operator, $value)
    {
        return $this->where($column, $operator, $value)->get();
    }

    public function getById($id, $column)
    {
        return $this->find($id, $column);
    }
    public static  function getParentPermissionHtml($room_id)
    {
        $cards = "";
        $permissionParents = (new self)->getBy('parent_id', '=', 0);
        if (!empty($permissionParents)) {
            foreach ($permissionParents as $permissionParentItem) {
                $permission_childs_html = self::getPermissionRoomHtml($room_id, $permissionParentItem['id']);
                $cards .= "<div class='card m-4'>
                <div class='card-header '>
                    <div class='form-check'>
                        <label for='module-rule-checkbox' class='form-check-label fw-bold'> " . $permissionParentItem['name'] . " </label>
                    </div>
                </div>
                <div class='card-body d-flex justify-content-start flex-wrap'>
                " . $permission_childs_html . "
                </div>
            </div>";
            }
        }
        return $cards;
    }

    public static function getPermissionRoomHtml($room_id, $parentId)
    {
        $permissionParentHtml = "";
        $permission_ids_by_room_id = PermissionRoom::getPermissionIdsByRoomId($room_id);
        foreach (Permission::getChildsByParentId($parentId) as $permissionItem) {
            $type = 'text-decoration-line-through';
            foreach ($permission_ids_by_room_id as $permission_id) {
                if ($permission_id == $permissionItem['id']) {
                    $type = "bg-success ";
                }
            }
            $permissionParentHtml .= "<label class='form-check-label p-1 rounded mr-1 mt-2  text-center $type'>" . $permissionItem['name'] . "</label>";
        }
        return $permissionParentHtml;
    }
}