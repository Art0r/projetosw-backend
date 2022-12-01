<?php
require_once "src/database/connection.php";
require_once "src/models/students.php";
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

class StudentsController
{
    private $studentsModel;

    public function __construct()
    {
        $this->studentsModel = new StudentsModel();
    }

    public function readOneWithECsById()
    {
        try {
            $student = $this->studentsModel->getStudentAndECById($_GET["restrictions"]);
            if ($student) {
                echo json_encode($student);
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhuma restrição foi carregada");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function update()
    {
        try {
            $name = "";
            $email = "";
            $telephone = "";

            if (isset($_POST["name"])) {
                $name = $_POST["name"];
            }
            if (isset($_POST["email"])) {
                $email = $_POST["email"];
            }
            if (isset($_POST["telephone"])) {
                $telephone = $_POST["telephone"];
            }

            $student = $this->studentsModel->updateStudent($_GET["id"], $name, $email, $telephone);
            if ($student) {
                echo json_encode("Um estudante foi modificado com sucesso");
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhum estudante foi atualizado");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function sendPasswordRaEmail()
    {
        $password = $_POST['password'];
        $ra = $_POST['ra'];

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "projetoalimentosrestricao@gmail.com";
        $mail->Password   = "nzsasvlrkoqitvyj";
        $mail->IsHTML(true);
        $mail->AddAddress("arthur0139@gmail.com");
        $mail->SetFrom("projetoalimentosrestricao@gmail.com");
        $mail->Subject = "Senha e ra para login";
        $content = "<p>
        Aqui está sua senha e ra para fazer o login:
        <h1>Senha: $password</h1>
        <h1>RA: $ra</h1>
        </p>";
        $mail->MsgHTML($content);

        if ($mail->Send()) {
            echo json_encode("Email enviado com sucesso");
            http_response_code(200);
            exit();
        } else {
            echo json_encode("Ocorreu um problema ao enviar o email");
            http_response_code(500);
            exit();
        }
    }

    public function create()
    {
        try {
            $ra = $_POST['ra'];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $telephone = $_POST["telephone"];
            $school_id = $_POST["school_id"];
            $password_without_hash = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 12);
            $password = password_hash($password_without_hash, PASSWORD_DEFAULT);

            $student = $this->studentsModel->createStudent(
                $ra,
                $name,
                $email,
                $telephone,
                $password,
                $school_id
            );

            if ($student) {
                $result = array(
                    "msg" => "Um estudante foi criado",
                    "pwd" => $password_without_hash
                );
                echo json_encode($result);
                http_response_code(200);
                exit();
            }
            $response = array(
                "msg" => "Nenhum estudante foi criado",
                "pwd" => 0
            );
            echo json_encode($response);
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
            $ra = $_GET['verify'];
            $password = $_POST['password'];

            $student = $this->studentsModel->getStudentByRa($ra);

            if ($student) {
                if (password_verify($password, $student[0]["password"])) {
                    echo json_encode(array('valid' => true, 'password' => $student[0]["password"]));
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

    public function readAll()
    {
        try {
            $student = $this->studentsModel->getAllStudents();
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

    public function readOneById()
    {
        try {
            $student = $this->studentsModel->getStudentById($_GET["id"]);
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

    public function readOneByRa()
    {
        try {
            $student = $this->studentsModel->getStudentByRa($_GET["ra"]);
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

    public function delete()
    {
        try {
            $student = $this->studentsModel->deleteStudent($_GET["delete"]);
            if ($student) {
                echo json_encode("Um estudante foi deletado com sucesso");
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhum estudante foi deletado");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }
}
