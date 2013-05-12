<?php

class SearchList extends BoxModel {

    private $mode;

    function __construct($args) {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
        $this->mode = $args['mode'];
    }

    protected function LoadContent() {
        //$q = isset($_GET['search']) ? $_GET['search'] : '';
        session_start();
        $q = readParam('get|session', 'search');
        $_SESSION['search'] = $q;
        LoadIBC1Class('ListModel', 'framework');
        $m = new ListModel('item', __CLASS__);
        $m->SetContainer('list', array(
            'search' => htmlspecialchars($q),
            'module' => $this->mode . '/search'
        ));
        $count = 0;
        if (!empty($q)) {
            $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
            $stmt = $mysqli->prepare(<<<EOS
SELECT person.id,person.p_name,xiangzhen.x_name,degree.d_name,person.p_pass 
FROM person 
    LEFT JOIN xiangzhen ON xiangzhen.id=person.xiangzhen_id
    LEFT JOIN degree ON degree.id=person.degree_id
WHERE person.p_name LIKE ?
LIMIT ?,?
EOS
            );
            $q2 = '%' . str_replace('%', '\%', str_replace('_', '\_', $q)) . '%';
            $stmt->bind_param('sii', $q2, $pagestart = db_start_pos(), $pagesize = MEDICALCHECK_PAGESIZE);
            $stmt->bind_result($id, $name, $xiangzhen, $degree, $pass);
            $stmt->execute();
            while ($stmt->fetch()) {
                $m->AddItem(array(
                    'id' => $id,
                    'name' => htmlspecialchars($name),
                    'xiangzhen' => htmlspecialchars($xiangzhen),
                    'degree' => htmlspecialchars($degree),
                    'mode' => $this->mode,
                    'theme' => $pass > 0 ? 'e' : 'c',
                    'icon' => $pass > 0 ? 'check' : 'arrow-r'
                ));
                $count++;
            }
            $stmt->close();
        }
        $this->count = $count;
        return $m->GetHTML();
    }

    public function After($page) {
        if ($this->mode == 'evaluation')
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