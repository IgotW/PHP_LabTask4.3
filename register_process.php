<?php
session_start();

// Get POST data
$name  = htmlspecialchars($_POST['name'] ?? '');
$age   = htmlspecialchars($_POST['age'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');

// Store in SESSION
$_SESSION['user'] = [
    'name' => $name,
    'age'  => $age,
    'email'=> $email
];

// Redirect to profile page
header("Location: profile.php?view=details");
exit();
