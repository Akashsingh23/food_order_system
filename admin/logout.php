<?php

// include contants.php for SITEURL
include('../config/constants.php');

// 1. destroy the session
session_destroy(); // unset $_SESSION['user' ]

// 2, redirect tp login page
header('location:'.SITEURL.'admin/login.php');

?>