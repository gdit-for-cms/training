<?php 
namespace Core;

use PDO;

Trait QueryBuilder
{
    public $tableName = '';
    public $where = '';
    public $operator = '';
    public $selectColumn = '*';
    public $limit = '';
    public $orderBy = '';
    public $innerJoin = '';
    
    /**
     *
     * @param  string  $tableName
     * @return $this
     */
    public function table($tableName){

        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array  $column
     * @param  mixed  $value
     * @param  string  $compare (Symbol)
     * @return $this
     */
    public function where($column, $compare, $value){

        if(empty($this->where)){
            $this->operator = ' WHERE ';
        }else {
            $this->operator = ' AND ';
        }
        $this->where .= "$this->operator $column $compare '$value'";
        return $this;
    }

    /**
     * Add an "or where" clause to the query.
     *
     * @param  string|array  $column
     * @param  mixed  $value
     * @param  string  $compare
     * @return $this
     */
    public function orWhere($column, $compare, $value){

        if(empty($this->where)){
            $this->operator = ' WHERE ';
        }else {
            $this->operator = ' OR ';
        }
        $this->where .= "$this->operator $column $compare '$value'";
        return $this;
    }

    /**
     * Add an "where like" clause to the query.
     *
     * @param  string|array  $column
     * @param  mixed  $value
     * @return $this
     */
    public function whereLike($column, $value){

        if(empty($this->where)){
            $this->operator = ' WHERE ';
        }else {
            $this->operator = ' AND ';
        }
        $this->where .= "$this->operator $column LIKE '%$value%'";
        return $this;
    }
    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($column = '*'){

        $this->selectColumn = $column;
        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param  int  $number
     * @param  int  $offset
     * @return $this
     */
    public function limit($number, $offset = 0){
        
        $this->limit = "LIMIT $offset, $number";
        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc'){

        $arrColumns = array_filter(explode(',', $column));
        if(!empty($arrColumns) && count($arrColumns) >= 2 ){

            $this->orderBy = "ORDER BY". implode(', ', $arrColumns);
        }else {

            $this->orderBy = "ORDER BY". $column." ".$direction;
        }
        return $this;
    }
    /**
     * Add an "order by" clause for a timestamp to the query.
     * 
     * @param  string  $column
     * @return $this
     */
    public function latest($column = 'id')
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function oldest($column = 'id')
    {
        return $this->orderBy($column, 'asc');
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @return array
     */
    public function get($column = '*'){

        $db = static::getDB();
        $this->selectColumn = $column;
        $sqlQuery = "SELECT $this->selectColumn FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit";
        $sqlQuery = trim($sqlQuery);
        $query = $db->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if(!empty($query)){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Execute a query for a all record.
     *
     * @return array
     */
    public function all(){

        $db = static::getDB();
        $sqlQuery = "SELECT * FROM $this->tableName";
        $query = $db->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if(!empty($query)){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param  int|string  $id
     * @param  array  $column
     * @return mixed|static
     */
    public function find($id, $column = '*'){
    
        return $this->where('id', '=', $id)->first($column);
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  array|string  $column
     * @return object|static|null
     */
    public function first($column = '*'){
    
        $db = static::getDB();
        $this->selectColumn = $column;
        $sqlQuery = "SELECT $this->selectColumn FROM $this->tableName $this->where";
        $query = $db->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if(!empty($query)){
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function resetQuery(){
    
        $this->tableName = '';
        $this->where = '';
        $this->operator = '';
        $this->selectColumn = '*';
        $this->limit = '';
        $this->orderBy = '';
        $this->innerJoin = '';
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $column
     * @param  string  $tableName
     * @return $this
     */
    public function join($tableName, $relationship){

        $this->innerJoin = "INNER JOIN" .$tableName. " ON " .$relationship." ";
        return $this;
    }
    
    /**
     * Execute the insert query .
     *
     * @param  array|mixed  $data
     * @return boolean
     */
    public function insert($data){
        
        $db = static::getDB();
        $tableName = $this->_table;

        if(!empty($data)){
            $columnStr = '';
            $valueStr = '';
            foreach($data as $key => $value){
                $columnStr.= $key.',';
                $valueStr.= "'".$value."',";
            }
            $columnStr = rtrim($columnStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sqlQuery = "INSERT INTO $tableName ($columnStr) VALUES ($valueStr)";
            $query = $db->query($sqlQuery);

            if($query){
                return true;
            }
        }
        
        return false;
    }

    /**
     * Execute the update query .
     *
     * @param  array|mixed  $data
     * @param  array|mixed  $conditions
     * @return boolean
     */
    public function update($data , $conditions = ''){
        
        $db = static::getDB();
        $tableName = $this->_table;

        if(!empty($data)){
            $updateStr = '';
            foreach($data as $key => $value){
                $updateStr.= "$key = '$value',";
            }
            $updateStr = rtrim($updateStr, ',');
            
            if(!empty($conditions)){
                $sqlQuery = "UPDATE $tableName SET $updateStr WHERE $conditions";
            }else {
                $sqlQuery = "UPDATE $tableName SET $updateStr ";
            }

            $query = $db->query($sqlQuery);

            if($query){
                return true;
            }
        }
        
        return false;
    }

    /**
     * Execute the destroy query .
     *
     * @param  array|mixed  $conditions
     * @return boolean
     */
    public function destroy($conditions){
        
        $db = static::getDB();
        $tableName = $this->_table;

        $sqlQuery = "DELETE FROM $tableName WHERE $conditions";

        $query = $db->query($sqlQuery);

        if($query){
            return true;
        }else {
            return false;
        }
    }

     /**
     * Execute the delete query (delete table).
     *
     * @return boolean
     */
    public function delete(){
        
        $db = static::getDB();
        $tableName = $this->_table;

        $sqlQuery = "DELETE FROM $tableName";

        $query = $db->query($sqlQuery);

        if($query){
            return true;
        }else {
            return false;
        }
    }
}

