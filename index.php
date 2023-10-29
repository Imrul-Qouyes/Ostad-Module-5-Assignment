<?php
session_name( 'myproject' );
session_start( ["cookie_lifetime" => 300] );

if ( !isset( $_SESSION["email"] ) ) {
    header( "location: login.php" );
}

if ( !empty( $_SESSION["remember"] ) ) {
    setcookie( "email", $_SESSION["email"], time() + 3600 );
    setcookie( "password", sha1( $_SESSION["password"] ), time() + 3600 );
} else {
    setcookie( "email", "" );
    setcookie( "password", "" );
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <?php $username = $_SESSION['username'] ?? "";

      if ( $_SESSION["role"] == 'admin' || $_SESSION["role"] == 'manager' || $_SESSION['role'] == 'user' || $_SESSION['role'] == '' ) {

    ?>
    <?php if ( $_SESSION["role"] == 'admin' ) { ?>
    <title>Admin Panel</title>
    <?php } else if ( $_SESSION["role"] == 'manager' ) { ?>
    <title>Manager Panel</title>
    <?php } else if ( $_SESSION["role"] == 'user' ) { ?>
    <title>User Panel</title>
    <?php } else { ?>
    <title>Newbie Panel</title>
    <?php } ?>
  </head>
  <body>
    <div class="container mt-5">
      <?php if ( $_SESSION["role"] == 'admin' ) { ?>
      <h1 class="text-center mb-5"><u>Admin Dashboard</u></h1>
      <?php } else if ( $_SESSION["role"] == 'manager' ) { ?>
      <h1 class="text-center mb-5"><u>Manager Dashboard</u></h1>
      <?php } else if ( $_SESSION["role"] == 'user' ) { ?>
      <h1 class="text-center mb-5"><u>User Dashboard</u></h1>
      <?php } else { ?>
      <h1 class="text-center mb-5"><u>Newbie Dashboard</u></h1>
      <?php } ?>


      <?php if ( $_SESSION['role'] == '' ) { ?>
      <blockquote class="blockquote"><p class="text-danger">Currently You have no role!!! Please Request Admin To Assign Role.</p></blockquote>
      <?php } ?>
        <div class="d-flex justify-content-between mb-4">
          <div>
          <?php if ( $_SESSION["role"] == 'admin' || $_SESSION["role"] == 'manager' || $_SESSION['role'] == 'user' || $_SESSION['role'] == '' ) { ?>
          <h3 class= "mb-1 text-primary">Welcome - ( <?php echo $username; ?> ),</h3>
          <p class="text-success h5">Role: <?php echo $_SESSION['role'] . "." ?></p>
          <?php } ?>
          </div>

          <div class="d-flex">
            <?php if ( $_SESSION['role'] == 'admin' ) { ?>
              <form action="add_user.php" class="me-2 mt-3 mb-3">
                <button type="submit" class="btn btn-primary">ADD USER</button>
              </form>
              <form action="logout.php" class="mt-3 mb-3">
                <div><button type="submit" class="btn btn-dark">LOG OUT</button></div>
              </form>
              <?php }if ( $_SESSION['role'] == 'manager' || $_SESSION['role'] == 'user' || $_SESSION['role'] == null ) { ?>
              <form action="logout.php" class="mt-3 mb-3">
                <div><button type="submit" class="btn btn-dark">LOG OUT</button></div>
              </form>
               <?php } ?>
              <?php } ?>
            </div>
        </div>

        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-dark">
              <th>SERIAL NO.</th>
              <th>NAME</th>
              <th>EMAIL</th>
              <th>ROLE</th>
              <?php if ( $_SESSION['role'] == 'admin' ) { ?>
              <th class = "text-center colspan=2" colspan="2">ACTION</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          <?php

          $usersDatafile = "./data/usersdata.json";
          $usersData = json_decode( file_get_contents( $usersDatafile ), true );

          $serialCount = 0;
          foreach ( $usersData as $key => $user ) {
          ?>
              <tr class="table-light">
                <td><strong><?php echo ++$serialCount; ?></strong></td>
                <td><?php echo $usersData[$key]['username']; ?></td>
                <td><?php echo $usersData[$key]['email']; ?></td>
                <td><?php echo $usersData[$key]['role']; ?></td>
                <?php if ( $_SESSION['role'] == 'admin' ) { ?>
                <td class="mx-auto float-right text-center">
                  <button type="submit" class="btn btn-warning mx-auto" ><a class="text-decoration-none text-black" href="edit_user.php?username=<?php echo $usersData[$key]['username']; ?>&email=<?php echo $usersData[$key]['email']; ?>&role=<?php echo $usersData[$key]['role']; ?>&password=<?php echo $usersData[$key]['password']; ?>" >EDIT</a></button>
                </td>
                <td class="mx-auto float-right text-center">
                    <button type="submit" class="btn btn-danger mx-auto"><a class="text-decoration-none text-white" href="delete_user.php?delete=<?php echo $key; ?>" >REMOVE</a></button>
                </td>
                  <?php } ?>
                <?php } ?>
              </tr>
          </tbody>
        </table>
    </div>
  </body>
</html>



