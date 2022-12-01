<?php
require_once "src/database/connection.php";
require_once "src/models/schools.php";

class SchoolsController
{
    private $schoolsModel;

    public function __construct()
    {
        $this->schoolsModel = new SchoolsModel();
    }

    public function readStudents()
    {
        try {
            $schools = $this->schoolsModel->getStudentsBySchool($_GET['id']);
            if ($schools) {
                echo json_encode($schools);
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhum livro foi carregado");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function readOneById()
    {
        try {
            $schools = $this->schoolsModel->getSchoolById($_GET['school']);
            if ($schools) {
                echo json_encode($schools);
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhum livro foi carregado");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function readOneByEmail()
    {
        try {
            $student = $this->schoolsModel->getSchoolsByEmail($_GET["email"]);
            if ($student) {
                echo json_encode($student);
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhum livro foi carregado");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function verify()
    {
        try {
            $email = $_GET['verify'];
            $password = $_POST['password'];

            $school = $this->schoolsModel->getSchoolsByEmail($email);

            if ($school) {
                if (password_verify($password, $school[0]["password"])) {
                    echo json_encode(array('valid' => true, 'password' => $school[0]["password"]));
                    http_response_code(200);
                    exit();
                }
                echo json_encode(false);
                http_response_code(403);
                exit();
            }

            echo json_encode(false);
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }
}
