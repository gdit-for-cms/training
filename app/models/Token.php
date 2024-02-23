<?php

namespace App\Models;

use Core\Model;
use Core\QueryBuilder;

/**
 * Token model
 *
 * PHP version 7.0
 */
class Token extends Model {
    use QueryBuilder;

    private $_table = 'token';

    /**
     * Get a token by user id.
     *
     * @return string
     */
    public function findByUserId($id) {
        return $this->table($this->_table)->find($id);
    }

    /**
     * Create a new token.
     *
     * @param array $data
     * @return mixed
     */
    public function create($data) {
        return $this->table($this->_table)->insert($data);
    }

    /**
     * Update an existing token.
     *
     * @param array $data
     * @param array $condition
     * @return mixed
     */
    public function updateToken($data, $condition) {
        return $this->table($this->_table)->update($data, $condition);
    }

    /**
     * Delete a token.
     *
     * @param array $condition
     * @return mixed
     */
    public function destroyOne($condition) {
        return $this->table($this->_table)->destroy($condition);
    }
}
