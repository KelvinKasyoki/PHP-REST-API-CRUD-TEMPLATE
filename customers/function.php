<?php
//Shift + Alt + F can also be used for formatting

require_once '../includes/dbcon.php';

//This function is used for fetching data records from the db
function getCustomerList()
{
    global $conn;


    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        //check if the query returned a result
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

//This function is used for inserting/storing data records from the db
function storeCustomer($customerInput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    //validation
    if (empty(trim($name))) {



        return error422('Enter your name');
    } else if (empty(trim($email))) {


        return error422('Enter your email');
    } else if (empty(trim($phone))) {



        return error422('Enter your phone');
    } else {
        $query = "INSERT INTO customers(name,email,phone) VALUES('$name','$email','$phone')";
        //executes the query and returns the $result        
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'customer created successfully',
            ];
            header("HTTP/1.0 201 created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}


//input validation=>displaying errors
function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 unprocessable entity");
    echo json_encode($data);
    exit();
}


//This function is used for reading single data from the db
function getCustomer($customerParams)
{
    global $conn;

    if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }

    //sanitize the the data id
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    //get the customer from the database
    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";

    //execute the query above to get the customer
    $result = mysqli_query($conn, $query);
    if ($result) {

        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_array($result);

            $data = [
                'status' => 200,
                'message' => 'Customer Fetched successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 sucess");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

//This function is used for updating single data from the db
function updateCustomer($customerInput, $customerParams)
{
    global $conn;


    if (!isset($customerParams['id'])) {

        return error422('Customer id not found in the URL');
    } elseif($customerParams['id'] ==null ) {

        return error422('Enter the customer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    //validation
    if (empty(trim($name))) {



        return error422('Enter your name');
    } else if (empty(trim($email))) {


        return error422('Enter your email');
    } else if (empty(trim($phone))) {



        return error422('Enter your phone');
    } else {

        $query = "UPDATE customers SET name='$name',email='$email',phone='$phone' WHERE id='$customerId' LIMIT 1 ";
       
        //executes the query and returns the $result        
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'customer updated successfully',
            ];
            header("HTTP/1.0 200 created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

//This function is used for deleting single data from the db
function deleteCustomer($customerDetails)
{
    global $conn;

    if (!isset($customerDetails['id'])) {

        return error422('Customer id not found in the URL');
    } elseif ($customerDetails['id'] == null) {

        return error422('Enter the customer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerDetails['id']);


    $query = "DELETE FROM customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if($result){
        $data = [
            'status' => 200,
            'message' => 'Customer Deleted sucessfully',
        ];
        header("HTTP/1.0 200  OK");
        return json_encode($data);
    }
    else{
        $data = [
            'status' => 404,
            'message' => 'Customer not found',
        ];
        header("HTTP/1.0 404  Not Found");
        return json_encode($data); 
    }

        

}

?>