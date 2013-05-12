<?php

class QualifiedList extends BoxModel {

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
SELECT person.id,person.p_name,xiangzhen.x_name,degree.d_name 
FROM person 
    LEFT JOIN xiangzhen ON xiangzhen.id=person.xiangzhen_id
    LEFT JOIN degree ON degree.id=person.degree_id
WHERE person.p_pass>0 
ORDER BY person.p_name
LIMIT ?,?
EOS
        );
        $stmt->bind_param('ii', $pagestart = db_start_pos(), $pagesize = MEDICALCHECK_PAGESIZE);
        $stmt->bind_result($id, $name, $xiangzhen, $degree);
        $stmt->execute();
        $count = 0;
        while ($stmt->fetch()) {
            $m->AddItem(array(
                'id' => $id,
                'name' => htmlspecialchars($name),
                'xiangzhen' => htmlspecialchars($xiangzhen),
                'degree' => htmlspecialchars($degree)
            ));
            $count++;
        }
        $stmt->close();
        $this->count = $count;
        return $m->GetHTML();
    }

    public function After($page) {
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