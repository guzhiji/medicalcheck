<?php

class RemoveDegree extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']))
                throw new Exception();
            if (!isset($_GET['confirmed'])) {
                $this->Output('MsgBox', array(
                    'title' => '删除学历',
                    'msg' => '是否确认删除？此操作将不可恢复。',
                    'url' => '?' . $_SERVER['QUERY_STRING'] . '&confirmed=yes',
                    'mode' => 'confirm'
                ));
            } else {
                LoadIBC1Class('CRUD', 'data.drivers.mysqli');
                $p = new CRUD(MEDICALCHECK_SERVICE, 'degree');
                if (!$p->delete($_GET['id']))
                    throw new Exception();
                $this->Output('MsgBox', array(
                    'title' => '删除学历',
                    'msg' => '成功',
                    'url' => '?module=preparation/degree'
                ));
            }
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '删除学历',
                'msg' => '失败（可能是因为已经被使用）',
                'url' => '?module=preparation/degree'
            ));
        }
        return TRUE;
    }

}