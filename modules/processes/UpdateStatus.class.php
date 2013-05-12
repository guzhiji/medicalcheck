<?php

class UpdateStatus extends ProcessModel {

    private function getBackAddr() {
        if (isset($_POST['section_id']))
            return queryString(array(
                        'module' => 'preparation/section/status',
                        'section' => $_POST['section_id']
                    ));
        else
            return queryString(array(
                        'module' => 'preparation/section'
                    ));
    }

    public function Process() {
        try {
            if (!isset($_GET['id']) || !isset($_POST['s_text']))
                throw new Exception();
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'status');
            $suc = $p->update($_GET['id'], array(
                's_text' => $_POST['s_text']
                    ));
            if (!$suc)
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '修改情况',
                'msg' => '成功',
                'url' => $this->getBackAddr()
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '修改情况',
                'msg' => '非法输入:',
                'content' => error_msg('status', $v->getErrors()),
                'url' => queryString(array(
                    'module' => 'preparation/section/status',
                    'section' => $_POST['section_id'],
                    'mode' => 'dialog',
                    'id' => $_GET['id']
                )),
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '修改情况',
                'msg' => '未更改',
                'url' => $this->getBackAddr()
            ));
        }
        return TRUE;
    }

}