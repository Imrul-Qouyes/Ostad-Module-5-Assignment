<?php
  session_name('myproject');
  session_start();
  session_unset();
  setcookie( "email", "" );
  setcookie( "password", "" );
  session_destroy();
  header( 'location: login.php' );
?>