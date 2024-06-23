<?php
session_start();
require_once '../app/models/Inmate.php';
require_once '../app/db/Database.php';
class InmateService {
    /**
     * @var
     * used to connect to the database
     */
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Gets the inmate with the specified id
     *
     * No inmate is found => returns null
     *
     * @param int $id
     * @return Inmate|null
     */
    public function getInmateById(int $id) {
        try{
            $stmt = $this->db->prepare("SELECT * FROM inmate WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$row)
                return null;
            
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        $prisonId = $row["id_prison"];
        $prisonService = new PrisonService();
        $prison = $prisonService->getPrisonById($prisonId)->getName();
        return new Inmate($row['id'],
            $row['photo'], $row['first_name'], $row['last_name'],
            $row['cnp'], $row['age'], $row['gender'], $prison,
            $row['date_of_incarceracion'], $row['end_of_incarceration'], $row['crime']
        );
    }

    /**
     * Gets the inmate with the specified cnp
     *
     * No inmate is found => returns null
     * @param  string $cnp
     * @return Inmate|null
     */
    public function getInmateByCnp(string $cnp){
        try{
            $stmt = $this->db->prepare("SELECT * FROM inmate WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return null;

        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        $prisonId = $row["id_prison"];
        $prisonService = new PrisonService();
        $prison = $prisonService->getPrisonById($prisonId)->getName();

        return new Inmate($row['id'],
            $row['photo'], $row['first_name'], $row['last_name'],
            $row['cnp'], $row['age'], $row['gender'], $prison,
            $row['date_of_incarceracion'], $row['end_of_incarceration'], $row['crime']
        );
    }

    /**
     * Gets the id of the specified inmate by cnp
     *
     * No inmate is found => returns null
     * @param  string $cnp
     * @return int|void
     */
    public function getInmateIdByCNP(string $cnp){
        try{
            $stmt = $this->db->prepare("SELECT id FROM inmate WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * Gets the prison id of the inmate specified by id
     * @param  int $id
     * @return int|void
     */
    public function getInmatePrisonId(int $id){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM inmate WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_prison'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * Gets the inmates that match the criteria
     *
     * No inmate found => returns an empty array
     * @param array $criteria
     * @return array
     */
    public function getInmatesByCriteria(array $criteria): array
    {
        $inmates = [];
        $query = "SELECT * FROM inmate WHERE ";
        $first = true;

        //builds the query from the key/value pairs
        foreach ($criteria as $key => $value) {
            if (!$first) {
                $query .= ' AND ';
            }

            if ($key == 'prison') {
                $query .= 'id_prison = :id_prison';
            } else if($key == 'prisoner-cnp') {
                $query .= 'cnp = :cnp';
            }
            else {
                $query .= $key . ' = :' . $key;
            }

            $first = false;
        }

        //binds the values-params/handles the prison
        try {
            $stmt = $this->db->prepare($query);

            foreach ($criteria as $key => $value) {
                if ($key == 'prison') {
                    $prisonService = new PrisonService();
                    $prisonValue = $prisonService->getIdByName($value);

                    if(is_null($prisonValue))
                        return $inmates;

                    $stmt->bindValue(':id_prison', $prisonValue, PDO::PARAM_INT);
                } else if($key == 'prisoner-cnp') {
                    $stmt->bindValue(':cnp', $value, PDO::PARAM_STR);
                }
                else {
                    $stmt->bindValue(':' . $key, strval($value), PDO::PARAM_STR);
                }

            }

            $stmt->execute();

            //fetches inmates
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $prisonId = $row["id_prison"];
                $prisonService = new PrisonService();
                $prison = $prisonService->getPrisonById($prisonId)->getName();

                $inmates[] = new Inmate(
                    $row['id'],
                    'ceva aici',
                    $row['first_name'],
                    $row['last_name'],
                    $row['cnp'],
                    $row['age'],
                    $row['gender'],
                    $prison,
                    $row['date_of_incarceracion'],
                    $row['end_of_incarceration'],
                    $row['crime']
                );
            }
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        return $inmates;
    }


    /**
     * @param  Inmate $inmate
     * @return int (0 -> valid, 1 -> inmate already exists, 2 -> cnp is invalid)
     */
    public function addInmate(Inmate $inmate) {
        try{
            $cnp = $inmate->cnp;

            $result = $this->cnpValidation($cnp);
            if(!$result){
                return 2; // -> invalid cnp
            }

            $stmt1 = $this->db->prepare("SELECT EXISTS(SELECT * FROM inmate WHERE cnp = :cnp) check");
            $stmt1->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt1->execute();
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);
            if($row['check'])
                return 1; // ->inmate already exists

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
            return 0;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * @param string $cnp
     * @return bool
     */
    public function cnpValidation(string $cnp): bool
    {
        $cnp_length = strlen($cnp);
        if($cnp_length != 13){
            return false;
        }

        for($i=0; $i<$cnp_length; $i++){
            if(!is_numeric($cnp[$i])){
                return false;
            }
        }
        return true;
    }
    //add check for prison

    /**
     * Deletes inmate with specified cnp
     *
     * @param string $cnp
     * @return boolean
     */
    public function deleteInmate(string $cnp){
        try{
            $stmt = $this->db->prepare("DELETE FROM inmate where cnp = :cnp");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * Updates the inmate with specified cnp
     *
     * @param string $cnp
     * @param array $criteria
     * @return void
     */
    public function updateByCriteria(string $cnp, array $criteria){

        $query = "UPDATE inmate SET ";
        $first = true;


        foreach ($criteria as $key => $value) {
            if (!$first) {
                $query .= ' , ';
            }

            $query .= $key . ' = :' . $key;

            $first = false;
        }

        $query .= ' WHERE cnp = :cnp';
        try{
            $stmt = $this->db->prepare($query);

            foreach ($criteria as $key => $value)
                $stmt->bindValue(':' . $key, strval($value), PDO::PARAM_STR);

            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

}

