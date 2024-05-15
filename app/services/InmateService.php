<?php

require_once '../app/models/Inmate.php';
require_once '../app/db/Database.php';
class InmateService {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getInmateById($id) {
        try{
            $stmt = $this->db->prepare("SELECT * FROM inmate WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($row == false)
                return null;
            
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return null;
        }
        $prisonId = $row["id"];
        $prisonService = new PrisonService();
        $prison = $prisonService->getPrisonById($prisonId)->getName();
        return new Inmate($row['id'],
            $row['photo'], $row['first_name'], $row['last_name'],
            $row['cnp'], $row['age'], $row['gender'], $prison,
            $row['date_of_incarceracion'], $row['end_of_incarceration'], $row['crime']
        );
    }
    public function getInmateByCnp($cnp){
        try{
            $stmt = $this->db->prepare("SELECT * FROM inmate WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row == false)
                return null;

        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
        $prisonId = $row["id"];
        $prisonService = new PrisonService();
        $prison = $prisonService->getPrisonById($prisonId)->getName();

        return new Inmate($row['id'],
            $row['photo'], $row['first_name'], $row['last_name'],
            $row['cnp'], $row['age'], $row['gender'], $prison,
            $row['date_of_incarceracion'], $row['end_of_incarceration'], $row['crime']
        );
    }

    public function getInmateIdByCNP($cnp){
        try{
            $stmt = $this->db->prepare("SELECT id FROM inmate WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getInmatePrisonId($id){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM inmate WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_prison'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
    public function getInmateByCriteria($criteria){
        $inmates = [];

        $query = "SELECT * FROM inmate WHERE ";
        $first = true;

        foreach($criteria as $key => $value){
            if(!$first)
                $query .= " AND ";

            $query .= $key. "=" . ":" . $key;
            $first = false;
        }

        try{
            $stmt = $this->db->prepare($query);

            foreach($criteria as $key => $value){
                $stmt->bindParam(':' . $key, $value, PDO::PARAM_STR);
            }

            $stmt->execute();

            while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $prisonId = $row["id"];
                $prisonService = new PrisonService();
                $prison = $prisonService->getPrisonById($prisonId)->getName();

                $inmates[] = new Inmate($row['id'],
                        'ceva aici', $row['first_name'], $row['last_name'],
                        $row['cnp'], $row['age'], $row['gender'], $prison,
                        $row['date_of_incarceracion'], $row['end_of_incarceration'], $row['crime']
                    );
                }
            } catch (PDOException $e) {
                trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
                return false;
        }
        return $inmates;
    } 

    public function addInmate(Inmate $inmate) {
        try{
            $stmt = $this->db->prepare("INSERT INTO inmate (photo,first_name, last_name, cnp, age, gender, id_prison, date_of_incarceracion, end_of_incarceration, crime) VALUES (:photo, :first_name, :last_name, :cnp, :age, :gender, :id_prison, :date_of_incarceracion, :end_of_incarceration, :crime)");
            $stmt->bindParam(':photo', $inmate->photo, PDO::PARAM_LOB);
            $stmt->bindParam(':first_name', $inmate->firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $inmate->lastName, PDO::PARAM_STR);
            $stmt->bindParam(':cnp', $inmate->cnp, PDO::PARAM_STR);
            $stmt->bindParam(':age', $inmate->age, PDO::PARAM_INT);
            $stmt->bindParam(':gender', $inmate->gender, PDO::PARAM_STR);
            $stmt->bindParam(':id_prison', $inmate->idPrison, PDO::PARAM_INT);
            $stmt->bindParam(':date_of_incarceracion', $inmate->dateOfIncarceration);
            $stmt->bindParam(':end_of_incarceration', $inmate->endOfIncarceration);
            $stmt->bindParam(':crime', $inmate->crime, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
}
