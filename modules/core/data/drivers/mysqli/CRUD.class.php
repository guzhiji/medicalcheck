<?php

//TODO BatchCRUD
/**
 * @version 0.3.20130105
 * @author Zhiji Gu <gu_zhiji@163.com>
 * @copyright 2012-2013 InterBox Core 2.0 for PHP, GuZhiji Studio
 * @package interbox.core.data.drivers.mysqli
 */
class CRUD extends Command {

    private $table;
    private $tablename;
    private $validator;

    function __construct($service_name, $table_name) {
        parent::__construct($service_name);
        $srv = ibc2_dataservice_info($service_name);
        if (!array_keys_exist_recursive($GLOBALS, array(
                    'IBC2_DATA_TABLES',
                    $srv['server'],
                    $srv['database'],
                    $table_name
                ))
        )
            throw new NotDefinedException("Table '$table_name' is not defined.");
        $this->table = $GLOBALS['IBC2_DATA_TABLES'][$srv['server']][$srv['database']][$table_name];
        $this->tablename = $table_name;
        ibc2_load_class('Validator', 'util');
        $this->validator = new Validator($this->table);
    }

    private function getDataType($field) {
        switch ($this->table[$field]['datatype']) {
            case IBC2_DATA_TYPE_INT:
            case IBC2_DATA_TYPE_BOOL:
                return 'i';
            case IBC2_DATA_TYPE_DECIMAL:
                return 'd';
            case IBC2_DATA_TYPE_TEXT:
                return 's'; //TODO datetime
            default:
                return NULL;
        }
    }

    public function create(array $values) {

        $placeholders = array();
        $fields = array();
        $types = '';
        $params = array(&$types);
        foreach ($values as $field => &$value) {
            // if field does not exist
            if (!isset($this->table[$field]))
                throw new NotDefinedException("Field '$field' is not defined.");

            // filter
            $value = ibc2_datafield_filter($this->table, $field, $value);

            // if value isn't valid
//            if (!ibc2_datafield_validate($this->table, $field, $value))
//                throw new Exception();
            if (!$this->validator->validate($field, $value))
                throw new InvalidValueException($this->validator);

            // determine data type
            $type = $this->getDataType($field);
            if ($type === NULL)
                throw new NotDefinedException("Data type of the field '$field' is not defined.");
            $types.=$type;

            $params[] = &$value;
            $fields[] = $field;
            $placeholders[] = '?';
        }
//TODO check required fields
//
        // execute
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO ' . $this->tablename . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $placeholders) . ')');
        call_user_func_array(array($stmt, 'bind_param'), $params);
        $r = $stmt->execute();
        $stmt->close();

        // return
        if ($r)
            return $mysqli->insert_id;
        else
            return 0;
    }

    public function read($id, array $fields = NULL) {

        // find the primary key
        $pk = ibc2_datatable_primarykey($this->table);
        if (empty($pk))
            throw new NotDefinedException("A primary key is not defined for the table '{$this->tablename}'.");

        // determine data type
        $type = $this->getDataType($pk);
        if ($type === NULL)
            throw new NotDefinedException("Data type of the field '$pk' is not defined.");

        if (empty($fields))
            $fields = array_keys($this->table);
        $data = array();
        $result = array();
        foreach ($fields as $field) {
            $data[$field] = NULL;
            $result[] = &$data[$field];
        }

        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT ' . implode(',', $fields) . " FROM {$this->tablename} WHERE {$pk}=?");
        $stmt->bind_param($type, $id);
        call_user_func_array(array($stmt, 'bind_result'), $result);
        $stmt->execute();
        $r = $stmt->fetch();
        $stmt->close();

        if ($r)
            return $data;
        return NULL;
    }

    public function update($id, array $values) {

        // find the primary key
        $pk = ibc2_datatable_primarykey($this->table);
        if (empty($pk))
            throw new NotDefinedException("A primary key is not defined for the table '{$this->tablename}'.");

        // determine data type
        $pktype = $this->getDataType($pk);
        if ($pktype === NULL)
            throw new NotDefinedException("Data type of the field '$pk' is not defined.");

        $types = '';
        $params = array(&$types);
        foreach ($values as $field => &$value) {
            // if field does not exist
            if (!isset($this->table[$field]))
                throw new NotDefinedException("Field '$field' is not defined.");

            // filter
            $value = ibc2_datafield_filter($this->table, $field, $value);

            // if value isn't valid
//            if (!ibc2_datafield_validate($this->table, $field, $value))
//                throw new Exception();
            if (!$this->validator->validate($field, $value))
                throw new InvalidValueException($this->validator);

            // determine data type
            $type = $this->getDataType($field);
            if ($type === NULL)
                throw new NotDefinedException("Data type of the field '$field' is not defined.");
            $types.=$type;

            $params[] = &$value;
            $fields[] = $field . '=?';
        }

        // execute
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE ' . $this->tablename . ' SET ' . implode(',', $fields) . " WHERE $pk=?");
        $types.=$pktype;
        $params[] = &$id;
        call_user_func_array(array($stmt, 'bind_param'), $params);
        $stmt->execute();
        $affected = $mysqli->affected_rows;
        $stmt->close();

        return $affected > 0;
    }

    public function delete($id) {

        // find the primary key
        $pk = ibc2_datatable_primarykey($this->table);
        if (empty($pk))
            throw new NotDefinedException("A primary key is not defined for the table '{$this->tablename}'.");

        // determine data type
        $type = $this->getDataType($pk);
        if ($type === NULL)
            throw new NotDefinedException("Data type of the field '$pk' is not defined.");

        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare("DELETE FROM {$this->tablename} WHERE {$pk}=?");
        $stmt->bind_param($type, $id);
        $stmt->execute();
        $affected = $mysqli->affected_rows;
        $stmt->close();

        return $affected > 0;
    }

    public function clearErrors() {
        $this->validator->clearErrors();
    }

    public function getErrors() {
        //TODO other errors
        return $this->validator->getErrors();
    }

    public function errorExists() {
        return $this->validator->errorExists();
    }

}