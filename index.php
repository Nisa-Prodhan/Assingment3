<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.error{color:red;} <!--Defining red color for this class-->
</style>
</head>
<body>
<?php
$countryArray = array('ANDORRA'=>'376','ANGUILLA'=>'1264','AFGHANISTAN'=>'93','Bangladesh'=>'880',
					  'BAHRAIN'=>'973','BRAZIL'=>'55','GERMANY'=>'49','SPAIN'=>'34','INDIA'=>'91');//Country name with country code associative array
					  
//function	for remove space and slash and return clean data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  return $data;
}
//Defining Variables
$nameErr = $fullnameErr = $emailErr = $genderErr = $phoneErr = $passErr = $cpassErr ="";
$name = $fullname = $email = $gender = $phone = $showphone = $password = $cpassword = "";
//check if sever has a post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//sanitization for username
	if (empty($_POST["un"])) {
    $nameErr = "Username is required";
  } else {
    $name = test_input($_POST["un"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {//check is cheracter or not
      $nameErr = "Only letters and white space allowed";
    }
  }
}
//sanitization for FullName
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["fn"])) {
    $fullnameErr = "FullName is required";
  } else {
    $fullname = test_input($_POST["fn"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {//check is cheracter or not
      $fullnameErr = "Only letters and white space allowed";
    }
  }
  
  //sanitization for Email
if (empty($_POST["ue"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["ue"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//check if it's a valid email
      $emailErr = "Invalid email format";
    }
  }
  //sanitization for Phone
 if (empty($_POST["up"])) 
	{
    $phoneErr = "Phone Number is required";
    } 
 else 
	{
    $phone = test_input($_POST["up"]);//phone number
	$code = test_input($_POST["code"]);//Country code
	$showphone = $phone;
	$phone = $code.$phone;
    if (!preg_match("/^[0-9]/", $phone)) {//check is digit or not
      $phoneErr = "Invalid phone number";
    }
	}
	 //sanitization for Password
   if (empty($_POST["pw"])) {
    $passErr = "Password is required";
  } else {
    $password = test_input($_POST["pw"]);
    if (!preg_match("/^[a-zA-Z0-9]{6}/", $password)) {//check if it minimum 6 character
      $passErr = "password is too short";
    }
  }
   //sanitization for Gender
   if (empty($_POST["gen"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gen"]);
  }
}
?>
<form name="application" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!--Table Starts -->
<table align="center" style="font-size:30px">
	<!--First Row -->
	<tr>
		<td>
		username :
		</td>
		<td>
		 <input type ="text" name ="un" value="<?php echo $name;?>"/>
		 <span class="error">* <?php echo $nameErr;?></span>
		</td>
	</tr>
	<!--Second Row -->
	<tr>
		<td>
		Fullname :
		</td>
		<td>
		 <input type ="text" name ="fn" value="<?php echo $fullname;?>"/>
		  <span class="error">* <?php echo $fullnameErr;?></span>
		</td>
	</tr>
	<!--Third Row -->
	<tr>
		<td>
		Email :
		</td>
		<td>
		 <input type ="text" name ="ue" value="<?php echo $email;?>"/>
		 <span class="error">* <?php echo $emailErr;?></span>
		</td>
	</tr>
	<!--Forth Row -->
	<tr>
		<td>
		Phone :
		</td>
		<td>
		 <select name="code">
			<?php
			foreach ($countryArray as $con => $code) {
				
			?>
				<option value="<?php echo $code ?>"> <?php echo  $con."(".$code.")"?> </option>
			<?php
			}
			?>
		 </select>
		 <input type ="text" name ="up" value="<?php echo $showphone;?>"/>
		 <span class="error">* <?php echo $phoneErr;?></span>
		</td>
	</tr>
	<!--Fifth Row -->
	<tr>
		<td>
		Password :
		</td>
		<td>
		 <input type ="password" name ="pw" value="<?php echo $password;?>"/>
		 <span class="error">* <?php echo $passErr;?></span>
		</td>
	</tr>
	<!--Sixth Row -->
	<tr>
		<td>
		Gender :
		</td>
		<td>
		<!--Radio For gender -->
		 <input type ="radio" name ="gen" <?php if (isset($gender) && $gender=="Male") echo "checked";?> value="Male"/>Male
		 <input type ="radio" name ="gen" <?php if (isset($gender) && $gender=="Female") echo "checked";?> value="Female"/>Female
		 <input type ="radio" name ="gen" <?php if (isset($gender) && $gender=="Other") echo "checked";?> value="Other"/>Other
		 <span class="error">* <?php echo $genderErr;?></span>
		</td>
	</tr>
	<!--Seventh Row -->
	<tr>
		<td>
		Education :
		</td>
		<td>
		<!--Checkbox For Education -->
		 <input type="checkbox" name="edu[]" value="SSC">SSC
		 <input type="checkbox" name="edu[]" value="HSC">HSC
		 <input type="checkbox" name="edu[]" value="BSC">BSC
		 <input type="checkbox" name="edu[]" value="MSC">MSC
		</td>
	</tr>
	<!--Eighth Row -->
	<tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type="submit" style="font-size:30px;">
		</td>
	</tr>
</table>
</form>
	<?php
	//Printing All The Inputs
	echo "<h2>Your Input:</h2>";
	echo "UserName : ".$name;
	echo "<br>";
	echo "FullName : ".$fullname;
	echo "<br>";
	echo "Phone : ".$phone;
	echo "<br>";
	echo "Email : ".$email;
	echo "<br>";
	echo "Password : ".$password;
	echo "<br>";
	echo "Gender : ".$gender;
	?>
</body>
</html>
