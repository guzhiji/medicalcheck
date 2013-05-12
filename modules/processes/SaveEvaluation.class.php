<?php

class SaveEvaluation extends ProcessModel {

    private function beginT() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $mysqli->autocommit(FALSE);
    }

    private function commit() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $mysqli->commit();
        $mysqli->autocommit(TRUE);
    }

    private function rollback() {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $mysqli->rollback();
        $mysqli->autocommit(TRUE);
    }

    private function delete($person_id, $status_id) {
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('DELETE FROM result WHERE person_id=? AND status_id=?');
        $stmt->bind_param('ii', $person_id, $status_id);
        $stmt->execute();
        return $mysqli->affected_rows > 0;
    }

    private function getStatusList() {
        $statuslist = array();
        $mysqli = ibc2_dataservice_conn(MEDICALCHECK_SERVICE);
        $stmt = $mysqli->prepare('SELECT id FROM status');
        $stmt->execute();
        $stmt->bind_result($id);
        while ($stmt->fetch())
            $statuslist[] = $id;
        $stmt->close();
        return $statuslist;
    }

    public function Process() {

        $parent_module = isset($_GET['parent']) ? $_GET['parent'] : 'evaluation/unfinished';

        try {

            if (!isset($_GET['id']))
                throw new Exception();

            $statuslist = $this->getStatusList();
            LoadIBC1Class('CRUD', 'data.drivers.mysqli');

            try {
                $this->beginT();

                $p = new CRUD(MEDICALCHECK_SERVICE, 'person');
                $p->update($_GET['id'], array(
                    'p_name' => $_POST['name'],
                    'degree_id' => $_POST['degree'],
                    'xiangzhen_id' => $_POST['xiangzhen'],
                    'p_pass' => isset($_POST['pass']),
                    'p_note' => $_POST['note']
                ));

                $r = new CRUD(MEDICALCHECK_SERVICE, 'result');
                foreach ($statuslist as $status) {
                    if (isset($_POST['status' . $status])) {
                        try {
                            $r->create(array(
                                'person_id' => $_GET['id'],
                                'status_id' => $status
                            ));
                        } catch (Exception $ex) {
                            
                        }
                    } else {
                        $this->delete($_GET['id'], $status);
                    }
                }

                $this->commit();
            } catch (Exception $ex) {
                $this->rollback();
                throw $ex;
            }

            $this->Output('MsgBox', array(
                'title' => '保存评估结果',
                'msg' => '成功',
                'url' => '?module=' . $parent_module . '/person&id=' . $_GET['id']
            ));
        } catch (InvalidValueException $ex) {
            $v = $ex->getValidator();
            $this->Output('MsgBox', array(
                'title' => '保存评估结果',
                'msg' => '非法输入:',
                'content' => error_msg('person', $v->getErrors()),
                'url' => '?module=' . $parent_module . (isset($_GET['id']) ? ('/person&id=' . $_GET['id']) : '')
            ));
        } catch (Exception $ex) {
            $this->Output('MsgBox', array(
                'title' => '保存评估结果',
                'msg' => '未更改',
                'url' => '?module=' . $parent_module . (isset($_GET['id']) ? ('/person&id=' . $_GET['id']) : '')
            ));
        }
        return TRUE;
    }

}