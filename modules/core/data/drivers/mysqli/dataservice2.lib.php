<?php

/**
 * The data service library for the MySQL Improved client.
 * 
 * @author Zhiji Gu <gu_zhiji@163.com>
 * @copyright 2012-2013 InterBox Core 2.0 for PHP, GuZhiji Studio
 * @package interbox.core.data.drivers.mysqli
 */
ibc2_load_lib('dataservice2', 'data');

//-------------------------------------------------------------------
// database servers
// ibc2_dbserver_*
//-------------------------------------------------------------------

function ibc2_dbserver_conn($server, $database) {
    $db = ibc2_dbserver_info($server);
    if ($db['driver'] != 'mysqli')
        throw new Exception();
    return new mysqli($db['host'], $db['user'], $db['pwd'], $database, $db['port']);
}

//-------------------------------------------------------------------
// database services
// ibc2_dataservice_*
//-------------------------------------------------------------------
function ibc2_dataservice_conn($service_name) {
    $srv = ibc2_dataservice_info($service_name);
    if ($srv === NULL)
        throw new Exception();
    $db = ibc2_dbserver_info($srv['server']);
    if ($db['driver'] != 'mysqli')
        throw new Exception();
    if (array_keys_exist_recursive($GLOBALS, array('IBC2_DB_CONNECTIONS', $service_name)))
        return $GLOBALS['IBC2_DB_CONNECTIONS'][$service_name];
    $GLOBALS['IBC2_DB_CONNECTIONS'][$service_name] = NULL;
    $conn = &$GLOBALS['IBC2_DB_CONNECTIONS'][$service_name];
    $conn = new mysqli($db['host'], $db['user'], $db['pwd'], $srv['database'], $db['port']);
    return $conn;
}

function ibc2_dataservice_disconn($service_name = NULL) {
    if (isset($GLOBALS['IBC2_DB_CONNECTIONS'])) {
        if ($service_name == NULL) {
            foreach ($GLOBALS['IBC2_DB_CONNECTIONS'] as $service => $conn) {
                $conn->close();
                unset($GLOBALS['IBC2_DB_CONNECTIONS'][$service]);
            }
        } else if (isset($GLOBALS['IBC2_DB_CONNECTIONS'][$service_name])) {
            $GLOBALS['IBC2_DB_CONNECTIONS'][$service_name]->close();
            unset($GLOBALS['IBC2_DB_CONNECTIONS'][$service_name]);
        }
    }
}

class Command {

    protected $mysqli;

    function __construct($service_name) {
        $this->mysqli = ibc2_dataservice_conn($service_name);
    }

//    function __destruct() {
//        if (!empty($this->mysqli))
//            $this->mysqli->close();
//    }

    public function execute($sql) {
        return $this->mysqli->real_query($sql);
    }

}