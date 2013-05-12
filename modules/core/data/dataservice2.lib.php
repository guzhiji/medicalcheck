<?php

/**
 * The base library for data services.
 * 
 * A data service inherits data structures from its data model with some 
 * minor fixes. It is able to perform standard CRUD operations to its data 
 * and has querying capabilities that are dependent on the underlying database.
 * 
 * @version 0.1.20130105
 * @author Zhiji Gu <gu_zhiji@163.com>
 * @copyright 2012-2013 InterBox Core 2.0 for PHP, GuZhiji Studio
 * @package interbox.core.data
 */
//-------------------------------------------------------------------
//data length
//-------------------------------------------------------------------
define('IBC2_DATA_LEN_INT_LONG', 0); // e.g. INT in mysql
define('IBC2_DATA_LEN_INT_SHORT', 1); // e.g. TINYINT in mysql
define('IBC2_DATA_LEN_TEXT_LONG', 0); // e.g. TEXT in mysql
define('IBC2_DATA_LEN_TEXT_MEDIUM', 1); // e.g. VARCHAR(1024) in mysql
define('IBC2_DATA_LEN_TEXT_SHORT', 2); // e.g. CHAR in mysql
//-------------------------------------------------------------------
//data types
//-------------------------------------------------------------------
define('IBC2_DATA_TYPE_INT', 0); // e.g. INT
define('IBC2_DATA_TYPE_DECIMAL', 1);
define('IBC2_DATA_TYPE_BOOL', 2); // e.g. TINYINT(1)
define('IBC2_DATA_TYPE_TEXT', 3);
define('IBC2_DATA_TYPE_DATETIME', 4); // timestamp
define('IBC2_DATA_TYPE_DATE', 5);
define('IBC2_DATA_TYPE_TIME', 6);
//-------------------------------------------------------------------
//default value types
//-------------------------------------------------------------------
define('IBC2_DATA_DEFAULT_ID', 0); // e.g. AUTO_INCREMENT
define('IBC2_DATA_DEFAULT_NOW', 1); // e.g. CURRENT_TIMESTAMP / NOW, for IBC2_DATA_TYPE_DATETIME
define('IBC2_DATA_DEFAULT_VALUE', 2); // any value specified in the next element
//-------------------------------------------------------------------
//key types
//-------------------------------------------------------------------
define('IBC2_DATA_KEY_DEFAULT', 0);
define('IBC2_DATA_KEY_PRIMARY', 1);
define('IBC2_DATA_KEY_FOREIGN', 2);
define('IBC2_DATA_KEY_UNIQUE', 3);
//-------------------------------------------------------------------
//dependency types
//-------------------------------------------------------------------
define('IBC2_DATA_DEPENDENCY_NOACTION', 0);
define('IBC2_DATA_DEPENDENCY_CASCADE', 1);
define('IBC2_DATA_DEPENDENCY_RESTRICT', 2);

//-------------------------------------------------------------------
// database servers
// ibc2_dbserver_*
//-------------------------------------------------------------------
/**
 * Get information about the server.
 * 
 * @param string $server_name
 * @return array 
 * <code>
 * array(
 *      'driver' => 'mysqli',
 *      'host' => 'localhost',
 *      'port' => 3306,
 *      'user' => 'root',
 *      'pwd' => ''
 * )
 * </code>
 */
function ibc2_dbserver_info($server_name) {
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DB_SERVERS', $server_name)))
        return NULL;
    return $GLOBALS['IBC2_DB_SERVERS'][$server_name];
}

/**
 * Fetch all servers by their names.
 * 
 * @return array 
 */
function ibc2_dbserver_list() {
    if (!isset($GLOBALS['IBC2_DB_SERVERS']))
        return NULL;
    return array_keys($GLOBALS['IBC2_DB_SERVERS']);
}

//-------------------------------------------------------------------
// database drivers
// ibc2_dbdriver_*
//-------------------------------------------------------------------
function ibc2_dbdriver_info($driver_name) {
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DB_DRIVERS', $driver_name)))
        return NULL;
    return $GLOBALS['IBC2_DB_DRIVERS'][$driver_name];
}

function ibc2_dbdriver_list() {
    if (!isset($GLOBALS['IBC2_DB_DRIVERS']))
        return NULL;
    return array_keys($GLOBALS['IBC2_DB_DRIVERS']);
}

//-------------------------------------------------------------------
// data models
// ibc2_datamodel_*
//-------------------------------------------------------------------
function ibc2_datamodel_list() {
    if (!isset($GLOBALS['IBC2_DATA_MODELS']))
        return NULL;
    return array_keys($GLOBALS['IBC2_DATA_MODELS']);
}

function ibc2_datamodel_tables($model) {
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_MODELS', $model)))
        return NULL;
    return array_keys($GLOBALS['IBC2_DATA_MODELS'][$model]);
}

function ibc2_datamodel_info($model) {
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_MODELS', $model)))
        return NULL;
    return $GLOBALS['IBC2_DATA_MODELS'][$model];
}

//-------------------------------------------------------------------
// data services
// ibc2_dataservice_*
//-------------------------------------------------------------------
function ibc2_dataservice_list() {
    if (!isset($GLOBALS['IBC2_DATA_SERVICES']))
        return NULL;
    return array_keys($GLOBALS['IBC2_DATA_SERVICES']);
}

function ibc2_dataservice_info($service_name) {
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_SERVICES', $service_name)))
        return NULL;
    return $GLOBALS['IBC2_DATA_SERVICES'][$service_name];
}

/**
 * Fetch all data tables by name in a data service.
 * 
 * @param string $service_name
 * @return array 
 */
function ibc2_dataservice_tables($service_name) {
    $info = ibc2_dataservice_info($service_name);
    if (empty($info))
        return NULL;
    $tables = ibc2_datamodel_tables($info['model']);
    if (isset($info['alias'])) {
        foreach ($info['alias'] as $table => $tinfo) {
            if (!isset($tinfo['table']))
                continue;
            $i = array_search($table, $tables);
            if ($i !== FALSE)
                $tables[$i] = $tinfo['table'];
        }
    }
    if (isset($info['extra'])) {
        $extra = array_keys($info['extra']);
        $tables = array_merge($tables, $extra);
        $tables = array_unique($tables);
        //foreach($extra as $table)
        //if(!in_array($table, $tables))
        //$tables[]=$table;
    }
    return $tables;
}

//-------------------------------------------------------------------
// data tables
// ibc2_datatable_*
//-------------------------------------------------------------------
function ibc2_datatable_primarykey(array &$table) {
    foreach ($table as $field => $finfo) {
        if (isset($finfo['keytype']) && $finfo['keytype'] == IBC2_DATA_KEY_PRIMARY)
            return $field;
    }
    return NULL;
}

function ibc2_datatable_refexists(array &$database, array &$table, $tablename = '') {
    foreach ($table as $finfo) {
        if (isset($finfo['reference'])) {
            $ref = $finfo['reference'];
            if (!array_keys_exist_recursive($database, array($ref[0], $ref[1])) &&
                    $tablename != $ref[0]) // except that it refers to itself
                return FALSE;
        }
    }
    return TRUE;
}

//-------------------------------------------------------------------
// data fields
// ibc2_datafield_*
//-------------------------------------------------------------------
function ibc2_datafield_validate(array &$table, $fieldname, $value) {
    if (!isset($table[$fieldname]))
        return FALSE;
    if (!isset($table[$fieldname]['validator']))
        return TRUE;
    return call_user_func($table[$fieldname]['validator'], $value);
}

function ibc2_datafield_filter(array &$table, $fieldname, $value) {
    if (!isset($table[$fieldname]))
        return NULL;
    if (!isset($table[$fieldname]['filter']))
        return $value;
    return call_user_func($table[$fieldname]['filter'], $value);
}

class DataService {

    private $driver_;
    private $crud_;
    private $servicename_;

    function __construct($driver) {
        $this->driver_ = $driver;
    }

    public function open($service_name) {
        $this->servicename_ = $service_name;
    }

    public function close() {
        $this->servicename_ = '';
        $this->crud_ = array();
    }

    /**
     * 
     * @param string $table_name
     * @return CRUD
     * @throws Exception
     */
    public function CRUD($table_name) {
        if (!empty($this->servicename_)) {
            if (!isset($this->crud_[$this->servicename_][$table_name])) {
                ibc2_load_class('CRUD', "data.drivers.{$this->driver_}");
                return $this->crud_[$this->servicename_][$table_name] =
                        new CRUD($this->servicename_, $table_name);
            } else {
                return $this->crud_[$this->servicename_][$table_name];
            }
        }
        throw new Exception();
    }

}

class DataObject {

    protected $service_;
    protected $table_;
    protected $id_;
    protected $values_;

    function __construct(DataService $service, $table, $id = NULL) {
        $this->service_ = $service;
        $this->table_ = $table;
        $this->id_ = $id;
    }

    public function getAll() {
        $crud = $this->service_->CRUD($this->table_);
        $this->values_ = $crud->read($this->id_);
        return $this->values_;
    }

    function __get($name) {
        $v = NULL;
        $this->get($name, $v);
        return $v;
    }

    public function get($name, &$value) {
        if (empty($this->values_))
            $this->getAll();

        if (!isset($this->values_[$name]))
            $value = NULL;
        else
            $value = $this->values_[$name];
    }

    function __set($name, $value) {
        $this->set($name, $value);
    }

    public function set($name, $value) {
        $this->values_[$name] = $value;
    }

    public function exists() {
        if (empty($this->id_))
            return FALSE;
        if (empty($this->values_))
            $this->getAll();
        return !empty($this->values_);
    }

    public function save() {
        $crud = $this->service_->CRUD($this->table_);
        if (!empty($this->id_)) {
            return $crud->update($this->id_, $this->values_);
        } else {
            $this->id_ = $crud->create($this->values_);
            return $this->id_ > 0;
        }
    }

    public function delete() {
        $crud = $this->service_->CRUD($this->table_);
        return $crud->delete($this->id_);
    }

}

class NotDefinedException extends Exception {
    
}

class InvalidValueException extends Exception {

    private $validator;

    function __construct($validator, $message = '', $code = 0, $previous = NULL) {
        parent::__construct($message, $code, $previous);
        $this->validator = $validator;
    }

    public function getValidator() {
        return $this->validator;
    }

}

//ibc2_load_config('tables', 'data');
//if (is_string($GLOBALS['IBC2_DATA_TABLES']))
//    $GLOBALS['IBC2_DATA_TABLES'] = unserialize($GLOBALS['IBC2_DATA_TABLES']);
//
//ibc2_load_config('builtin', 'data');
//ibc2_load_config('servers', 'data');
//ibc2_load_config('services', 'data');
