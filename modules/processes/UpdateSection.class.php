<?php

class UpdateSection extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']) || !isset($_POST['s_name']))
                throw new Exception();
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'section');
            $suc = $p->update($_GET['id'], array(
                's_name' => $_POST['s_name']
                    ));
            if (!$suc)
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '修改项目',
                'msg' => '成功',
                'url' => queryString(array(
                    'module' => 'preparation/section'
                ))
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '修改项目',
                'msg' => '非法输入:',
                'content' => error_msg('status', $v->getErrors()),
                'url' => queryString(array(
                    'module' => 'preparation/section/status',
                    'section' => $_GET['id']
                ))
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '修改项目',
                'msg' => '未更改',
                'url' => queryString(array(
                    'module' => 'preparation/section'
                ))
            ));
        }
        return TRUE;
    }

}