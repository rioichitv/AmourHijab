<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="docs/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="docs/fa/css/font-awesome.min.css">
  <title>Login - Amour Hijab Admin</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content"style="background-color:rgb(255, 255, 255);">

    <div class="login-box">
      <form class="login-form" action="otentikasi.php" method="POST">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Admin Login</h3>
        <div class="form-group">
          <label class="control-label">USERNAME</label>
          <input class="form-control" name="username" type="text" placeholder="Username" autofocus>
        </div>
        <div class="form-group">
          <label class="control-label">PASSWORD</label>
          <input class="form-control" name="password" type="password" placeholder="Password">
        </div>

        <div class="form-group btn-container">
          <button type="submit" class="btn btn-secondary btn-block"><i
              class="fa fa-sign-in fa-lg fa-fw"></i>Masuk</button>
        </div>
      </form>

    </div>
  </section>
  <?php include 'footer.php'; ?>

</body>

</html>