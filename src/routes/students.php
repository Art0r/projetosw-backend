<?php
require_once "src/controllers/StudentsController.php";

$studentsController = new StudentsController();

$parsed_url = parse_url($_SERVER['REQUEST_URI']);

if ($parsed_url['path'] === '/students') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET['sendmail'])) {
            $studentsController->sendPasswordRaEmail();
            exit();
        }

        if (isset($_GET['verify'])) {
            $studentsController->verify();
            exit();
        }
        if (isset($_GET["id"])) {
            $studentsController->update();
            exit();
        }
        $studentsController->create();
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET["delete"])) {
            $studentsController->delete();
            exit();
        }
        if (isset($_GET["ra"])) {
            $studentsController->readOneByRa();
            exit();
        }
        if (isset($_GET["id"])) {
            $studentsController->readOneById();
            exit();
        }
        if (isset($_GET["restrictions"])) {
            $studentsController->readOneWithECsById();
            exit();
        }
        $studentsController->readAll();
        exit();
    }
}
