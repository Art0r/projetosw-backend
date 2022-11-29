<?php
require_once "src/controllers/SchoolsController.php";

$schoolsController = new SchoolsController();

$parsed_url = parse_url($_SERVER['REQUEST_URI']);

if ($parsed_url['path'] === '/schools') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET["id"])) {
            $schoolsController->readStudents();
            exit();
        }
        if (isset($_GET["school"])) {
            $schoolsController->readOneById();
            exit();
        }
        if (isset($_GET["email"])) {
            $schoolsController->readOneByEmail();
            exit();
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET["verify"])) {
            $schoolsController->verify();
            exit();
        }
    }
}
