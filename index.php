<?php
require_once "vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once "src/routes/students.php";
require_once "src/routes/schools.php";
require_once "src/routes/restrictions.php";

http_response_code(400);
echo 'Invalid Request';
