<?php

//fetch the deposit amount and get the new balance;
if (isset($_POST["deposit"])) {
# You could REFERENCE the withdraw.php to write this part; 
# firstly you need to check and ensure that the user has enter a valid value for deposit, 
# then call the model's deposit method which will update balance 
# then you should display the new balance 
# you shoudl report some suitable error messages
    $deposit = intval($_POST["amount"]);
    if($deposit > 0) {
        $newAmount = $this -> model ->deposit($_POST["id"], $deposit);
        if($newAmount != null ) {
            echo "You now have £" . $newAmount;
        } else {
            echo "Something went wrong.";
        }
    } else {
        echo "Invalid input";
    }











} 
//display the form	
?>
<h1>Deposit</h1>
<form method="post" action="">
<div>	Please enter the account ID
        <input type="text" name="id"/> </br><br>
		Please enter the amount to deposit
		<input type="number" name="amount"/>
        <input type="submit" name="deposit" value="deposit">
</div>
</form>
	