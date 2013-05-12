<?php

define('MEDICALCHECK_IMPORT_CONTINUE', 0);
define('MEDICALCHECK_IMPORT_UPLOADERROR', 1);
define('MEDICALCHECK_IMPORT_PROCESSERROR', 2);
define('MEDICALCHECK_IMPORT_FINISHWITHERROR', 3);
define('MEDICALCHECK_IMPORT_FINISH', 4);

class ImportNamesProgress extends ProcessModel {

    public function Process() {

        session_start();
        $filename = 'cache/' . session_id();
        $progress = intval(readParam('session', 'import_progress'));
        if ($progress < 1)
            $progress = 1;
        $suc = TRUE;
        $h = @fopen($filename, 'r');
        if ($h) {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $crud = new CRUD(MEDICALCHECK_SERVICE, 'person');
            LoadIBC1Class('Stopwatch', 'util');
            $stopwatch = new Stopwatch();
            $linenum = 0;
            while (($line = fgets($h)) !== FALSE) {
                $linenum++;
                if ($linenum < $progress)
                    continue;
                $name = trim($line);
                if (empty($name))
                    continue;
                if (!mb_check_encoding($name, 'UTF-8'))
                    $name = mb_convert_encoding($name, 'UTF-8', 'GBK');
                try {
                    if (!$crud->create(array(
                                'p_name' => $name
                            )))
                        $suc = FALSE;
                } catch (Exception $ex) {
                    $suc = FALSE;
                }
                if ($stopwatch->elapsedSeconds() > 2) {
                    $_SESSION['import_progress'] = $linenum + 1;
                    break;
                }
            }
            fclose($h);
            header('Content-Type: application/json');
            if ($suc) {
                if ($line === FALSE) {
                    unlink($filename);
                    unset($_SESSION['import_progress']);
                    echo MEDICALCHECK_IMPORT_FINISH;
                } else {
                    echo MEDICALCHECK_IMPORT_CONTINUE;
                }
            } else {
                if ($line === FALSE) {
                    unlink($filename);
                    unset($_SESSION['import_progress']);
                    echo MEDICALCHECK_IMPORT_FINISHWITHERROR;
                } else {
                    echo MEDICALCHECK_IMPORT_PROCESSERROR;
                }
            }
        } else {
            echo MEDICALCHECK_IMPORT_FINISHWITHERROR;
        }
        exit();
    }

}