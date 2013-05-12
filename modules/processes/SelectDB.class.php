<?php

class SelectDB extends ProcessModel {

    private function getModulePath() {
        $path = formatpath(dirname(__FILE__));
        $p = strrpos($path, '/', -2);
        return substr($path, 0, $p);
    }

    private function setService($service) {
        file_put_contents($this->getModulePath() . '/core/data/service.conf.php', <<<EOF
<?php
define('MEDICALCHECK_SERVICE', '{$service}');
EOF
        );
        $this->Output('MsgBox', array(
            'title' => '配置数据库',
            'msg' => '请稍候……',
            'content' => '<script>$(function(){$.mobile.changePage("?mode=dialog&function=setup");});</script>',
            'url' => '#'
        ));
    }

    private function createService($service) {
        file_put_contents($this->getModulePath() . "/core/data/services/{$service}.conf.php", <<<EOF
<?php
\$GLOBALS['IBC2_DATA_SERVICES']['{$service}'] = array(// service name
    'server' => 'main',
    'database' => 'medicalcheck_{$service}', // database name
    'model' => 'medicalcheck'
);
EOF
        );
    }

    public function Process() {
        $service = readParam('get|post', 'service');
        if (preg_match('/[0-9a-z]{2,10}/i', $service)) {
            //valid service name
            if (is_file($this->getModulePath() . '/core/data/services/' . $service . '.conf.php')) {
                //valid service
                $this->setService($service);
            } else {
                //new service
                $this->createService($service);
                $this->setService($service);
            }
        } else {
            $this->Output('MsgBox', array(
                'title' => '配置数据库',
                'msg' => '名称不合法（必须为2-10位英文字母或数字）',
                'url' => 'javascript:history.back()'
            ));
        }
        return TRUE;
    }

}