<?php

LoadIBC1Class('ListModel', 'framework');

class DegreeList extends ListModel {

    private $idlist;

    function __construct($itemTplName, $idlist = NULL) {
        parent::__construct($itemTplName, __CLASS__);
        $this->idlist = $idlist;
    }

    public function GetHTML() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT id,d_name FROM degree ORDER BY id');
        $stmt->bind_result($id, $name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $this->AddItem(array(
                'id' => $id,
                'name' => htmlspecialchars($name),
                'selected' => (is_array($this->idlist) && in_array($id, $this->idlist) ) ? ' selected="selected"' : ''
            ));
        }
        $stmt->close();
        return parent::GetHTML();
    }

}