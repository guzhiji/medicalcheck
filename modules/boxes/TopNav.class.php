<?php

class TopNav extends BoxModel {

    private $mode;

    function __construct($args) {
        $this->mode = $args['mode'];
        parent::__construct($this->mode == 'home' ? 'Content' : 'TopNav', '', __CLASS__);
    }

    protected function LoadContent() {
        LoadIBC1Class('ListModel', 'framework');
        $m = new ListModel('item', __CLASS__);
        switch ($this->mode) {
            case 'home':
                $contents = array(
                    array(
                        'text' => '准备',
                        'module' => 'preparation'
                    ),
                    array(
                        'text' => '评估',
                        'module' => 'evaluation'
                    ),
                    array(
                        'text' => '结果',
                        'module' => 'report'
                    )
                );
                $m->SetContainer('list_v');
                foreach ($contents as $c)
                    $m->AddItem(array(
                        'text' => $c['text'],
                        'theme' => 'c',
                        'module' => $c['module']
                    ));
                break;
            case 'preparation':
                $contents = array(
                    array(
                        'text' => '乡镇',
                        'module' => 'preparation/xiangzhen'
                    ),
                    array(
                        'text' => '人员',
                        'module' => 'preparation/people'
                    ),
                    array(
                        'text' => '学历',
                        'module' => 'preparation/degree'
                    ),
                    array(
                        'text' => '项目',
                        'module' => 'preparation/section'
                    )
                );
                $m->SetContainer('list_h');
                foreach ($contents as $c)
                    $m->AddItem(array(
                        'text' => $c['text'],
                        'theme' => $_GET['module'] == $c['module'] ? 'b' : 'a',
                        'module' => $c['module']
                    ));
                break;
            case 'evaluation':
                $contents = array(
                    array(
                        'text' => '未完成',
                        'module' => 'evaluation/unfinished'
                    ),
                    array(
                        'text' => '搜索',
                        'module' => 'evaluation/search'
                    )
                );
                $m->SetContainer('list_h');
                foreach ($contents as $c)
                    $m->AddItem(array(
                        'text' => $c['text'],
                        'theme' => $_GET['module'] == $c['module'] ? 'b' : 'a',
                        'module' => $c['module']
                    ));
                break;
            case 'report':
                $contents = array(
                    array(
                        'text' => '合格',
                        'module' => 'report/qualified'
                    ),
                    array(
                        'text' => '不合格',
                        'module' => 'report/unqualified'
                    ),
                    array(
                        'text' => '搜索',
                        'module' => 'report/search'
                    )
                );
                $m->SetContainer('list_h');
                foreach ($contents as $c)
                    $m->AddItem(array(
                        'text' => $c['text'],
                        'theme' => $_GET['module'] == $c['module'] ? 'b' : 'a',
                        'module' => $c['module']
                    ));
                break;
        }

        return $m->GetHTML();
    }

    public function After($page) {
        switch ($this->mode) {
            case 'home':
                $page->SetTitle('体检记录系统');
                break;
            case 'preparation':
                $page->SetTitle('准备');
                $page->ShowHomeButton();
                break;
            case 'evaluation':
                $page->SetTitle('评估');
                $page->ShowHomeButton();
                break;
            case 'report':
                $page->SetTitle('结果');
                $page->ShowHomeButton();
                break;
        }
    }

    public function Before($page) {
        
    }

}