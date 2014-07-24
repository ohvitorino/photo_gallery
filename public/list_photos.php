<?php require_once("../includes/initialize.php"); ?>

<?php

// PAGINATION

// 1. The current page number ($current_page)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
if($page <= 0) {
  $page = 1;
}

// 2. records per page ($per_page)
$per_page = 3;

// 3. total record count ($total_count)
$total_count = Photograph::count_all();

// Find all photos
// Use pagination instead
// $photos = Photograph::find_all(); 

$pagination = new Pagination($page, $per_page, $total_count);

// Instead of finding all records, just find the records
// for this page


$photos = Photograph::find_all_paginated($per_page, $pagination->offset());


// Need to add ?page=$page to all links we want to
// maintain  the current page (or store $page in $session)


?>

<?php include_layout_template('header.php'); ?>

<?php foreach ($photos as $photo): ?>
<div style="float: left; margin-left: 20px;">
  <a href="photo.php?id=<?php echo $photo->id ?>"><img src="<?php echo $photo->image_path(); ?>" width="150"></a>
  <p><?php echo $photo->caption; ?></p>
</div>
<?php endforeach; ?>

<div id="pagination" style="clear: both;">
  <?php 
  if($pagination->total_pages() > 1) {
    if ($pagination->has_previous_page()) {
      ?>
      <a href="list_photos.php?page=<?php echo $pagination->previous_page(); ?>">&laquo; Previous</a>
      <?php
    }

    for ($i=1; $i <= $pagination->total_pages(); $i++) {
      if ($i == $page) {
        ?>
        <span class="selected"><?php echo $i; ?></span>
        <?php
      } else {
        ?>
        <a href="list_photos.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php
      }
    }

    if ($pagination->has_next_page()) {
      ?>
      <a href="list_photos.php?page=<?php echo $pagination->next_page(); ?>">Next &raquo;</a>
      <?php
    }
  }
  ?>
</div>

<?php include_layout_template('footer.php'); ?>
