<?php

class NameListUploader extends BoxModel {

    function __construct($args) {
        parent::__construct('Content', 'upload', __CLASS__);
        //region=Content
        //tpl=upload
    }

    protected function LoadContent() {
        return '';
    }

    public function After($page) {
        $page->SetTitle('导入人员');
    }

    public function Before($page) {
        
    }

}