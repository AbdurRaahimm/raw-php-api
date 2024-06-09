<?php

$con = mysqli_connect("localhost","root","","cse208");

// Check connection with json response
if (!$con) {
    echo json_encode(['message' => 'Database connection Failed']);
    exit;
}
