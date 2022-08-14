<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Latihan dasar layout dengan Boostrap</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="plugin/bootstrap-4.5.3-dist/css/bootstrap.min.css">
        <script src="plugin/jquery-3.5.1.min.js"></script>
        <script src="plugin/popper-1.16.0.min.js"></script>
        <Script src="plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></Script>

    </head>
<body style="background:url(images/back1.jpg);
                height:100vh; 
                background-position: top right;
                background-size: cover;">

  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card-transparent border-5 rounded-5 my-5 bg-info">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Login Admin Perpustkaaan</h5>
           
            <form method="post" action="cek_login.php">
              <div class="form-floating mb-3">
              <label for="floatingInput">Username: </label>
                <input type="text" name="user" id="user" class="form-control" id="user" placeholder="Enter Username">
              </div>
              <div class="form-floating mb-3">
                <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
              </div>

              <hr class="my-4">
              <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="submit">Login</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>