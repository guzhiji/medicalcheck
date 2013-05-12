<?php

$GLOBALS['IBC2_DB_DRIVERS'] = array(
    'mysqli' => array(
        'servicemanager' => array('ServiceManager', 'data.drivers.mysqli'),
        'query' => array('Query', 'data.drivers.mysqli'),
        'crud' => array('CRUD', 'data.drivers.mysqli')
    )
);

$GLOBALS['IBC2_DATA_MODELS']['medicalcheck'] = array(//model name
    'xiangzhen' => array(
        'id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_PRIMARY,
            'default' => array(IBC2_DATA_DEFAULT_ID, NULL),
            'filter' => 'intval'
        ),
        'x_name' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_MEDIUM,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_DEFAULT,
            'len_min' => 1,
            'len_max' => 10
        )
    ),
    'degree' => array(
        'id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_PRIMARY,
            'default' => array(IBC2_DATA_DEFAULT_ID, NULL),
            'filter' => 'intval'
        ),
        'd_name' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_MEDIUM,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_DEFAULT,
            'len_min' => 1,
            'len_max' => 10
        )
    ),
    'person' => array(//table name
        'id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_PRIMARY,
            'default' => array(IBC2_DATA_DEFAULT_ID, NULL),
            'filter' => 'intval'
        ),
        'xiangzhen_id' => array(
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => TRUE,
            'keytype' => IBC2_DATA_KEY_FOREIGN,
            'reference' => array(
                'xiangzhen',
                'id',
                IBC2_DATA_DEPENDENCY_RESTRICT,
                IBC2_DATA_DEPENDENCY_RESTRICT
            )
        ),
        'degree_id' => array(
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => TRUE,
            'keytype' => IBC2_DATA_KEY_FOREIGN,
            'reference' => array(
                'degree',
                'id',
                IBC2_DATA_DEPENDENCY_RESTRICT,
                IBC2_DATA_DEPENDENCY_RESTRICT
            )
        ),
        'p_name' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_MEDIUM,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_DEFAULT,
            'len_min' => 2,
            'len_max' => 10
        ),
        'p_pass' => array(
            'datatype' => IBC2_DATA_TYPE_BOOL,
            'length' => IBC2_DATA_LEN_INT_SHORT,
            'isnull' => FALSE,
            'default' => array(IBC2_DATA_DEFAULT_VALUE, 0)
        ),
        'p_note' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_LONG,
            'isnull' => TRUE
        )
    ),
    'section' => array(//table name
        'id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_PRIMARY,
            'default' => array(IBC2_DATA_DEFAULT_ID, NULL),
            'filter' => 'intval'
        ),
        's_name' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_MEDIUM,
            'isnull' => FALSE,
            'len_min' => 1,
            'len_max' => 255
        )
    ),
    'status' => array(//table name
        'id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_PRIMARY,
            'default' => array(IBC2_DATA_DEFAULT_ID, NULL),
            'filter' => 'intval'
        ),
        'section_id' => array(
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_FOREIGN,
            'reference' => array(
                'section',
                'id',
                IBC2_DATA_DEPENDENCY_RESTRICT,
                IBC2_DATA_DEPENDENCY_RESTRICT
            )
        ),
        's_text' => array(
            'datatype' => IBC2_DATA_TYPE_TEXT,
            'length' => IBC2_DATA_LEN_TEXT_MEDIUM,
            'isnull' => FALSE,
            'len_min' => 1,
            'len_max' => 255
        )
    ),
    'result' => array(//table name
        'status_id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_FOREIGN,
            'reference' => array(
                'status',
                'id',
                IBC2_DATA_DEPENDENCY_RESTRICT,
                IBC2_DATA_DEPENDENCY_RESTRICT
            )
        ),
        'person_id' => array(//field name
            'datatype' => IBC2_DATA_TYPE_INT,
            'length' => IBC2_DATA_LEN_INT_LONG,
            'isnull' => FALSE,
            'keytype' => IBC2_DATA_KEY_FOREIGN,
            'reference' => array(
                'person',
                'id',
                IBC2_DATA_DEPENDENCY_RESTRICT,
                IBC2_DATA_DEPENDENCY_CASCADE
            )
        )
    )
);
