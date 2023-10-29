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

$success = false;
$errorMessage1 = false;

$username = $_GET['username'] ?? '';
$email = $_GET['email'] ?? '';
$role = $_GET['role'] ?? '';
$password = $_GET['password'] ?? '';

if ( isset( $_POST['update'] ) ) {

    $updateUserType = $_POST['usertype'];
    $updateUserName = $_POST['username'];
    $updateEmail = $_POST['email'];
    $updatePassword = $_POST['password'];

    foreach ( $usersData as $key => $entry ) {

        if ( $usersData[$key]['email'] == $updateEmail ) {

            $usersData[$key]['username'] = $updateUserName;
            $usersData[$key]['password'] = $updatePassword;
            $usersData[$key]['email'] = $updateEmail;
            $usersData[$key]['role'] = $updateUserType;

        }

    }

    file_put_contents( "./data/usersdata.json", json_encode( $usersData, JSON_PRETTY_PRINT ) );

    $success = true;

    if ( $success ) {
        header( 'location: index.php' );
    }

}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User Panel</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">

  </head>
  <body>
    <div class="contianer p-5 mt-3 ">
      <h1 class ="text-center mb-4" >Edit Users</h1>

      <form class = "col-6 mx-auto" action="edit_user.php" method="POST" >
        <div class="mb-3">
         <label for="usertype" class="form-label">UserType</label>
          <select class = "col-6 mx-auto form-select bg-red" name="usertype" id="dropdown1" >
          <?php if ( $role == 'user' ) { ?>
            <option value="user" selected><?php echo $role; ?></option>
            <option value="admin">admin</option>
            <option value="manager">manager</option>
            <?php } else if ( $role == 'admin' ) { ?>
            <option value="admin"><?php echo $role; ?></option>
            <option value="user">user</option>
            <option value="manager">manager</option>
            <?php } else if ( $role == 'manager' ) { ?>
            <option value="manager"><?php echo $role; ?></option>
            <option value="admin">admin</option>
            <option value="user">user</option>
            <?php } else { ?>
            <option value="admin">admin</option>
            <option value="manager">manager</option>
            <option value="user">user</option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" value="<?php echo $username; ?>" >
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $email; ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="text" class="form-control" name="password" id="exampleInputPassword1" value="<?php echo $password; ?>" >
        </div>
        <?php if ( $errorMessage1 == true ) {?>
            <div><p class="text-danger"><strong><?php echo $errorMessage1; ?></strong></p></div>
        <?php }?>
        <button type="submit" name="update" class="btn btn-warning mb-5">Update</button>
        <button class="btn btn-danger mb-5"><a class="text-decoration-none text-black" href="index.php">Cancel</a></button>

      </form>
    </div>
  </body>
</html>