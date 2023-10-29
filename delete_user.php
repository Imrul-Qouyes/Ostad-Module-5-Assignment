<?php
session_name( 'myproject' );
session_start();

if ( !isset( $_SESSION["email"] ) ) {
    header( "location: login.php" );
}

if ( $_SESSION['role'] == 'user' || $_SESSION['role'] == 'manager' || $_SESSION['role'] == '' ) {
    header( "location: index.php" );
}

$i = $_GET['delete'] ?? '';
$usersDatafile = "./data/usersdata.json";
$usersData = json_decode( file_get_contents( $usersDatafile ), true );

unset( $usersData[$i] );
file_put_contents( $usersDatafile, json_encode( $usersData, JSON_PRETTY_PRINT ) );
header( "location: index.php" );
?>