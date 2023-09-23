<?php
include "config.php";

if (isset($_POST['auth'])) { 

    $loginRequest = json_decode($_POST['auth']);
    $response = array();


    $sql = "SELECT * FROM " . TBL_USERS . " WHERE username = '" . $loginRequest->username . "'";
    $results = $connection->query($sql);

    $users = array();

    $response = createResponse(401, "error", "Account doesn't exist");
    
    while ($row = $results->fetch_assoc()) {
        array_push($users, $row);
        if (password_verify($loginRequest->password, $row['password'])) {
            $response = createResponse(200, "Succesful", "Successful");
            $_SESSION['logged-in-user'] = $row['id'];
            break;
        }
    }
    
    

    // foreach ($users as $user) {
    //     //db vs sa input
    //     if (password_verify($loginRequest->password, $user['password'])) {
    //         $response = createResponse(200, "Succesful", "Successful");
    //         $_SESSION['logged-in-user'] = $user->id;
    //     } else {
    //         $response = createResponse(401, "Error", "Wrong Password please try again");
    //     }
    // }
    http_response_code($response['status']);
    echo json_encode($response);
}