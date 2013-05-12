<?php

class UnfinishedStats extends BoxModel {

    function __construct() {
        parent::__construct('Content', '', __CLASS__);
        //region=Content
        //tpl=
    }

    private function unfinishedCount() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare(<<<EOS
SELECT COUNT(*) AS c  
FROM person 
WHERE p_pass=0 AND NOT EXISTS (
    SELECT DISTINCT person_id 
    FROM result 
    WHERE person_id=person.id
)
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
        $u = $this->unfinishedCount();
        $t = $this->totalCount();
        if ($t > 0)
            $fp = round(doubleval($t - $u) / $t * 100, 2);
        else
            $fp = 0;
        return "<p><div class=\"ui-body ui-body-e\" style=\"margin: -15px;\">已经完成{$fp}%，还有{$u}人未完成</div></p>";
    }

    public function After($page) {
        
    }

    public function Before($page) {
        
    }

}