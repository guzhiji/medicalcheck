<?php

class RemoveSection extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']))
                throw new Exception();
            if (!isset($_GET['confirmed'])) {
                $this->Output('MsgBox', array(
                    'title' => '删除项目',
                    'msg' => '是否确认删除？此操作将不可恢复。',
                    'url' => '?' . $_SERVER['QUERY_STRING'] . '&confirmed=yes',
                    'mode' => 'confirm'
                ));
            } else {
                LoadIBC1Class('CRUD', 'data.drivers.mysqli');
                $p = new CRUD(MEDICALCHECK_SERVICE, 'section');
                if (!$p->delete($_GET['id']))
                    throw new Exception();
                $this->Output('MsgBox', array(
                    'title' => '删除项目',
                    'msg' => '成功',
                    'url' => '?module=preparation/section'
                ));
            }
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '删除项目',
                'msg' => '失败（可能是因为内部仍然含有情况，或者已经被使用）',
                'url' => '?module=preparation/section'
            ));
        }
        return TRUE;
    }

}