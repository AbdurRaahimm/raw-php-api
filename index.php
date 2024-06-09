<?php
require_once 'db_con.php';

// Define your functions to handle different endpoints
function handleGetUsers() {
    global $con;
    $sql = "SELECT * FROM employee";
    $result = mysqli_query($con, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($users);
}

function handleGetUser($id) {
    global $con;
    $sql = "SELECT * FROM `employee` WHERE EMP_ID = $id";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    echo json_encode($user);
}

function handlePostUser() {
    global $con;
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $city = $data['city'];
    $salary = $data['salary'];
    $age = $data['age'];
    $sql = "INSERT INTO employee (EMP_NAME, CITY, SALARY, AGE) VALUES ('$name', '$city', '$salary', '$age')";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['message' => 'User created successfully']);
    } else {
        echo json_encode(['message' => 'User creation failed']);
    }
}

function handleDeleteUser($id) {
    global $con;
    $sql = "DELETE FROM employee WHERE EMP_ID = $id";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['message' => 'User deleted successfully']);
    } else {
        echo json_encode(['message' => 'User deletion failed']);
    }
}


function handlePutUser($id) {
    global $con;
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $city = $data['city'];
    $salary = $data['salary'];
    $age = $data['age'];
    $sql = "UPDATE employee SET EMP_NAME = '$name', CITY = '$city', SALARY = '$salary', AGE = '$age' WHERE EMP_ID = $id";
    if (mysqli_query($con, $sql)) {
        echo json_encode(['message' => 'User updated successfully']);
    } else {
        echo json_encode(['message' => 'User updation failed']);
    }
}


// Define the main function
function main() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            handleGetUser($_GET['id']);
        } else {
            handleGetUsers();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handlePostUser();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        handleDeleteUser($_GET['id']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        handlePutUser($_GET['id']);
    }


}

main();


// Get all data from the database
  // http://localhost:441/raw-php-api/

// Get data by id
   // http://localhost:441/raw-php-api/?id=1


// Post data to the database
    // http://localhost:441/raw-php-api/
    // {
    //   "name": "John Doe",
    //   "city": "New York",
    //   "salary": 50000,
    //   "age": 30
    // }
    // Method: POST

// Delete data by id
    // http://localhost:441/raw-php-api/?id=1
    // Method: DELETE

    
// Update data by id
    // http://localhost:441/raw-php-api/?id=1
    // {
    //   "name": "John Doe",
    //   "city": "New York",
    //   "salary": 50000,
    //   "age": 30
    // }
    // Method: PUT








