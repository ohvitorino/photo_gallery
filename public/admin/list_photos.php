<?php 

require_once("../../includes/initialize.php");

if (!$session->is_logged_in()) {
  redirect_to("login.php");
}

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

?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a>
<br>
<br>

<h2>Photographs</h2>

<?php echo output_message($session->message()); ?>

<table class="bordered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
    <th>Comments</th>
    <th>&nbsp;</th>
  </tr>
  <?php foreach ($photos as $photo): ?>
  <tr>
    <td><img src="<?php echo "..".DS.$photo->image_path(); ?>" width="50"></td>
    <td><?php echo $photo->filename; ?></td>
    <td><?php echo $photo->caption; ?></td>
    <td><?php echo $photo->size_as_text(); ?></td>
    <td><?php echo $photo->type; ?></td>
    <td>
      <a href="comments.php?id=<?php echo $photo->id; ?>">
        <?php echo count($photo->comments()); ?>
      </a>
    </td>
    <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
  </tr>
  <?php endforeach; ?>
</table>

<br>
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
<br>

<a href="photo_upload.php">Upload a new photograph</a>

<?php include_layout_template('admin_footer.php'); ?>