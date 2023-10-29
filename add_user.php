<?php
session_name( 'myproject' );
session_start( ["cookie_lifetime" => 300] );

if ( !isset( $_SESSION["email"] ) ) {
    header( "location: login.php" );
}

if ( $_SESSION['role'] == 'user' || $_SESSION['role'] == 'manager' || $_SESSION['role'] == '' ) {
    header( "location: index.php" );
}

$usersDatafile = "./data/usersdata.json";
$usersData = json_decode( file_get_contents( $usersDatafile ), true );

$errorMessage1 = false;
$success = false;

if ( isset( $_POST['save'] ) ) {

    $userName = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'] ?? "";
    $userType = $_POST['usertype'];

    if ( empty( $userName ) || empty( $password ) || empty( $email ) || empty( $userType ) ) {
        $errorMessage1 = "Please fill up all the fields!!";
    } else {
        if ( isset( $usersData[$email] ) ) {
            $errorMessage1 = " Email already exists!!!";
        } else {
            $usersData[$email] = [
                "username" => $userName,
                "password" => $password,
                "email"    => $email,
                "role"     => $userType,
            ];
            file_put_contents( $usersDatafile, json_encode( $usersData, JSON_PRETTY_PRINT ) );
            $success = true;
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User Panel</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="contianer p-5 mt-3 ">
      <h1 class ="text-center mb-4" >Add Users</h1>
      <form class = "col-6 mx-auto" action="add_user.php" method="POST" >
        <div class="mb-3">
          <label for="usertype" class="form-label">UserType</label>
          <select class = "col-6 mx-auto form-select bg-red" name="usertype" id="dropdown1" >
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="user">User</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="userName" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" >
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="exampleInputPassword1" >
        </div>
        
        <?php if ( $errorMessage1 == true ) { ?>
        <p class="alert alert-danger text-center"><strong><?php echo $errorMessage1; ?></strong></p>
        <?php } ?>
        <?php if ( true == $success ) { ?>
        <p class="alert alert-success text-center"><strong>Saved Successfully.</strong> <span><a class="text-black" href="index.php">Go Back</a></span></p>
        <?php } ?>

        <div class="mx-auto d-flex justify-content-center">
          <div><button type="submit" name="save" class="btn btn-warning mb-5">Save</button>
          </div>
          <div class="p-2"><a class="text-decoration-none text-white bg-dark p-2 rounded-2" href="index.php">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>