<?php

class AddXiangZhen extends ProcessModel {

    public function Process() {
        try {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'xiangzhen');
            if (!$p->create($_POST))
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '添加乡镇',
                'msg' => '成功',
                'url' => '?module=preparation/xiangzhen'
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '添加乡镇',
                'msg' => '非法输入:',
                'content' => error_msg('xiangzhen', $v->getErrors()),
                'url' => '?module=preparation/xiangzhen'
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '添加乡镇',
                'msg' => '失败',
                'url' => '?module=preparation/xiangzhen'
            ));
        }
        return TRUE;
    }

}