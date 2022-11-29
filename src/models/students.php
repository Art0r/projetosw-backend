<?php
require_once "src/database/connection.php";

class StudentsModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function getStudentAndECById($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT st.ra, re.id, re.title, re.description, re.student_id 
            FROM restrictions re 
            INNER JOIN students st ON re.student_id = st.id WHERE st.id = ?;");
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

    public function getAllStudents()
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM students");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$results) {
                return false;
            }

            return $results;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function getStudentById($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM students WHERE id = ?");
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

    public function getStudentByRa($name)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM students WHERE ra = ?");
            $stmt->execute(array($name));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                return false;
            }

            return $results;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function updateStudent($id, $name = "", $email = "", $telephone = "")
    {
        $results = $this->getStudentById($id);

        if (!$results) {
            return false;
        }

        if ($name == "") {
            $name = $results[0]["name"];
        }

        if ($email == "") {
            $email = $results[0]["email"];
        }

        if ($telephone == "") {
            $telephone = $results[0]["telephone"];
        }

        try {
            $stmt = $this->conn->getConn()->prepare("UPDATE students SET name = ?, 
                                    email = ?, telephone = ? WHERE id = ?");
            $stmt->execute(array(
                $name,
                $email,
                $telephone,
                $id
            ));
            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }


    public function createStudent($ra, $name, $email, $telephone, $password, $school_id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("INSERT INTO students (ra, name, email, telephone, password, school_id) 
                                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(array(
                $ra,
                $name,
                $email,
                $telephone,
                $password,
                $school_id
            ));

            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function deleteStudent($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute(array($id));
            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }
}
