<?php

require 'core/core1.lib.php';

ibc2_load_lib('dataservice2', 'data.drivers.mysqli');

ibc2_load_file('tables.cache.php', 'data');
ibc2_load_config('builtin', 'data');
ibc2_load_config('servers', 'data');
ibc2_load_config('service', 'data');
ibc2_load_config(MEDICALCHECK_SERVICE, 'data.services');

LoadIBC1Lib('common', 'framework');

define('MEDICALCHECK_PAGESIZE', 20);

function db_start_pos() {
    $page = intval(readParam('get', 'page'));
    if ($page > 0)
        return ($page - 1) * MEDICALCHECK_PAGESIZE;
    return 0;
}

function error_msg($tablename, $errors) {
    $html = '';
    foreach ($errors as $e) {
        $html.='<li>' . GetLangData($tablename . '.' . $e[0]) . GetLangData($e[1]) . '</li>';
    }
    return "<ul>$html</ul>";
}