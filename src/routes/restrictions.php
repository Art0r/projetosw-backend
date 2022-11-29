<?php
require_once "src/controllers/RestrictionController.php";

$restrictionController = new RestrictionController();

$parsed_url = parse_url($_SERVER['REQUEST_URI']);

if ($parsed_url['path'] === '/restrictions') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET["id"])) {
            $restrictionController->readOneById();
            exit();
        }
        if (isset($_GET['delete'])) {
            $restrictionController->deleteById();
            exit();
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET["id"])) {
            $restrictionController->updateById();
            exit();
        }
        $restrictionController->create();
        exit();
    }
}
