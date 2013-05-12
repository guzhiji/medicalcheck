<?php

class AddName extends ProcessModel {

    public function Process() {
        try {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'person');
            if (!$p->create($_POST))
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '添加人员',
                'msg' => '成功',
                'url' => '?module=preparation/people'
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '添加人员',
                'msg' => '非法输入:',
                'content' => error_msg('person', $v->getErrors()),
                'url' => '?module=preparation/people'
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '添加人员',
                'msg' => '失败',
                'url' => '?module=preparation/people'
            ));
        }
        return TRUE;
    }

}