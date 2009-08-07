<div class="user-signup">
  <h2>User Signup</h2>
  <?php echo validation_errors(); ?>
  <div class="user-signup-form">
	<?php echo form_open('user/signup') ?>
    <p>
	  <label>Username</label><br />
	  <input type="text" name="username" value="<?php echo set_value('username')?>" />
	</p>
	<p>
	  <label>Password</label><br />
	  <input type="password" name="password" value="" />
	</p>
	<p>
	  <label>Password Confrimation</label><br />
	  <input type="password" name="passconf" value="" />
	</p>
	<p>
	  <label>E-mail</label><br />
	  <input type="text" name="email" value="<?php echo set_value('email')?>" />
	</p>
	<p>
	  <input type="submit" name="" value="Signup" />
	</p>
  </form>
  </div>
</div>