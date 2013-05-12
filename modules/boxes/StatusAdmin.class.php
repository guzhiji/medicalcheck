<?php

class StatusAdmin extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    protected function LoadContent() {
        require_once 'modules/lists/StatusList.class.php';
        $s = new StatusList('admin1_item', $_GET['section']);
        $s->SetContainer('admin1_list');
        return $s->GetHTML();
    }

    public function After($page) {
        $page->SetTitle('情况');
        $page->ShowHomeButton('?module=preparation/section');
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=preparation/section/status&section=' . intval($_GET['section']),
            'Icon' => 'add',
            'Content' => '添加'
        ));
    }

    public function Before($page) {
        if (!isset($_GET['section'])) {
            $this->Forward('MsgBox', array());
        }
    }

}