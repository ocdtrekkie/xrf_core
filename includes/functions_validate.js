function validateEmail(field) {
if (field == "") return "No email was entered.\n"
else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
return "The email address is invalid.\n"
return ""
}

function validateEmail2(field, field2) {
if (field != field2)
return "Email address fields do not match.\n"
return ""
}

function validateUsername(field) {
if (field == "") return "No username was entered.\n"
else if (field.length < 4)
return "Usernames must be at least 4 characters.\n"
else if (/[^a-zA-Z0-9_-]/.test(field))
return "Only a-z, A-Z, 0-9, - and _ allowed in usernames.\n"
return ""
}

function validatePassword(field) {
if (field == "") return "No password was entered.\n"
else if (field.length < 6)
return "Passwords must be at least six characters.\n"
return ""
}

function validateLname(field) {
if (field == "") return "No last name was entered.\n"
return ""
}

function validateFname(field) {
if (field == "") return "No first name was entered.\n"
return ""
}