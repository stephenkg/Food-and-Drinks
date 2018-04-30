function validateForm() {
    var user = document.forms["user_details"]["username"].value;
    var fname = document.forms["user_details"]["first_name"].value;
    var lname = document.forms["user_details"]["second_name"].value;
    var pass = document.forms["user_details"]["password"].value;
    var repass = document.forms["user_details"]["repass"].value;


    if (fname == null || lname == "" || user == "") {
        alert("All details required were not supplied");
        return false;

    } else if (pass !== repass) {
        alert("Passwords do not match!");
        return false;
    }

    return true;
}