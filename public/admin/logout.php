<?php 
require_once("../../includes/initialize.php");

if ($session->is_logged_in()) {
  $session->logout($session->user_id);
  redirect_to('index.php');
}