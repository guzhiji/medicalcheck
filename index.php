<?php

require 'modules/common.lib.php';

if (isset($_GET['mode']) && $_GET['mode'] == 'dialog') {
    require 'modules/pages/JQMDialog.class.php';
    $d = new JQMDialog();
    $d->Prepare(array(
        'modules' => array(
            'preparation/xiangzhen' => array(
                'box' => array('XiangzhenEditor', NULL),
                'functions' => array(
                    'add' => array('AddXiangZhen', NULL),
                    'update' => array('UpdateXiangZhen', NULL),
                    'delete' => array('RemoveXiangZhen', NULL)
                )
            ),
            'preparation/degree' => array(
                'box' => array('DegreeEditor', NULL),
                'functions' => array(
                    'add' => array('AddDegree', NULL),
                    'update' => array('UpdateDegree', NULL),
                    'delete' => array('RemoveDegree', NULL)
                )
            ),
            'preparation/importnames' => array(
                'box' => array('NameListUploader', NULL),
                'functions' => array(
                    'import' => array('ImportNames', NULL),
                    'progress' => array('ImportNamesProgress', NULL)
                )
            ),
            'preparation/person' => array(
                'box' => array('NameEditor', NULL),
                'functions' => array(
                    'add' => array('AddName', NULL),
                    'delete' => array('RemovePerson', NULL)
                )
            ),
            'preparation/section' => array(
                'box' => array('SectionEditor', NULL),
                'functions' => array(
                    'add' => array('AddSection', NULL),
                    'update' => array('UpdateSection', NULL),
                    'delete' => array('RemoveSection', NULL)
                )
            ),
            'preparation/section/status' => array(
                'box' => array('StatusEditor', NULL),
                'functions' => array(
                    'add' => array('AddStatus', NULL),
                    'update' => array('UpdateStatus', NULL),
                    'delete' => array('RemoveStatus', NULL)
                )
            ),
            'evaluation/person' => array(
                'functions' => array(
                    'save' => array('SaveEvaluation', NULL)
                )
            )
        )
    ));
    $d->Show();
} else {
    require 'modules/pages/JQMPage.class.php';
    $p = new JQMPage();
    $p->Prepare(array(
        'box' => array('TopNav', array('mode' => 'home')),
        'modules' => array(
            'preparation' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'preparation'))
                )
            ),
            'preparation/xiangzhen' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'preparation')),
                    array('XiangzhenAdmin', NULL)
                )
            ),
            'preparation/degree' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'preparation')),
                    array('DegreeAdmin', NULL)
                )
            ),
            'preparation/people' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'preparation')),
                    array('PeopleAdmin', NULL)
                )
            ),
            'preparation/section' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'preparation')),
                    array('SectionAdmin', NULL)
                )
            ),
            'preparation/section/status' => array(
                'boxes' => array(
                    array('StatusAdmin', NULL)
                )
            ),
            'evaluation' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'evaluation'))
                )
            ),
            'evaluation/unfinished' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'evaluation')),
                    array('UnfinishedStats', NULL),
                    array('UnfinishedList', NULL)
                )
            ),
            'evaluation/unfinished/person' => array(
                'box' => array('Evaluator', array('parent' => 'evaluation/unfinished'))
            ),
            'evaluation/search' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'evaluation')),
                    array('SearchList', array('mode' => 'evaluation'))
                )
            ),
            'evaluation/search/person' => array(
                'box' => array('Evaluator', array('parent' => 'evaluation/search'))
            ),
            'report' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'report'))
                )
            ),
            'report/unqualified' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'report')),
                    array('UnqualifiedStats', NULL),
                    array('UnqualifiedList', NULL)
                )
            ),
            'report/unqualified/person' => array(
                'box' => array('Evaluator', array('parent' => 'report/unqualified'))
            ),
            'report/qualified' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'report')),
                    array('UnqualifiedStats', NULL),
                    array('qualifiedList', NULL)
                )
            ),
            'report/qualified/person' => array(
                'box' => array('Evaluator', array('parent' => 'report/qualified'))
            ),
            'report/search' => array(
                'boxes' => array(
                    array('TopNav', array('mode' => 'report')),
                    array('SearchList', array('mode' => 'report'))
                )
            ),
            'report/search/person' => array(
                'box' => array('Evaluator', array('parent' => 'report/search'))
            ),
        )
    ));
    $p->Show();
}
