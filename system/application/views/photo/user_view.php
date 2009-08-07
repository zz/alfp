<div class="user-photo-view">
  <?php foreach($photos as $photo): ?>
  <img src="<?php echo base_url() . $photo->path ?>" />
  <?php endforeach ?>
</div>