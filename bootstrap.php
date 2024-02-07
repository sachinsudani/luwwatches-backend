<?php

    require "vendor/autoload.php";
    use Dotenv\Dotenv;
    use Src\db\DatabaseConnector;

    $dotenv = new Dotenv(__DIR__);
    $dotenv -> load();

    $con = DatabaseConnector::get_connection();