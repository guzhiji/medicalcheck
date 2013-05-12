<?php

class UpdateDegree extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']) || !isset($_POST['d_name']))
                throw new Exception();
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'degree');
            $suc = $p->update($_GET['id'], array(
                'd_name' => $_POST['d_name']
                    ));
            if (!$suc)
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '修改学历',
                'msg' => '成功',
                'url' => '?module=preparation/degree'
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '修改学历',
                'msg' => '非法输入:',
                'content' => error_msg('degree', $v->getErrors()),
                'url' => '?module=preparation/degree&mode=dialog&id=' . $_GET['id']
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '修改学历',
                'msg' => '未更改',
                'url' => '?module=preparation/degree'
            ));
        }
        return TRUE;
    }

}