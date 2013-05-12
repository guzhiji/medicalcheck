<?php

require 'modules/common.lib.php';

if (isset($_GET['mode']) && $_GET['mode'] == 'dialog') {
    require 'modules/pages/JQMDialog.class.php';
    $d = new JQMDialog();
    $d->Prepare(array(
        'functions' => array(
            'select' => array('SelectDB', NULL),
            'setup' => array('SetupDB', NULL)
        ),
        'modules' => array(
            'newservice' => array(
                'box' => array('NewDB', NULL)
            )
        )
    ));
    $d->Show();
} else {
    require 'modules/pages/JQMPage.class.php';
    $p = new JQMPage();
    $p->Prepare(array(
        'box' => array('DBList', NULL)
    ));
    $p->Show();
}
