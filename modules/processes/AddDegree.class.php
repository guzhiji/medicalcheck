<?php

class AddDegree extends ProcessModel {

    public function Process() {
        try {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'degree');
            if (!$p->create($_POST))
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '添加学历',
                'msg' => '成功',
                'url' => '?module=preparation/degree'
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '添加学历',
                'msg' => '非法输入:',
                'content' => error_msg('degree', $v->getErrors()),
                'url' => '?module=preparation/degree'
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '添加学历',
                'msg' => '失败',
                'url' => '?module=preparation/degree'
            ));
        }
        return TRUE;
    }

}