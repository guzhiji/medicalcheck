<?php

class NewDB extends BoxModel {

    function __construct() {
        parent::__construct('Content', 'editor', __CLASS__);
        //region=content
        //tpl=editor
    }

    protected function LoadContent() {
        return '';
    }

    public function After($page) {
        $page->SetTitle('添加数据库');
    }

    public function Before($page) {
        
    }

}