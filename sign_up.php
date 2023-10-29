<?php

$usersDatafile = "./data/usersdata.json";
$usersData = file_exists( $usersDatafile ) ? json_decode( file_get_contents( $usersDatafile ), true ) : array();

$signupcomplete = false;
$errorMessage1 = false;

if ( isset( $_POST['signup'] ) ) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $errorMessage1 = "Please fill up all the fields.";
    } else {
        if ( isset( $usersData[$email] ) ) {
            $errorMessage1 = " Email already exists";
        } else {

            $usersData[$email] = [
                "username" => $username,
                "password" => $password,
                "email"    => $email,
                "role"     => "",
            ];
            file_put_contents( $usersDatafile, json_encode( $usersData, JSON_PRETTY_PRINT ) );
            $signupcomplete = true;

        }

    }

}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
  </head>
  <body>
    <div class="contianer p-5 mt-3 ">
      <h1 class ="text-center mb-4" >SIGN UP</h1>
      <form class = "col-6 mx-auto" action="sign_up.php" method="POST" >
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="userName" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>
        <div class="d-flex flex-column justify-content-center">
          <div><?php if ( $errorMessage1 == true ) { ?>
          <p class="alert alert-danger text-center"><strong><?php echo $errorMessage1; ?></strong></p>
          <?php }?>
          <input type="hidden" name="role" value="">
          <?php if ( $signupcomplete ) { ?>
          <p class="alert alert-success text-center"><strong>Sign up Complete.</strong> <span><a href="login.php">Sign In</a></span> </p>
          <?php } ?>
          </div>
          <div class="d-flex justify-content-center">
          <button type="submit" name="signup" class="btn btn-warning mb-5">Sign Up</button>
          </div>
        </div>
      </form>

      <p class = "col-6 mx-auto text-center"><strong>Alreay Have An Account? </strong> <a href="login.php"><strong>Sign In</strong></a></p>
    </div>

  </body>
</html>


