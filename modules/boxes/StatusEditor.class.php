<?php

class StatusEditor extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=content
        //tpl=
    }

    protected function LoadContent() {
        if (isset($_GET['id'])) {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $s = new CRUD(MEDICALCHECK_SERVICE, 'status');
            $status = $s->read($_GET['id']);
            if (empty($status)) {
                $this->Forward('MsgBox', array());
                return '';
            }
            return TransformTpl('update', array(
                        'id' => intval($_GET['id']),
                        'name' => $status['s_text'],
                        'section' => intval($status['section_id'])
                            ), __CLASS__);
        }else
            return TransformTpl('add', array(
                        'section' => intval($_GET['section'])
                            ), __CLASS__);
    }

    public function After($page) {
        if (isset($_GET['id']))
            $page->SetTitle('修改情况');
        else
            $page->SetTitle('添加情况');
    }

    public function Before($page) {
        if (!isset($_GET['section'])) {
            $this->Forward('MsgBox', array());
        }
    }

}