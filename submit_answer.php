 <?php 
require 'discussion_db.php';
 ; ?>


 <div class="submit_answer" style="border: solid pink 3px; text-align: center;">
		<form action="#" method="podt" id="submit_answer">
			<?php include 'errors.php'; ?>
			<input type="hidden" name="qsn_id" value="<?php echo $qsn_id; ?>">
			<div>
				<p>NAME:</p>
				<input type="text" name="name" placeholder="Enter your Name">
			</div>

			<div>
				<p>EMAIL:</p>
				<input type="email" name="email" placeholder="Enter your Email">
			</div>

			<div>
				<p>Answer:</p>
				<textarea rows="4" cols="30" name="answer"></textarea>
			</div>

			<div>
				<input type="submit" name="submit_answer" id="submit_btn">
			</div>
		</form>
</div>