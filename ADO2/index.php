<?php 


if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
    unset($limitError);
    
    require('connect.php');

    $ipUser = $_SERVER['REMOTE_ADDR'];

    $sql = "SELECT Email, AcessoNegadoHorario, IP, Tentativas FROM Acessos WHERE Email = ? AND IP = ?";

    
    if (!$stmt = $conn->prepare($sql)) {
        die ("Error prepare: " . $conn->error);
    }

    $stmt->bind_param("ss",$login,$ipUser);

    $login = $_POST['inputEmail'];
    $senha = $_POST['inputPassword'];
    
    $ms = microtime(true);
    $stmt->execute();
    $ms = microtime(true) - $ms;
    generateLogSqlTime("O tempo do GET: ", $ms);
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $timestamp = getTimestamp();
            if($row['Tentativas'] <= 5 || $row['AcessoNegadoHorario'] + (5*60) < $timestamp) {
                login($login);
            } else {
                $limitError = "Você tentou acessar muitas vezes sem sucesso. Aguarde 5 minutos para tentar novamente.";
                sendEmail($ipUser);
            }    
        }
    } else {
        login($login);
    }

    $conn->close();
}

function login() {
    require('connect.php');

    $sql = "SELECT Nome, Email, Senha FROM Usuario WHERE Email = ?";

    if (!$stmt = $conn->prepare($sql)) {
        die ("Error prepare: " . $conn->error);
    }

    $stmt->bind_param("i",$login);

    $login = $_POST['inputEmail'];

    $ms = microtime(true);
    $stmt->execute();
    $ms = microtime(true) - $ms;
    generateLogSqlTime("Tempo do GET", $ms);

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cont = 0;
        while($row = $result->fetch_assoc()) {
            if(password_verify($_POST['inputPassword'], $row['Senha'])) {
                session_start();
                $_SESSION['userName'] = $row['Nome'];
                $_SESSION['userEmail'] = $row['Email'];
                $_SESSION['loginTime'] = time();

                header("Location: home.php");
            } else {
                if($cont == 0) {
                    error_login($login);
                }
            }

            $cont++;
        }
    } else {
        error_login($login);
    }

    $conn->close();
}


function error_login($email) {
    require('connect.php');

    $ipUser = $_SERVER['REMOTE_ADDR'];
        
    $sql = "SELECT Email, AcessoNegadoHorario, IP, Tentativas FROM Acessos WHERE Email = ? AND IP = ?";

    if (!$stmt = $conn->prepare($sql)) {
        die ("Error prepare: " . $conn->error);
    }

    $stmt->bind_param("is", $email, $ipUser);

    $ms = microtime(true);
    $stmt->execute();
    $ms = microtime(true) - $ms;
    generateLogSqlTime("Tempo do GET:", $ms);

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cont = 0;
        while($row = $result->fetch_assoc()) {
            $userEmail =  mysqli_real_escape_string($conn, $row['Email']);
            $acessoNegadoHorario = $row['AcessoNegadoHorario'];
            $ipUser = $row['IP'];
            $tentativas = $row['Tentativas'];


            $timestamp = getTimestamp();
           
            if($acessoNegadoHorario + (5*60) > $timestamp) {
                incrementAttempts($userEmail, $tentativas);
            } else {
                resetAttemptsAndTime($userEmail);
            }
            
            $cont++;
        }
    } else {
        createAccessLog($email);
    }

    $conn->close();
}

function incrementAttempts($email, $tentativas) {
    var_dump("increment");
    require('connect.php');
    $tentativas++;
    $sql = "UPDATE Acessos SET Tentativas = $tentativas WHERE Email ='" . $email . "'";

    $ms = microtime(true);
    if ($conn->query($sql) === TRUE) {
        $ms = microtime(true) - $ms;
        generateLogSqlTime("O tempo do UPDATE", $ms);
    }
 
    $conn->close();
}

function resetAttemptsAndTime($email) {
    require('connect.php');

    $timestamp = getTimestamp();

    // $email = mysqli_real_escape_string($conn, $email);
    $sql = "UPDATE Acessos SET Tentativas = 1, AcessoNegadoHorario = $timestamp  WHERE Email ='" . $email . "'";

    $ms = microtime(true);
    if ($conn->query($sql) === TRUE) {
        $ms = microtime(true) - $ms;
        generateLogSqlTime("tempo do UPDATE:", $ms);
        
    }

    $conn->close();
}

function createAccessLog($userEmail) {
    require('connect.php');

    $timestamp = getTimestamp();
    $ipUser = $_SERVER['REMOTE_ADDR'];
    $tentativas = 1;    

    // prepare and bind
    
    $stmt = $conn->prepare("INSERT INTO Acessos (Email, AcessoNegadoHorario, IP, Tentativas) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $userEmail, $timestamp, $ipUser, $tentativas);

    $ms = microtime(true);
    $stmt->execute();
    $ms = microtime(true) - $ms;
    generateLogSqlTime("Tempo de INSERT", $ms);
}

function getTimestamp() {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date_create();
    $timestamp = date_timestamp_get($data);

    return $timestamp;
}

function generateLogSqlTime($message, $ms) {
    $fp = fopen('log.txt', 'a+');
    fwrite($fp, $message . ' ' . ($ms * 1000) . " ms\n" );
    fclose($fp);
}

function sendEmail($ipUser) {
    $from = "emaildaniel@gmail.com";
    $to = "emaildaniel@gmail.com";
    $subject = "Excedeu o número de tentativas";
    $message = "Aviso:\n O IP " . $ipUser . " excedeu o número de tentativas.";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
}


require('templates/index.php');
?>