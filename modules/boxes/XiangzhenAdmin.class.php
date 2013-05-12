<?php

class XiangzhenAdmin extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    protected function LoadContent() {
        require_once 'modules/lists/XiangzhenList.class.php';
        $m = new XiangzhenList('admin1_item');
        $m->SetContainer('admin1_list');
        return $m->GetHTML();
    }

    public function After($page) {
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=preparation/xiangzhen',
            'Icon' => 'add',
            'Content' => '添加'
        ));
    }

    public function Before($page) {
        
    }

}