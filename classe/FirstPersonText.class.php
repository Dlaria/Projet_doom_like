<?php
class FirstPersonText extends BaseClass {
    protected $_mapId;

    public function setText(FirstPersonView $data){
        $sql = "SELECT * FROM text 
        INNER JOIN map ON map.id = text.map_id
        WHERE coordx=:X AND coordy=:Y AND direction=:Ag";
        $query = $data->_dbh->prepare($sql);
        $query->bindParam(':X',$data->_currentX,PDO::PARAM_INT);
        $query->bindParam(':Y',$data->_currentY,PDO::PARAM_INT);
        $query->bindParam(':Ag',$data->_currentAngle,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if (!empty($result)){
            $this->_mapId = $result->map_id;
            return true;
        }else{
            return false;
        }
    }

    public function getText(FirstPersonView $data){
        if ($this->setText($data) == true){
            $query = $data->_dbh->prepare("SELECT * FROM text WHERE map_id=:mapId");
            $query->bindParam(':mapId',$this->_mapId);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            if(!empty($result)){
                return $result->text;
            }
        }
    }
}