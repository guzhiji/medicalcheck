<?php

LoadIBC1Class('ListModel', 'framework');

class StatusList extends ListModel {

    private $section;
    private $idlist;

    function __construct($itemTplName, $sectionid, $idlist = NULL) {
        parent::__construct($itemTplName, __CLASS__);
        $this->section = $sectionid;
        $this->idlist = $idlist;
    }

    public function GetHTML() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT `id`,`s_text` FROM `status` WHERE section_id=? ORDER BY id');
        $stmt->bind_param('i', $this->section);
        $stmt->bind_result($id, $name);
        $stmt->execute();
        while ($stmt->fetch()) {
            $this->AddItem(array(
                'id' => $id,
                'name' => htmlspecialchars($name),
                'sectionid' => $this->section,
                'selected' => (is_array($this->idlist) && in_array($id, $this->idlist) ) ? ' checked="checked"' : ''
            ));
        }
        $stmt->close();
        return parent::GetHTML();
    }

}