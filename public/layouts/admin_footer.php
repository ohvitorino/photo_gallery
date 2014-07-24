</div>
<div id="footer">
  Copyright <?php echo date("Y", time()); ?> Bruno Vitorino
</div>
</body>
<?php if (isset($database)) {
  $database->close_connection();
} ?>