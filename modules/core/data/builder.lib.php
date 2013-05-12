<?php

/**
 * The generic part of the data service builder.
 *  
 */

/**
 * A helper class to generate SQL for creating a data table.
 */
class IBC2_Data_Table {

    private $tablename;
    private $fields;
    private $indices;

    function __construct($table) {
        $this->tablename = $table;
        $this->fields = array();
        $this->indices = array();
    }

    public function addField($fieldname, $datatype, $length, $isnull, $default) {
        $this->fields[] = "`$fieldname` " .
                $this->getDataType($datatype, $length) . ' ' .
                (!$isnull ? 'NOT ' : '') . 'NULL' .
                $this->getDefault($default);
    }

    private function getDataType($datatype, $length) {
        switch ($datatype) {
            case IBC2_DATA_TYPE_INT:
                switch ($length) {
                    case IBC2_DATA_LEN_INT_SHORT:
                        return 'TINYINT';
                    case IBC2_DATA_LEN_INT_LONG:
                    default:
                        return 'INT';
                }
            case IBC2_DATA_TYPE_DECIMAL:
                return 'FLOAT(...)'; // TODO decimal/real numbers
            case IBC2_DATA_TYPE_BOOL:
                return 'TINYINT(1)';
            case IBC2_DATA_TYPE_DATETIME:
                return 'TIMESTAMP';
            case IBC2_DATA_TYPE_TEXT:
            default:
                switch ($length) {
                    case IBC2_DATA_LEN_TEXT_SHORT:
                        return 'CHAR(5)';
                    case IBC2_DATA_LEN_TEXT_LONG:
                        return 'TEXT';
                    case IBC2_DATA_LEN_TEXT_MEDIUM:
                    default:
                        return 'VARCHAR(255)';
                }
        }
    }

    private function getDefault($default) {
        if (empty($default))
            return '';
        switch ($default[0]) {
            case IBC2_DATA_DEFAULT_ID:
                return ' AUTO_INCREMENT';
            case IBC2_DATA_DEFAULT_NOW:
                return ' DEFAULT CURRENT_TIMESTAMP';
            case IBC2_DATA_DEFAULT_VALUE:
            default:
                if (is_null($default[1]))
                    return ' DEFAULT NULL';
                else if (is_string($default[1])) //TODO real escape
                    return " DEFAULT '{$default[1]}'";
                else
                    return " DEFAULT {$default[1]}";
        }
    }

    public function addKey($fieldname, $keytype, $keyname, $ref) {
        switch ($keytype) {
            case IBC2_DATA_KEY_PRIMARY:
                $this->fields[] = "PRIMARY KEY (`$fieldname`)";
                break;
            case IBC2_DATA_KEY_FOREIGN:
                $this->addForeignKey($fieldname, $ref);
                break;
            case IBC2_DATA_KEY_DEFAULT:
            default:
                $this->addKey_($keyname, $fieldname);
                break;
        }
    }

    private function addKey_($keyname, $fieldname) {
        $i = 1;
        $k = $keyname;
        while (isset($this->indices[$k])) {
            $i++;
            $k = $keyname . $i;
        }
        $this->indices[$k] = TRUE;
        $this->fields[] = "INDEX `$k` (`$fieldname`)";
        return $k;
    }

    private function getDependency($d) {
        switch ($d) {
            case IBC2_DATA_DEPENDENCY_CASCADE:
                return 'CASCADE';
            case IBC2_DATA_DEPENDENCY_RESTRICT:
                return 'RESTRICT';
            case IBC2_DATA_DEPENDENCY_NOACTION:
            default:
                return 'NO ACTION';
        }
    }

    private function addForeignKey($fieldname, $ref) {
        $keyname = $this->addKey_("fk_{$this->tablename}_{$ref[0]}", $fieldname);
        $onupd = 'ON UPDATE ' . $this->getDependency(isset($ref[2]) ? $ref[2] : IBC2_DATA_DEPENDENCY_NOACTION);
        $ondel = 'ON DELETE ' . $this->getDependency(isset($ref[3]) ? $ref[3] : IBC2_DATA_DEPENDENCY_NOACTION);
        $this->fields[] = "CONSTRAINT `$keyname` FOREIGN KEY (`$fieldname`) REFERENCES `{$ref[0]}` (`{$ref[1]}`) $onupd $ondel ";
    }

    public function getSQL() {
        return "CREATE TABLE IF NOT EXISTS `{$this->tablename}` (" . implode(',', $this->fields) . ')';
    }

}

function ibc2_dataservice_update_ref_table(array &$model, $old, $new) {
    foreach ($model as &$tinfo) {
        foreach ($tinfo as &$finfo) {
            if (!isset($finfo['reference']))
                continue;
            if ($finfo['reference'][0] == $old)
                $finfo['reference'][0] = $new;
        }
    }
}

function ibc2_dataservice_update_ref_field(array &$model, $tablename, $old, $new) {
    foreach ($model as &$tinfo) {
        foreach ($tinfo as &$finfo) {
            if (!isset($finfo['reference']))
                continue;
            if ($finfo['reference'][0] == $tablename &&
                    $finfo['reference'][1] == $old)
                $finfo['reference'][1] = $new;
        }
    }
}

function ibc2_dataservice_apply_alias(array &$model, array $alias) {
    foreach ($alias as $otable => $changes) {
        if (isset($model[$otable])) { // original name valid 
            // change field names
            if (isset($changes['fields'])) {
                foreach ($changes['fields'] as $ofield => $nfield) {
                    if (isset($model[$otable][$ofield]) && // original name valid
                            !isset($model[$otable][$nfield]) // not occupied
                    ) {
                        $finfo = $model[$otable][$ofield];
                        unset($model[$otable][$ofield]);
                        $model[$otable][$nfield] = $finfo;
                        ibc2_dataservice_update_ref_field($model, $otable, $ofield, $nfield);
                    }
                }
            }
            // change table name
            if (isset($changes['table']) && // got new table name 
                    !isset($model[$changes['table']]) // not occupied
            ) {
                $tinfo = $model[$otable];
                unset($model[$otable]);
                $model[$changes['table']] = $tinfo;
                ibc2_dataservice_update_ref_table($model, $otable, $changes['table']);
            }
        }
    }
}

function ibc2_dataservice_apply_extra(array &$model, array $extra) {
    foreach ($extra as $table => $tinfo) {
        if (!isset($model[$table])) {
            // insert table
            $model[$table] = $tinfo;
        } else {
            foreach ($tinfo as $field => $finfo) {
                if (!isset($model[$table][$field])) {
                    // insert field
                    $model[$table][$field] = $finfo;
                } else if (!isset($model[$table][$field]['reference']) &&
                        isset($finfo['reference'])) {
                    // insert reference of a field
                    $model[$table][$field]['reference'] = $finfo['reference'];
                }
            }
        }
    }
}

function ibc2_datatable_sort(array $database) {
    $sq = array();
    while (count($database) > count($sq)) {
        $found = FALSE;
        foreach ($database as $tname => $table) {
            if (!isset($sq[$tname]) &&
                    ibc2_datatable_refexists($database, $table, $tname)) {
                $sq[$tname] = $table;
                $found = TRUE;
            }
        }
        if (!$found)
            throw new Exception('looping');
    }
    return $sq;
}

/**
 * 
 * <code>
 * $GLOBALS['IBC2_DATA_TABLES'] = array(
 *     'server name' => array(
 *         'database name' => array(
 *             'data table name'=>array(...),
 *             ...
 *         )
 *     )
 * );
 * </code>
 */
function ibc2_datatable_gen() {
    if (!isset($GLOBALS['IBC2_DATA_SERVICES']))
        return;
    $GLOBALS['IBC2_DATA_TABLES'] = array();
    foreach ($GLOBALS['IBC2_DATA_SERVICES'] as $srv) {
        // model not found
        if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_MODELS', $srv['model'])))
            continue;
        // load the model of a data service
        $model = $GLOBALS['IBC2_DATA_MODELS'][$srv['model']];
        // change names
        if (isset($srv['alias']))
            ibc2_dataservice_apply_alias($model, $srv['alias']);
        // insert extra
        if (isset($srv['extra']))
            ibc2_dataservice_apply_extra($model, $srv['extra']);
        // prepare database
        if (!array_keys_exist_recursive($GLOBALS, array('IBC2_DATA_TABLES', $srv['server'], $srv['database'])))
            $GLOBALS['IBC2_DATA_TABLES'][$srv['server']][$srv['database']] = array();
        // merge into IBC2_DATA_TABLES
        ibc2_dataservice_apply_extra($GLOBALS['IBC2_DATA_TABLES'][$srv['server']][$srv['database']], $model);
    }
}

//function ibc2_datatable_cache() {
//    if (!isset($GLOBALS['IBC2_DATA_TABLES']))
//        throw new Exception();
//    file_put_contents(formatpath(dirname(__FILE__)) . 'tables.conf.php', "<?php\n\$GLOBALS['IBC2_DATA_TABLES']='" . str_replace('\'', '\\\'', serialize($GLOBALS['IBC2_DATA_TABLES'])) . '\';');
//}

function ibc2_datatable_cache() {
    if (!isset($GLOBALS['IBC2_DATA_TABLES']))
        throw new Exception();
    file_put_contents(formatpath(dirname(__FILE__)) . 'tables.cache.php', "<?php\n\$GLOBALS['IBC2_DATA_TABLES']=" . var_export($GLOBALS['IBC2_DATA_TABLES'], TRUE) . ';');
}