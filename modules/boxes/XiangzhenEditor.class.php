<?php

class XiangzhenEditor extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=content
        //tpl=
    }

    protected function LoadContent() {
        if (isset($_GET['id'])) {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $s = new CRUD(MEDICALCHECK_SERVICE, 'xiangzhen');
            $xz = $s->read($_GET['id']);
            if (empty($xz)) {
                $this->Forward('MsgBox', array());
                return '';
            }
            return TransformTpl('update', array(
                        'id' => intval($_GET['id']),
                        'name' => $xz['x_name']
                            ), __CLASS__);
        } else {
            return GetTemplate('add', __CLASS__);
        }
    }

    public function After($page) {
        if (isset($_GET['id'])) {
            $page->SetTitle('修改乡镇');
        } else {
            $page->SetTitle('添加乡镇');
        }
    }

    public function Before($page) {
        
    }

}