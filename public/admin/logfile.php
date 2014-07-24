<?php 

require_once("../../includes/initialize.php");

if (!$session->is_logged_in()) {
  redirect_to("login.php");
}

if (isset($_GET['clear']) && $_GET['clear'] == 'true') {
  
  file_put_contents(LOG_FILE, '');
  log_action("ADMIN", "Log was cleared.");
  redirect_to('logfile.php');
}

?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br>
<br>

<h2>System log</h2>
<p><a href="logfile.php?clear=true">Clear log file</a></p>

<?php 

$content = "";

if (file_exists(LOG_FILE) && is_readable(LOG_FILE) && $handle = fopen(LOG_FILE, "r")) {
  while (!feof($handle)) {
    $content .= nl2br(fgets($handle));
  }
  
} else {
  echo "Could not read from {LOG_FILE}";
}
?>

<div><?php echo $content; ?></div>  

<?php include_layout_template('admin_footer.php'); ?>