<?php

class ImportNames extends ProcessModel {

    public function Process() {
        if (isset($_FILES['namelist']) && $_FILES['namelist']['error'] == 0) {
            session_start();
            if (move_uploaded_file($_FILES['namelist']['tmp_name'], 'cache/' . session_id()))
                $this->Output('NameListImporter', array());
            else
                $this->Output('MsgBox', array(
                    'title' => '导入人员',
                    'msg' => '上传失败',
                    'url' => '?module=preparation/people'
                ));
        } else {
            $this->Output('MsgBox', array(
                'title' => '导入人员',
                'msg' => '未接收到名单文件',
                'url' => '?module=preparation/people'
            ));
        }
        return TRUE;
    }

}