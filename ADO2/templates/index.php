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

              <?php 
                if(isset($limitError)) {
                  echo "<div class='alert alert-danger' role='alert'>" . $limitError . "</div>";
                };
              ?>

              <h5 class="card-title text-center">Login</h5>
              <form class="form-signin" method="POST">

                <div class="form-label-group">
                  <label for="inputEmail">Email</label>
                  <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="email@email.com" required autofocus>
                </div>
  
                <div class="form-label-group">
                  <label for="inputPassword">Password</label>
                  <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Senha" required>
                </div>
  
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>
                <hr class="my-4">
              </form>

              <a href="cadastro.php">Criar uma conta.</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>