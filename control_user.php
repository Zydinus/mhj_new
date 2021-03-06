<?php
// Start the session
session_start();

function isSignin() {
  return isset($_SESSION["user_is_signin"]) ? TRUE : FALSE;
}

function getUserEmail() {
  return $_SESSION["user_email"];
}

function getUserUsername() {
  return $_SESSION["user_username"];
}

function getUserLevel() {
  return isset($_SESSION["user_level"]) ? $_SESSION["user_level"] : 10000;
}

function requireSignin($bool) {
  if ( $bool && !isSignin() ) {
    header("Location: sign_in_form.php?message=require_signined");
    die();
  }
}

function requireLevel($level) {
  if ( getUserLevel() > $level ) {
    header("Location: sign_in_form.php?message=no_permission");
    die();
  }
}

?>
