<?php

class UpdateXiangZhen extends ProcessModel {

    public function Process() {
        try {
            if (!isset($_GET['id']) || !isset($_POST['x_name']))
                throw new Exception();
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');
            $p = new CRUD(MEDICALCHECK_SERVICE, 'xiangzhen');
            $suc = $p->update($_GET['id'], array(
                'x_name' => $_POST['x_name']
                    ));
            if (!$suc)
                throw new Exception();
            $this->Output('MsgBox', array(
                'title' => '修改乡镇',
                'msg' => '成功',
                'url' => queryString(array(
                    'module' => 'preparation/xiangzhen'
                ))
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '修改乡镇',
                'msg' => '非法输入:',
                'content' => error_msg('xiangzhen', $v->getErrors()),
                'url' => queryString(array(
                    'module' => 'preparation/xiangzhen',
                    'mode' => 'dialog',
                    'id' => $_GET['id']
                ))
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '修改乡镇',
                'msg' => '未更改',
                'url' => queryString(array(
                    'module' => 'preparation/xiangzhen'
                ))
            ));
        }
        return TRUE;
    }

}