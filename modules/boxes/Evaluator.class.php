<?php

class Evaluator extends BoxModel {

    private $parent;

    function __construct($args) {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
        $this->parent = $args['parent'];
    }

    private function getSelectedStatus($person_id) {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT status_id FROM result WHERE person_id=?');
        $stmt->bind_param('i', $person_id);
        $stmt->bind_result($id);
        $stmt->execute();
        $slist = array();
        while ($stmt->fetch()) {
            $slist[] = $id;
        }
        $stmt->close();
        return $slist;
    }

    private function getSectionList() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT id,s_name FROM section');
        $stmt->bind_result($id, $name);
        $stmt->execute();
        $slist = array();
        while ($stmt->fetch()) {
            $slist[$id] = $name;
        }
        $stmt->close();
        return $slist;
    }

    protected function LoadContent() {

        if (!isset($_GET['id'])) {
            $this->Forward('MsgBox', array());
            return '';
        }

        $pid = intval($_GET['id']);

        LoadIBC1Class('CRUD', 'data.drivers.mysqli');
        $p = new CRUD(MEDICALCHECK_SERVICE, 'person');
        $person = $p->read($pid);

        require_once 'modules/lists/XiangzhenList.class.php';
        $xiangzhenlist = new XiangzhenList('select1_item', array($person['xiangzhen_id']));
        $xiangzhenlist->SetContainer('select1_list');
        $xzlist = $xiangzhenlist->GetHTML();

        require_once 'modules/lists/DegreeList.class.php';
        $degreelist = new DegreeList('select1_item', array($person['degree_id']));
        $degreelist->SetContainer('select1_list');
        $dlist = $degreelist->GetHTML();

        LoadIBC1Class('ListModel', 'framework');
        $sections = new ListModel('section', __CLASS__);
        $sections->SetContainer('evaluator', array(
            'Id' => $pid,
            'Name' => htmlspecialchars($person['p_name']),
            'Pass' => $person['p_pass'] ? ' checked="checked"' : '',
            'Note' => htmlspecialchars($person['p_note']),
            'XiangzhenList' => $xzlist,
            'DegreeList' => $dlist,
            'Parent' => $this->parent
        ));

        $slist = $this->getSectionList();

        require_once 'modules/lists/StatusList.class.php';
        foreach ($slist as $id => $name) {
            $statuslist = new StatusList('select1_item', $id, $this->getSelectedStatus($pid));
            $sections->AddItem(array(
                'SectionName' => htmlspecialchars($name),
                'StatusList' => $statuslist->GetHTML()
            ));
        }

        return $sections->GetHTML();
    }

    public function After($page) {
        $page->ShowHomeButton('?module=' . $this->parent);
    }

    public function Before($page) {
        
    }

}