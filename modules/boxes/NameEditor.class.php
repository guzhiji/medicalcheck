<?php

class NameEditor extends BoxModel {

    function __construct() {
        parent::__construct('Content', 'editor', __CLASS__);
        //region=content
        //tpl=editor
    }

    protected function LoadContent() {
        return '';
    }

    public function After($page) {
        $page->SetTitle('添加人员');
    }

    public function Before($page) {
        
    }

}