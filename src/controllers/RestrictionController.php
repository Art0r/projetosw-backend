<?php
require_once "src/database/connection.php";
require_once "src/models/restriction.php";

class RestrictionController
{
    private $restrictionModel;

    public function __construct()
    {
        $this->restrictionModel = new RestrictionModel();
    }

    public function readOneById()
    {
        try {
            $restriction = $this->restrictionModel->getRestrictionById($_GET["id"]);
            if ($restriction) {
                echo json_encode($restriction);
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

    public function create()
    {
        try {
            $restriction = $this->restrictionModel->create(
                $_POST['title'],
                $_POST['description'],
                $_POST['student_id']
            );
            if ($restriction) {
                echo json_encode("Uma restrição foi adicionada com sucesso");
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhuma restrição foi criada");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function updateById()
    {
        try {
            $title = "";
            $description = "";

            if (isset($_POST["title"])) {
                $title = $_POST["title"];
            }
            if (isset($_POST["description"])) {
                $description = $_POST["description"];
            }

            $restriction = $this->restrictionModel->update(
                $_GET['id'],
                $title,
                $description,
            );

            if ($restriction) {
                echo json_encode("Uma restrição foi modificada com sucesso");
                http_response_code(200);
                exit();
            }

            echo json_encode("Nenhuma restrição foi atualizada");
            http_response_code(404);
            exit();
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }

    public function deleteById()
    {
        try {
            $restriction = $this->restrictionModel->deleteById($_GET["delete"]);
            if ($restriction) {
                echo json_encode("Uma restrição foi deletada com sucesso");
                http_response_code(200);
                exit();
            }
            echo json_encode("Nenhuma restrição foi deletada");
            http_response_code(404);
        } catch (\Throwable $th) {
            echo json_encode("Ocorreu um problema na requisição");
            http_response_code(500);
            exit();
        }
    }
}
