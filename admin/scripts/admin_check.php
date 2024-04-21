<?php
session_start();
include("dashboard_setup.php");
  if ($_SESSION["loggedin"] && !$_SESSION["admin_status"]){
    header("Location: /dashboard/index.php");
    exit;
  }
  if (!isset($_SESSION["loggedin"])){
    header("Location: /login");
    exit;
  }
  if (!$_SESSION["admin_status"]){
    header("Location: /login");
    exit;
  }