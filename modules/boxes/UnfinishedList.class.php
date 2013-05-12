<?php

class UnfinishedList extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    protected function LoadContent() {
        LoadIBC1Class('ListModel', 'framework');
        $m = new ListModel('item', __CLASS__);
        $m->SetContainer('list');
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare(<<<EOS
SELECT id,p_name 
FROM person 
WHERE p_pass=0 AND NOT EXISTS (
    SELECT DISTINCT person_id 
    FROM result 
    WHERE person_id=person.id
) 
ORDER BY p_name
LIMIT ?,?
EOS
        );
        $stmt->bind_param('ii', $pagestart = db_start_pos(), $pagesize = MEDICALCHECK_PAGESIZE);
        $stmt->bind_result($id, $name);
        $stmt->execute();
        $count = 0;
        while ($stmt->fetch()) {
            $m->AddItem(array(
                'id' => $id,
                'name' => htmlspecialchars($name)
            ));
            $count++;
        }
        $stmt->close();
        $this->count = $count;
        return $m->GetHTML();
    }

    public function After($page) {
        $page->ShowRightButton(array(
            'URL' => '?mode=dialog&module=preparation/person',
            'Icon' => 'add',
            'Content' => '添加'
        ));
        $p = intval(readParam('get', 'page'));
        if ($p > 1)
            $page->ShowPrevPageButton($p);
        else
            $p = 1;
        if ($this->count == MEDICALCHECK_PAGESIZE)
            $page->ShowNextPageButton($p);
    }

    public function Before($page) {
        
    }

}