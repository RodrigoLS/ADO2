<?php
    session_start();

    $loginTime = $_SESSION['loginTime'];
    $logoutTime = time();


    $timestamp = $logoutTime - $loginTime;
    $time = date('i:s', $timestamp);

    $message = 'O usuário ' . $_SESSION['userName'] . "(" . $_SESSION['userEmail'] . ")" . ' fez logout ' . $time . " minutos após o login.\n";
    
    $fp = fopen('log.txt', 'a+');
    fwrite($fp, $message);
    fclose($fp);

    if($timestamp > (24*60)) {
        sendEmail();
    }
    
    session_destroy();
    header("Location: index.php");


    function sendEmail() {
        $from = "daniel@gmail.com";
        $to = "daniel@gmail.com";
        $subject = "Logado a mais de 24 horas";
        $message = "Aviso:\n O usuário " . $_SESSION['userName'] . "(" . $_SESSION['userEmail'] . ")" . " ficou mais de 10 horas logado.\n É recomendado que medidas sejam tomadas.";
        $headers = "From:" . $from;
        mail($to,$subject,$message, $headers);
        echo "The email message was sent.";
    }
?>