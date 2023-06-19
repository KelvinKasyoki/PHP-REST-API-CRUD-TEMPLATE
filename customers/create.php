<?php
//error_reporting(0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod=="POST")
{

    $inputData = json_decode(file_get_contents("php://input"), true); 
    if (empty($inputData)){
        
        //Opt 1: creates using form data
          $storeCustomer = storeCustomer ($_POST);
    }
    else{
        
        //Opt 2:creates using raw data
            $storeCustomer=storeCustomer ($inputData);
    }
    echo $storeCustomer;
    
}else{
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
    
}





?>