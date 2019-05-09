<?php

	#select tags in HTML for drop down menu # put into container?
	
	#input type = file (inorder to have user upload file)

	echo <<<_END
	
	<h1>Welcome to Decryptoid!</h1>
	
	<form action="sqlPra.php" method="post">
		Email: <input type = "email" placeholder="enter email" required>
		
		Password: <input type = "password" placeholder="enter password" required>
		<button>Sign-in</button>
		
		<br><br><br>
		Select Cipher: <select>
			<option>Simple Substitution</option>
			<option>Double Transposition</option>
			<option>RC4</option>
			<option>DES</option>
		</select>
		Select Type: <select>
			<option>Encrypt</option>
			<option>Decrypt</option>
		</select>
		<br><br><br>
		
		<p>Enter text here:</p>
		<textarea rows="10 cols="100"></textarea>
		
		<br><br><br>
		<p>Submit text file here:</p>
		<input type="file">
		<br><br><br><br>
		
		<button>Start!</button>
		
		
	</form>
				
_END;
	
	
	

?>