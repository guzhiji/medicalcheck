<?php

class UnqualifiedStats extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    private function unqualifiedCount() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare(<<<EOS
SELECT COUNT(*) AS c  
FROM person 
    LEFT JOIN xiangzhen ON xiangzhen.id=person.xiangzhen_id
    LEFT JOIN degree ON degree.id=person.degree_id
WHERE person.p_pass=0
EOS
        );
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        return $count;
    }

    private function totalCount() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT COUNT(*) AS c FROM person');
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        return $count;
    }

    protected function LoadContent() {
        $u = $this->unqualifiedCount();
        $t = $this->totalCount();
        if ($t > 0)
            $qp = round(doubleval($t - $u) / $t * 100, 2);
        else
            $qp = 0;
        return "<p><div class=\"ui-body ui-body-e\" style=\"margin: -15px;\">合格率为{$qp}%，有{$u}人不合格（或未完成）</div></p>";
    }

    public function After($page) {
        
    }

    public function Before($page) {
        
    }

}