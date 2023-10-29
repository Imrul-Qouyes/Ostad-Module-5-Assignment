<?php
session_name('myproject');
session_start(["cookie_lifetime" => 300]);

$usersDatafile = "./data/usersdata.json";

$usersData = json_decode( file_get_contents( $usersDatafile ), true );

$errorMessage1 = false;

if ( isset( $_POST["signin"] ) ) {

      $email = $_POST['email'];
      $password = $_POST['password'];
      $rememberme = $_POST["remember"] ?? '';

      if ( empty( $email ) || empty( $password ) ) {
        $errorMessage1 = "Please Fill Up All The Fields.";
      } else {

       foreach($usersData as $key => $user){
          if ($usersData[$key]['email'] == $email && $usersData[$key]['password'] == $password){
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $usersData[$key]["role"];
            $_SESSION["remember"] = $rememberme;
            $_SESSION["username"] = $usersData[$key]["username"];
            $_SESSION["password"] = $usersData[$key]['password'];
            header( 'location: index.php');
          }else {
            $errorMessage1 = 'Incorrect email address or password!!!';
          }
        }
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>SIGN IN</title>
  </head>
  <body>
    <div class="container mt-5">
      <h1 class="text-center mb-5">SIGN IN</h1>

      <form action="login.php" method="POST" class="mx-auto col-6">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php if ( isset( $_COOKIE["email"] ) ) {echo $_COOKIE["email"]; } ?>" >
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="exampleInputPassword1" value="<?php if ( isset( $_COOKIE["password"] ) ) {echo $_COOKIE["password"]; } ?>" >
        </div>
        <div class="mb-3 form-check">
         <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
         <label class="form-check-label" for="exampleCheck1">Remember me</label>
        </div>
        <?php if($errorMessage1 == true) { ?>
         <p class="alert alert-danger text-center"><strong><?php echo $errorMessage1; ?></strong></p>
         <?php } ?>
         <div class="d-flex"><button type="submit" name="signin" class="btn btn-primary col-5 mx-auto mt-3">Sign In</button></div>
        </form>
        <p class="mt-3 text-center"><strong>Don't Have an Account? Sign Up - </strong><a href="sign_up.php"><strong>Here</strong></a></p>
    </div>
  </body>
</html>