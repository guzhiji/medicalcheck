<?php

class RemovePerson extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']))
                throw new Exception();
            if (!isset($_GET['confirmed'])) {
                $this->Output('MsgBox', array(
                    'title' => '删除人员',
                    'msg' => '是否确认删除？此操作将不可恢复。',
                    'url' => '?' . $_SERVER['QUERY_STRING'] . '&confirmed=yes',
                    'mode' => 'confirm'
                ));
            } else {
                LoadIBC1Class('CRUD', 'data.drivers.mysqli');
                $p = new CRUD(MEDICALCHECK_SERVICE, 'person');
                if (!$p->delete($_GET['id']))
                    throw new Exception();
                $this->Output('MsgBox', array(
                    'title' => '删除人员',
                    'msg' => '成功',
                    'url' => '?module=preparation/people'
                ));
            }
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '删除人员',
                'msg' => '失败',
                'url' => '?module=preparation/people'
            ));
        }
        return TRUE;
    }

}