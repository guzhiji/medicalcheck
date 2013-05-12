<?php

class AddStatus extends ProcessModel {

    public function Process() {

        if (isset($_POST['section_id'])) {
            try {
                LoadIBC1Class('CRUD', 'data.drivers.mysqli');
                $p = new CRUD(MEDICALCHECK_SERVICE, 'status');
                if (!$p->create($_POST))
                    throw new Exception();
                $this->Output('MsgBox', array(
                    'title' => '添加情况',
                    'msg' => '成功',
                    'url' => '?module=preparation/section/status&section=' . intval($_POST['section_id'])
                ));
            } catch (InvalidValueException $ex) {
                $v = $ex->getValidator();
                $this->Output('MsgBox', array(
                    'title' => '添加情况',
                    'msg' => '非法输入:',
                    'content' => error_msg('status', $v->getErrors()),
                    'url' => '?module=preparation/section/status&section=' . intval($_POST['section_id'])
                ));
            } catch (Exception $ex) {
                $this->Output('MsgBox', array(
                    'title' => '添加情况',
                    'msg' => '失败',
                    'url' => '?module=preparation/section/status&section=' . intval($_POST['section_id'])
                ));
            }
        } else {
            $this->Output('MsgBox', array(
                'title' => '添加情况',
                'msg' => '失败',
                'url' => '?module=preparation/section'
            ));
        }

        return TRUE;
    }

}