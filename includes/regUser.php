<?php
require_once "header.php";

if (!empty($_POST)) {
    $data = $_POST;
} else {
    print ("Няма предадени данни!");
}

$invite_dt = date("Y-m-d H:i:s", time());
$isAdmin = 2;

$query = "INSERT INTO users(username, password_hashed, first_name, last_name, email, user_group, invite_dt, status) 
          VALUES (?,?,?,?,?,?,?,1)";

if (!$stmt = $DBH->prepare($query)) {
    print("Грешна заявка: $query");
    exit;
}

$password = md5($data['password'] . $secretKey);

if (!$stmt->bind_param("sssssis", $data["username"], $password, $data["first_name"],
    $data["last_name"], $data["email"], $isAdmin, $invite_dt)) {
    print("Не се байндва!");
    exit;
}

if (!$stmt->execute()) {
    print("Не се изпълнява заявката! " . $DBH->error);
    header("Location: register.php?error=2");
    exit;
}

print '<body><script type="text/javascript">
 
    var url = "login.php";
    swaHelloNewUser();
    setTimeout(function () {
        window.location = url;
    }, 2000);
    </script></body>';


