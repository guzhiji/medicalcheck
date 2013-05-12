<?php

/**
 * A part of the data service builder for the MySQL Improved client.
 * 
 */
ibc2_load_lib('builder', 'data');

function ibc2_dataservice_createtable($service_name, $table) {
    $srv = ibc2_dataservice_info($service_name);
    $server = $srv['server'];
    $database = $srv['database'];
    if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_TABLES', $server, $database, $table)))
        throw new Exception();
    $tinfo = $GLOBALS['IBC2_DATA_TABLES'][$server][$database][$table];

    $t = new IBC2_Data_Table($table);
    foreach ($tinfo as $field => $finfo) {
        $datatype = $finfo['datatype'];
        $length = $finfo['length'];
        $isnull = $finfo['isnull'];
        $default = isset($finfo['default']) ? $finfo['default'] : NULL;
        $t->addField($field, $datatype, $length, $isnull, $default);
        if (isset($finfo['keytype'])) {
            $keytype = $finfo['keytype'];
            $keyname = isset($finfo['keyname']) ? $finfo['keyname'] : 'key_' . $table;
            $ref = isset($finfo['reference']) ? $finfo['reference'] : NULL;
            $t->addKey($field, $keytype, $keyname, $ref);
        }
    }
    $mysqli = ibc2_dataservice_conn($service_name);
    return $mysqli->real_query($t->getSQL() . ' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');
}

function ibc2_datatable_create(mysqli $mysqli, $table, array $tinfo) {
    $t = new IBC2_Data_Table($table);
    foreach ($tinfo as $field => $finfo) {
        $datatype = $finfo['datatype'];
        $length = $finfo['length'];
        $isnull = $finfo['isnull'];
        $default = isset($finfo['default']) ? $finfo['default'] : NULL;
        $t->addField($field, $datatype, $length, $isnull, $default);
        if (isset($finfo['keytype'])) {
            $keytype = $finfo['keytype'];
            $keyname = isset($finfo['keyname']) ? $finfo['keyname'] : 'key_' . $table;
            $ref = isset($finfo['reference']) ? $finfo['reference'] : NULL;
            $t->addKey($field, $keytype, $keyname, $ref);
        }
    }
    echo $t->getSQL() . ";\n";
    return $mysqli->real_query($t->getSQL() . ' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');
}

/**
 * Create all configured tables.
 * 
 * @throws Exception 
 */
function ibc2_dataservice_install() {
    // generate IBC2_DATA_TABLES
    ibc2_datatable_gen();
    if (!isset($GLOBALS['IBC2_DATA_TABLES']))
        throw new Exception();
    // create tables
    foreach ($GLOBALS['IBC2_DATA_TABLES'] as $server => $databases) {
        foreach ($databases as $dbname => $database) {
            $database = ibc2_datatable_sort($database);
            $mysqli = ibc2_dbserver_conn($server, $dbname);
            foreach ($database as $table => $tinfo) {
                echo $table . (ibc2_datatable_create($mysqli, $table, $tinfo) ? ":succeed\n" : ":fail\n");
                echo $mysqli->error;
                echo "\n\n";
            }
            $mysqli->close();
        }
    }
    // write IBC2_DATA_TABLES
    ibc2_datatable_cache();
}