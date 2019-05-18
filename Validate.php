<?php
//echo <<<_END
//<html>
//<script>
//	function validate(form)
//	{
//		fail = validateForename(form.forename.value)
//		fail += validateSurname(form.surname.value)
//		fail += validateUsername(form.username.value)
//		fail += validatePassword(form.password.value)
//		fail += validateAge(form.age.value)
//		fail += validateEmail(form.email.value)
//
//		if (fail == "")
//		{
//			return true;
//		}
//		else
//		{
//			alert(fail);
//			return false;
//		}
//	}
//
//	function validateForename(field)
//	{
//		return (field == "") ? "No Forename was entered.\n" : ""
//	}
//
//	function validateSurname(field)
//	{
//		return (field == "") ? "No Surname was entered.\n" : ""
//	}
//
//	function validatePassword(field)
//	{
//		if (field == "")
//		{
//			return "No Password was entered.\n"
//		}
//		else if (field.length<6)
//		{
//			return "Passwords must be at least 6 characters.\n"
//		}
//		else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
//		{
//			return "Passwords require one each of a-z, A-Z, and 0-9.\n"
//		}
//		return ""
//	}
//
//	function validateAge(field)
//	{
//		if (isNan(field))
//		{
//			return "No age was entered.\n"
//		}
//		else if (field < 18 || field > 110)
//		{
//			return "Age must be between 18 and 110.\n"
//		}
//		return ""
//	}
//
//	function validateEmail(field)
//	{
//		if (field == "")
//		{
//			return "No email was entered.\n"
//		}
//		else if (!((field.indexOf(".")>0 && (field.indexOf("@") > 0) || /[^a-zA-Z0-9.@_-]/.test(field))
//		{
//			return "The email address is invalid.\n"
//		}
//		return ""
//	}
//</script>
//</html>
//_END;
//
////PHP Functions
//	function validate(form)
//	{
//		fail = validateForename(form.forename.value)
//		fail += validateSurname(form.surname.value)
//		fail += validateUsername(form.username.value)
//		fail += validatePassword(form.password.value)
//		fail += validateAge(form.age.value)
//		fail += validateEmail(form.email.value)
//
//		if (fail == "")
//		{
//			return true;
//		}
//		else
//		{ alert(fail); return false }
//	}
//
//	function validate_forename($field)
//	{
//		return ($field == "") ? "No Forename was entered.<br>" : ""
//	}
//
//	function validateSurname($field)
//	{
//		return ($field == "") ? "No Surname was entered.<br>" : ""
//	}
//
//
//
//	function validateAge($field)
//	{
//		if ($field == "")
//		{
//			return "No age was entered.<br>"
//		}
//		else if ($field < 18 || $field > 110)
//		{
//			return "Age must be between 18 and 110.<br>"
//		}
//		return ""
//	}
//
//	function validateEmail($field)
//	{
//		if ($field == "")
//		{
//			return "No email was entered.\n"
//		}
//		else if (!((strpos($field, "." ) > 0) &&
//				   (strpos($field, "@" ) > 0)) ||
//				   preg_match("/[^a-zA-Z0-9.@_-]/", $field))
//		{
//			return "The email address is invalid.<br>"
//		}
//		return ""
//	}
//
//	function fix_string($string)
//	{
//		if (get_magic_quotes_gpc())
//		{
//			$string = stripslashes($string);
//		}
//		return htmlentities($string);
//	}
//?>