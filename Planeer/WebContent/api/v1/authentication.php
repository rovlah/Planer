<?php 
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["ime"] = $session['ime'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'sifra'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $sifra = $r->customer->sifra;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select uid,ime,sifra,email,stvoreno from prijava where telefon='$email' or email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['sifra'],$sifra)){
        $response['status'] = "success";
        $response['message'] = 'Uspjesna prijava';
        $response['ime'] = $user['ime'];
        $response['uid'] = $user['uid'];
        $response['email'] = $user['email'];
        $response['createdAt'] = $user['stvoreno'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['email'] = $email;
        $_SESSION['ime'] = $user['ime'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Prijava neuspjela';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'Korisnik ne postoji';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'ime', 'sifra'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $telefon = $r->customer->telefon;
    $ime = $r->customer->ime;
    $email = $r->customer->email;
    $adresa = $r->customer->adresa;
    $sifra = $r->customer->sifra;
    $isUserExists = $db->getOneRecord("select 1 from prijava where telefon='$telefon' or email='$email'");
    if(!$isUserExists){
        $r->customer->sifra = passwordHash::hash($sifra);
        $tabble_name = "prijava";
        $column_names = array('telefon', 'ime', 'email', 'sifra', 'grad', 'adresa');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Korisnicki racun je uspjesno kreiran";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['telefon'] = $telefon;
            $_SESSION['ime'] = $ime;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Neuspjela registracija, pokusajte ponovo";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "Korisnik s ovim e-mail-om ili telefonom postoji";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Uspjesna odjava";
    echoResponse(200, $response);
});
?>