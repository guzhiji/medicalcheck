<?php

class AddSection extends ProcessModel {

    public function Process() {
        try {
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'section');
            if (!$p->create($_POST))
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '添加项目',
                'msg' => '成功',
                'url' => '?module=preparation/section'
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '添加项目',
                'msg' => '非法输入:',
                'content' => error_msg('section', $v->getErrors()),
                'url' => '?module=preparation/section'
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '添加项目',
                'msg' => '失败',
                'url' => '?module=preparation/section'
            ));
        }
        return TRUE;
    }

}