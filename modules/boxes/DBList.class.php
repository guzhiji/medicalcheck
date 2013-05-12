<?php

class DBList extends BoxModel {

    function __construct($args) {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    private function getModulePath() {
        $path = formatpath(dirname(__FILE__));
        $p = strrpos($path, '/', -2);
        return substr($path, 0, $p);
    }

    protected function LoadContent() {
        LoadIBC1Class('ListModel', 'framework');
        $m = new ListModel('item', __CLASS__);
        $m->SetContainer('list');
        $d = dir($this->getModulePath() . '/core/data/services');
        while (FALSE !== ($f = $d->read())) {
            if ($f[0] == '.')
                continue;
            $name = substr($f, 0, strpos($f, '.'));
            $m->AddItem(array(
                'name' => htmlspecialchars($name)
            ));
        }
        $d->close();
        return $m->GetHTML();
    }

    public function After($page) {
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=newservice',
            'Icon' => 'add',
            'Content' => '添加'
        ));
    }

    public function Before($page) {
        
    }

}