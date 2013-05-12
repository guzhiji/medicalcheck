<?php

class JQMDialog extends PageModel {

    function __construct() {
        parent::__construct('dialog1');
    }

    protected function Finalize() {
        
    }

    protected function Initialize() {
        $this->SetField('Title', '');
        $this->SetField('Info', '');
        $this->SetField('Content', '');
    }

}