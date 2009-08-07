<div class="user-topics-list">
  <h2>User Topics</h2>
  <div class="user-table">
    <table>
	  <tr>
	    <th>Title</th>
		<th>Content</th>
		<th>Creted Time</th>
		<th>Edit</th>
	  </tr>
	  <?php foreach($topics as $topic) : ?>
	  <tr>
	  <td><?php echo $topic->title ?></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <?php endforeach; ?>
	  </tr>
	</table>
  </div>
</div>