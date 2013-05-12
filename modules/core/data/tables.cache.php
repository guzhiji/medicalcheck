<?php
$GLOBALS['IBC2_DATA_TABLES']=array (
  'main' => 
  array (
    'medicalcheck_test' => 
    array (
      'xiangzhen' => 
      array (
        'id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 1,
          'default' => 
          array (
            0 => 0,
            1 => NULL,
          ),
          'filter' => 'intval',
        ),
        'x_name' => 
        array (
          'datatype' => 3,
          'length' => 1,
          'isnull' => false,
          'keytype' => 0,
          'len_min' => 1,
          'len_max' => 10,
        ),
      ),
      'degree' => 
      array (
        'id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 1,
          'default' => 
          array (
            0 => 0,
            1 => NULL,
          ),
          'filter' => 'intval',
        ),
        'd_name' => 
        array (
          'datatype' => 3,
          'length' => 1,
          'isnull' => false,
          'keytype' => 0,
          'len_min' => 1,
          'len_max' => 10,
        ),
      ),
      'person' => 
      array (
        'id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 1,
          'default' => 
          array (
            0 => 0,
            1 => NULL,
          ),
          'filter' => 'intval',
        ),
        'xiangzhen_id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => true,
          'keytype' => 2,
          'reference' => 
          array (
            0 => 'xiangzhen',
            1 => 'id',
            2 => 2,
            3 => 2,
          ),
        ),
        'degree_id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => true,
          'keytype' => 2,
          'reference' => 
          array (
            0 => 'degree',
            1 => 'id',
            2 => 2,
            3 => 2,
          ),
        ),
        'p_name' => 
        array (
          'datatype' => 3,
          'length' => 1,
          'isnull' => false,
          'keytype' => 0,
          'len_min' => 2,
          'len_max' => 10,
        ),
        'p_pass' => 
        array (
          'datatype' => 2,
          'length' => 1,
          'isnull' => false,
          'default' => 
          array (
            0 => 2,
            1 => 0,
          ),
        ),
        'p_note' => 
        array (
          'datatype' => 3,
          'length' => 0,
          'isnull' => true,
        ),
      ),
      'section' => 
      array (
        'id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 1,
          'default' => 
          array (
            0 => 0,
            1 => NULL,
          ),
          'filter' => 'intval',
        ),
        's_name' => 
        array (
          'datatype' => 3,
          'length' => 1,
          'isnull' => false,
          'len_min' => 1,
          'len_max' => 255,
        ),
      ),
      'status' => 
      array (
        'id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 1,
          'default' => 
          array (
            0 => 0,
            1 => NULL,
          ),
          'filter' => 'intval',
        ),
        'section_id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 2,
          'reference' => 
          array (
            0 => 'section',
            1 => 'id',
            2 => 2,
            3 => 2,
          ),
        ),
        's_text' => 
        array (
          'datatype' => 3,
          'length' => 1,
          'isnull' => false,
          'len_min' => 1,
          'len_max' => 255,
        ),
      ),
      'result' => 
      array (
        'status_id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 2,
          'reference' => 
          array (
            0 => 'status',
            1 => 'id',
            2 => 2,
            3 => 2,
          ),
        ),
        'person_id' => 
        array (
          'datatype' => 0,
          'length' => 0,
          'isnull' => false,
          'keytype' => 2,
          'reference' => 
          array (
            0 => 'person',
            1 => 'id',
            2 => 2,
            3 => 1,
          ),
        ),
      ),
    ),
  ),
);