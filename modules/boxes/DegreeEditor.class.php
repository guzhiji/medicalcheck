<?php

class DegreeEditor extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=content
        //tpl=
    }

    protected function LoadContent() {
        if (isset($_GET['id'])) {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $s = new CRUD(MEDICALCHECK_SERVICE, 'degree');
            $xz = $s->read($_GET['id']);
            if (empty($xz)) {
                $this->Forward('MsgBox', array());
                return '';
            }
            return TransformTpl('update', array(
                        'id' => intval($_GET['id']),
                        'name' => $xz['d_name']
                            ), __CLASS__);
        } else {
            return GetTemplate('add', __CLASS__);
        }
    }

    public function After($page) {
        if (isset($_GET['id'])) {
            $page->SetTitle('修改学历');
        } else {
            $page->SetTitle('添加学历');
        }
    }

    public function Before($page) {
        
    }

}