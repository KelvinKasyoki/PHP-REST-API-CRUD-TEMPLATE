<?php

//This api program Updates data(singele record) from MySql DB
    error_reporting(0);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    include('function.php');

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod == "PUT") {

        $inputData = json_decode(file_get_contents("php://input"), true);
        if (empty($inputData)) {

        //Opt 1: update using form data
        $updateCustomer = updateCustomer($_POST,$_GET);
        } else {

        //Opt 2:update using raw data
        $updateCustomer = updateCustomer($inputData,$_GET);
        }
        echo $updateCustomer;
    } else {
        $data = [
            'status' => 405,
            'message' => $requestMethod . 'Method Not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }





    ?>