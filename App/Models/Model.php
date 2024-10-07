<?php 
namespace App\Models;

use mysqli;

class Model{
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $query;
    
    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy;
    protected $offset;
    protected $cant;

    protected $table;

    public function __construct(){
        $this->connection();
    }
    public function connection(){
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if($this->connection->connect_error){
            die('Error de Conexión: ' . $this->connection->connect_error);
        }
        $this->connection->set_charset("utf8");
    }
    public function query($sql, $data = [], $params = null){

        if ($data) {

            if ($params == null) {
                $params = str_repeat('s', count($data));
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($params , ...$data);
            $stmt->execute();
            $this->query = $stmt->get_result();
        }else {
            $this->query = $this->connection->query($sql);
        }

        return $this;
    }
    public function select(...$columns){
        $aliasedColumns = [];
        foreach ($columns as $column) {
            $parts = explode(' ', $column);
            if (count($parts) === 1) {
                $aliasedColumns[] = $this->table . '.' . $column;
            } else {
                $aliasedColumns[] = "{$parts[0]} AS {$parts[1]}";
            }
        }
        $this->select = implode(', ', $aliasedColumns);
        return $this;
    }

    public function orWhere($column, $operator, $value1, $value2 = null) {
        return $this->where($column, $operator, $value1, $value2, 'OR');
    }
    

    public function where($column, $operator, $value1, $value2 = null, $boolean = 'AND') {
        $condition = '';
        if ($operator == 'BETWEEN' && $value2 !== null) {
            $condition = "$column BETWEEN ? AND ?";
            $this->values[] = $value1;
            $this->values[] = $value2;
        } else {
            $condition = "$column $operator ?";
            $this->values[] = $value1;
        }
        if ($this->where) {
            $this->where .= " $boolean $condition";
        } else {
            $this->where = $condition;
        }

        return $this;
    }
    
    public function count(){
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
    
        if ($this->where) {
            $sql .= " WHERE {$this->where}";
        }
    
        $result = $this->query($sql, $this->values)->first();

        $total = intval($result['total']);

        return $total;
    }

    public function orderBy($column, $order){
        if ($this->orderBy) {
            $this->orderBy .= ", {$column} {$order}";
        } else {

            $this->orderBy = "{$column} {$order}";
        }

        return $this;
    }

    public function first(){
        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " {$this->orderBy}";
            }


            $this->query($sql, $this->values);
        } 
        return $this->query->fetch_assoc();
    }
    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }
    public function get(){
        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";


            if (isset($this->tableJoin)) {
                $sql .= " INNER JOIN {$this->tableJoin} ON {$this->table}.{$this->ownKey} = {$this->tableJoin}.{$this->joinKey}";
            }

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            if (isset($this->limit)) {
                $sql .= " LIMIT {$this->limit}";
            }

            if (isset($this->offset)) {
                $sql .= " OFFSET {$this->offset}";
            }

            // print '<pre>';
            // var_dump( $sql);
            // print '</pre>';
            // die();
            $this->query($sql, $this->values);
        }
        
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }
    public function paginate($cant = 1){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }
            if ($this->orderBy) {
                $sql .= " {$this->orderBy}";
            }
            $sql .= " ORDER BY id DESC LIMIT " . ($page - 1) * $cant . ", $cant ";

            $data = $this->query($sql, $this->values)->get();

        }

        $totalQuery = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($this->where) {
            $totalQuery .= " WHERE {$this->where}";
        }
        $total = $this->query($totalQuery, $this->values)->get();


        $uri = $_SERVER['REQUEST_URI'];
        $queryString = $_SERVER['QUERY_STRING'];
        if (!empty($queryString)) {
            $uri .= '?' . $queryString;
        }
        $uri = trim($uri, '/');

        $last_page = ceil($total[0]['total'] / $cant);

        return [
            'total' => $total[0]['total'],
            'from' => (($page - 1) * $cant) + 1,
            'to' => (($page - 1) * $cant) + count($data),
            'current_page' => $page,
            'last_page' => $last_page,
            'next_page_url' => $page < $last_page ? '/'. $uri . '?page=' . ($page + 1) : null,
            'prev_page_url' => $page > 1 ? '/'. $uri . '?page=' . ($page - 1) : null,
            'data' => $data
        ];

    }
    public function skip($offset){
        $this->offset = $offset;
        return $this;
    }
    
    public function take($limit){
        $this->limit = $limit;
        return $this;
    }
    public function inner_join($tableJoin, $ownKey, $joinKey){

        $this->tableJoin = $tableJoin;
        $this->ownKey = $ownKey;
        $this->joinKey = $joinKey;

        return $this;
    }
    
    public function getWithJoin(){
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";
            $sql .= " INNER JOIN {$this->tableJoin} ON {$this->table}.{$this->ownKey} = {$this->tableJoin}.{$this->joinKey}";
    
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }
    
            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            if (isset($this->limit)) {
                $sql .= " LIMIT {$this->limit}";
            }


            $this->query($sql, $this->values);
        }

        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    public function all(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }
    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        // print '<pre>';
        // var_dump( $sql);
        // print '</pre>';
        // die();
        return $this->query($sql, [$id], 'i')->first();
    }
    public function create($data){
        $columns = array_keys($data);
        $columns = implode(', ', $columns);
        $values = array_values($data);
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (" . str_repeat('?, ', count($values)-1)."?)";
        $this->query($sql, $values);
        $insert_id = $this->connection->insert_id;
        return $this->find($insert_id);
    }
    public function update($id, $data){
        // $fields = [];
        // $values = [];
        // foreach ($data as $key => $value) {
        //     $fields[] = "{$key} = ?";
        //     $values[] = $value; // 
        // }
        // $values[] = $id;
        // $fields = implode(', ', $fields);
        // $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";
        // $this->query($sql, $values);
        // return $this->find($id);

        $fields =[];
        foreach ($data as $key => $value){
            $fields[] = "{$key} = ?"; 
        };
        $fields = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, $values);
        return $this->find($id);
    }
    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id], 'i');
        return "ELIMINADO";
    }

    public function checkEmpleado($data) {
        session_start();
        $sql = "SELECT * FROM {$this->table} AS tabla WHERE email = ?";
        $this->query($sql, [$data['email']], 's');
        $empleado = $this->first();
    
        if ($empleado) {
            $current_time = time();
            $clave_normal_valida = password_verify($data['clave'], $empleado['clave']);
            $clave_recuperacion_valida = password_verify($data['clave'], $empleado['clave_recuperacion']);
            $clave_recuperacion_no_expirada = strtotime($empleado['fecha_expiracion']) > $current_time;
    
            if ($clave_normal_valida || ($clave_recuperacion_valida && $clave_recuperacion_no_expirada)) {
                if ($_SESSION["csrf_token"]) { unset($_SESSION["csrf_token"]); }
                if ($_SESSION["data_admin"]) { unset($_SESSION["data_admin"]); }
                if ($_SESSION["data_initAdmin"]) { unset($_SESSION["data_initAdmin"]); }
                if ($_SESSION["last_activity"]) { unset($_SESSION["last_activity"]); }
                    
                unset($empleado["clave"]);
                unset($empleado["clave_recuperacion"]);
                $_SESSION['data_empleado'] = $empleado;
                $_SESSION['data_initEmpleado'] = true;
                $_SESSION['last_activity'] = $current_time;
                return true;
            }
        }
    
        return false;
    }
}
