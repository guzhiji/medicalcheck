<?php

class SectionAdmin extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    protected function LoadContent() {
        LoadIBC1Class('ListModel', 'framework');
        $m = new ListModel('item', __CLASS__);
        $m->SetContainer('list');
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT id,s_name FROM section ORDER BY s_name');
        $stmt->bind_result($id, $name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $m->AddItem(array(
                'id' => $id,
                'name' => htmlspecialchars($name)
            ));
        }
        $stmt->close();
        return $m->GetHTML();
    }

    public function After($page) {
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=preparation/section',
            'Icon' => 'add',
            'Content' => '添加'
        ));
    }

    public function Before($page) {
        
    }

}