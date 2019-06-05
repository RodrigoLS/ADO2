<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/login.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">Cadastro</h5>
              <form class="form-signin" method="POST">
                
                <div class="form-label-group">
                    <input type="text" name="inputName" id="inputName" class="form-control" placeholder="Nome" required autofocus>
                    <label for="inputName">Nome</label>
                </div>
                
                <div class="form-label-group">
                  <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required>
                  <label for="inputEmail">Email</label>
                </div>
                
                <div class="form-label-group">
                  <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Senha</label>
                </div>

                <?php 
                  if(isset($error_senha_fraca)) {
                    echo "<div class='alert alert-danger' role='alert'>" . $error_senha_fraca . "</div>";
                  };
                ?>
  
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Cadastrar</button>
                <hr class="my-4">
              </form>

              <a href="index.php">Já possuo uma conta.</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>