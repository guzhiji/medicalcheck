<?php

class SetupDB extends ProcessModel {

    public function Process() {

        $service = ibc2_dataservice_info(MEDICALCHECK_SERVICE);
        $s = ibc2_dbserver_info($service['server']);

        $mysqli = new mysqli($s['host'], $s['user'], $s['pwd'], NULL, $s['port']);
        if ($mysqli->query('CREATE DATABASE IF NOT EXISTS medicalcheck_' . MEDICALCHECK_SERVICE)) {

            LoadIBC1Lib('builder', 'data.drivers.mysqli');
            ibc2_dataservice_install();

            $this->Output('MsgBox', array(
                'title' => '配置数据库',
                'msg' => '完成',
                'url' => './'
            ));
        } else {
            $this->Output('MsgBox', array(
                'title' => '配置数据库',
                'msg' => '失败',
                'url' => 'setup.php'
            ));
        }
        $mysqli->close();

        return TRUE;
    }

}