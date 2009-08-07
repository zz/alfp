<div class="personal-page">
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

  <div id="tabs">
	<ul>
	  <li><a href="#tabs-1">Post Topic</a></li>
	  <li><a href="#tabs-2">Upload Photo</a></li>
	  <li><a href="#tabs-3">Change Password</a></li>
	  <li><a href="#tabs-4">Change Prop</a></li>
	</ul>

	<div id="tabs-1" class="user-add-topic">
	  <h2>Post Topic</h2>
	  <div id="user-add-topic-form">
		<form action="<?php echo site_url('topic/post')?>" method="post">
	    <p>
		  <label>Title</label><br />
		  <input type="text" name="title" class="topic-input" />		  
		</p>
		<p>
		  <label>Content</label><br />
		  <textarea name="content" id="" rows="10" cols="80" tabindex=""></textarea>
		</p>
		<p>
		  <label>Tags</label><br />
		  <input class="tags-input" type="text" name="tags" value="" />
		</p>
		<p>
		  <input type="submit" />
		</p>
		</form>
	  </div>
	</div>

	<div id="tabs-2" class="user-add-photo">
	  <form action="<?php echo site_url('photo/upload') ?>" method="post"  enctype="multipart/form-data">
	  <h2>Upload Photo</h2>
	  <div id="user-add-photo-form">
		<p>
		  <input type="file" name="userfile" value="" />
		</p>
		<p>
		  <label>Tags</label><br />
		  <input type="text" class="tags-input" name="tags" value="" />
		</p>
		<p>
		  <input type="submit" value="upload" />
		</p>
	  </div>
	</form>
	</div>

	<div id="tabs-3" class="user-change-password">
	  <h2>Change Password</h2>
	  <div id="user-change-password-form">
	    <form action="<?php echo site_url('user/password/change')  ?>" method="post">
		<input type="password" name="" value="" />
		</form>
	  </div>
	</div>

	<div id="tabs-4" class="user-change-prop">
	  <h2>Change Prop</h2>
	</div>

  </div>

</div>