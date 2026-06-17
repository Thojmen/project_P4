<?php

session_start();

include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$email);
$stmt->execute();

$result = $stmt->get_result();

if($user = $result->fetch_assoc()){

    if(password_verify(
        $password,
        $user['password']
    )){

        $_SESSION['user_id'] = $user['id'];

        header("Location: home.php");
        exit;
    }
}

echo "Onjuiste gegevens";