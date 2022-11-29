<?php
require_once "src/database/connection.php";

class SchoolsModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function getSchoolById($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM schools WHERE id = ?");
            $stmt->execute(array($id));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                return false;
            }

            return $results;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function getSchoolsByEmail($email)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM schools WHERE email = ?");
            $stmt->execute(array($email));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                return false;
            }

            return $results;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function getStudentsBySchool($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT sc.name, sc.email, st.id, st.ra, st.name, st.email, st.telephone 
            FROM schools sc INNER JOIN students st ON sc.id = st.school_id WHERE sc.id = ?");
            $stmt->execute(array($id));
            $results = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
            if (!$results) {
                return false;
            }

            return $results;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }
}
