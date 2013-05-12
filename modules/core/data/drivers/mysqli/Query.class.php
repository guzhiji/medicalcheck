<?php

class Query extends Command {

    private $stmt;
    private $fields;

    function __construct($service_name) {
        parent::__construct($service_name);
    }

    public function query($query, array $params = array()) {
        $this->stmt = $this->mysqli->prepare($query);
        $stmt = &$this->stmt;
        if (!empty($stmt)) {
            $types = '';
            $plist = array(&$types);
            $c = count($params);
            for ($i = 0; $i < $c; $i++) {
                $p = &$params[$i];
                if (is_string($p))
                    $types.='s';
                else if (is_int($p))
                    $types.='i';
                else if (is_float($p))
                    $types.='d';
                $plist[] = &$p;
            }
            call_user_func_array(array($stmt, 'bind_param'), $plist);
            $stmt->execute();
            $this->fields = array();
            $rlist = array();
            $result = $stmt->result_metadata();
            while ($field = $result->fetch_field()) {
                $this->fields[$field->name] = NULL;
                $rlist[] = &$this->fields[$field->name];
            }
            $result->close();
            call_user_func_array(array($stmt, 'bind_result'), $rlist);
        }
    }

    public function fetch() {
        if (empty($this->stmt))
            return NULL;
        if ($this->stmt->fetch())
            return $this->fields;
        return NULL;
    }

    public function close() {
        if (!empty($this->stmt))
            $this->stmt->close();
    }

    function __destruct() {
        $this->close();
        parent::__destruct();
    }

}