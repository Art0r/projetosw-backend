<?php
require_once "src/database/connection.php";

class RestrictionModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function getRestrictionById($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("SELECT * FROM restrictions WHERE id = ?;");
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

    public function create($title, $description, $student_id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("INSERT INTO restrictions 
            (title, description, student_id) 
            VALUES (?, ?, ?)");
            $stmt->execute(
                array(
                    $title,
                    $description,
                    $student_id
                )
            );

            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function update($id, $title = "", $description = "")
    {
        $results = $this->getRestrictionById($id);

        if (!$results) {
            return false;
        }

        if ($title == "") {
            $title = $results[0]["title"];
        }

        if ($description == "") {
            $description = $results[0]["description"];
        }

        try {
            $stmt = $this->conn->getConn()->prepare("UPDATE restrictions SET title = ?, 
            description = ? WHERE id = ?;");
            $stmt->execute(array(
                $title,
                $description,
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

    public function deleteById($id)
    {
        try {
            $stmt = $this->conn->getConn()->prepare("DELETE FROM restrictions WHERE id = ?");
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
