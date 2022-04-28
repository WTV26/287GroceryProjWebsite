<?php
session_start();
if (@$_SESSION['AD'] != "true" or empty($_SESSION['AD'])){
    header('location: ../../index.php?log=in');
    exit();
    }else{
        header("Location: EGG-Backstore-Edit_User.php");
    }
    
$users=simplexml_load_file("../../XML-files/users.xml") or die("Error. File not found.");

if (isset($_POST['ID'])){
    $id = $_POST['ID'];
    editUser($id);
} else {
    addNew(idDecider());
}

function idDecider(){
    global $users;
    $id = 0 ;
    $idsTaken = array();

    foreach($users -> user as $user){
        array_push($idsTaken, $user['ID']);
    }

    foreach($idsTaken as $idTaken){
        if(in_array($id, $idsTaken)){
            $id++;
        }
    } 

    return $id;
}

function addNew($id){
    global $users;

    if (trim($_POST['username']) == '' or trim($_POST['password'])  == '' or trim($_POST['email'])  == '' ){
        return;
    }

    if (!checkEmail($id) or !checkUsername($id)){
        return;
    }

    $user = $users -> addChild('user');
    $user -> addAttribute('ID', $id);
    $user -> addChild('username', $_POST['username']);
    $user -> addChild('password', password_hash($_POST['password'], PASSWORD_DEFAULT));
    $user -> addChild('email', $_POST['email']);
    $user -> addChild('address', $_POST['address']);
    $user -> addChild('isAdmin', isset($_POST['isAdmin'])? $_POST['isAdmin'] : 'false');
    $user -> addChild('dateOfBirth', $_POST['birthdate']);
    
}

function editUser($id){
    global $users;

    if (!checkEmail($id) or !checkUsername($id)){
        return;
    }
    foreach($users -> user as $user){
        if ($user['ID'] == $id){
            $user -> username = $_POST['username'];
            $user -> password = (trim($_POST['password']) === "")? $user -> password : password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user -> email = $_POST['email'];
            $user -> address = $_POST['address'];
            $user -> isAdmin = ($_POST['isAdmin']) == "on"? 'true' : 'false';
            $user -> dateOfBirth = $_POST['birthdate'];
        }
    }
}

function checkEmail($id){
    global $users;
    foreach($users -> user as $user){
        if ($user -> email == $_POST['email'] and $user['ID'] != $id){
            return false;
        }
    }
    return true;
}

function checkUsername($id){
    global $users;
    foreach ($users -> user as $user){
        if ($user -> username == $_POST['username'] and $user['ID'] != $id){
            return false;
        }
    }
    return true;
}
    $_POST = array();
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($users->asXML());
    $dom->save("../../XML-files/users.xml");
?>