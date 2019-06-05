<?php 

    if(isset($_POST['inputName']) && isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
        $name = $_POST['inputName'];
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];

        if(!is_string($name)) {
            echo "Nome inválido";
            exit;
        }

        if(!valid_email($email)){
            echo "Email inválido.";
            exit;
        }

        $myfile = fopen("senhas.txt", "r") or die("Unable to open file!");
        
        // Output one line until end-of-file
        $findSenha = false;
        while(!feof($myfile)) {
            $condition = $password == trim(fgets($myfile)); 
            if($condition) {
                $findSenha = true;
                $error_senha_fraca = "Sua senha é muito fraca!";
            }
        }
        
        fclose($myfile);

        if(!$findSenha) {
            require('connect.php');

            $password = password_hash($password, PASSWORD_ARGON2I);

            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO Usuario (Nome, Email, Senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            $stmt->execute();

            session_start();
            $_SESSION['userName'] = $name;
            $_SESSION['userEmail'] = $email;

            header("Location: home.php");
        }
    }

    function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    require('templates/cadastro.php')
?>