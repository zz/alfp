<div class="user-login">
<h2>User Login</h2>
<div class="user-login-form">
  
	<?php echo validation_errors(); ?>
	 <?php echo form_open('user/login'); ?>
  <p>
	<label>Username</label><br />
	<input type="text" name="username" value="<?php echo set_value('username')?>" />
  </p>
  <p>
	<label>Password</label><br />
	<input type="password" name="password" value="" />
  </p>
  <p>
	<input type="submit" value="login" />
  </p>
  </form>
</div>
</div>