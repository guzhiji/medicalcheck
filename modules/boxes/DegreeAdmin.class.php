<?php

class DegreeAdmin extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    protected function LoadContent() {
        require_once 'modules/lists/DegreeList.class.php';
        $m = new DegreeList('admin1_item');
        $m->SetContainer('admin1_list');
        return $m->GetHTML();
    }

    public function After($page) {
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=preparation/degree',
            'Icon' => 'add',
            'Content' => '添加'
        ));
    }

    public function Before($page) {
        
    }

}