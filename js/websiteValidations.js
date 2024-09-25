//login page
//validating the values put into a email box
function validateEmail(valueInput)
{
    // getting HTML email box
    var emailBox = document.getElementById("email");
    // element to show warnings
    var emailWarningBox = document.getElementById("emailWarnings");
    //regular expressions to match against email
    const capRegEx = new RegExp(/[A-Z]/);
    const spaceRegEx = new RegExp(/  */);
    //if box empty, show error
    if(valueInput=="")
    {
        //console.log("Please Don't leave the email empty");
        emailWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Please Don't leave the email empty!</div>";
    }
    //check if any capital letter found and make all lower case
    else if(capRegEx.test(valueInput))
    {
        var lowerInput = valueInput.toLowerCase();
        //console.log("Captial");
        emailBox.value = lowerInput;
        emailWarningBox.innerHTML = "<div class='alert-success p-2 m-1'>Capital letters successfully Converted to Lower Case!</div>";
    }
    //Dot found in end, meaning the email is incomplete so without ".com", ".uk" etc...
    else if((valueInput.slice(-1))==".")
    {
        //console.log("Please Dont leave a dot in end");
        emailWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Email incomplete, Please complete the email address again!</div>";
        emailBox.value = "";
    }
    //check for any spaces user may have put inside the email address by mistake
    else if(spaceRegEx.test(valueInput))
    {
        emailWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>There was a space in the email, please type again!</div>";
        emailBox.value = "";
    }
    else
    {
        //clear all warnings
        clearWarning(emailWarningBox);
    }
}
//function that clears the elements passed
function clearWarning(elementToClear)
{
    elementToClear.innerHTML = "";
}
//validating password
function validatePassword(valueInput)
{
    //getting the password boxes
    var passwordBoxA = document.getElementById("passwordA");
    var passwordBoxB = document.getElementById("password");
    //getting the values input into the password boxes
    var valueA = passwordBoxA.value;
    var valueB = passwordBoxB.value;
    //password warning box
    var passwordWarningBox = document.getElementById("passwordWarnings");
    //if empty, show error
    if(valueInput=="")
    {
        passwordWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Please Don't leave the password empty!</div>";
    }
    //if less than 6 character, show error
    else if(valueA.length < 6 || valueB.length < 6)
    {
        passwordWarningBox.innerHTML = "<div class='alert-warning p-2 m-1'>Password must be 6 or more characters!</div>";
        if(valueA.length < 6 ) {
            passwordBoxA.value = "";
        }
        else{
            passwordBoxB.value = "";
        }
    }
    //password not matching, enter again
    else if(!(valueA==valueB))
    {
        passwordWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Passwords do not match!</div>";
        passwordBoxA.value = "";
        passwordBoxB.value = "";
    }
    //successful password match
    else if(valueA==valueB)
    {
        passwordWarningBox.innerHTML = "<div class='alert-success p-2 m-1'>Passwords match!</div>";
    }
    //clear all warnings
    else
    {
        clearWarning(passwordWarningBox);
    }

}
//validate username
function validateUsername(valueInput)
{
    var usernameBox = document.getElementById("username");
    var usernameWarningBox = document.getElementById("usernameWarnings");
    const spaceRegEx = new RegExp(/  */);
    //if empty, show error
    if(valueInput=="")
    {
        //console.log("Please Don't leave the email empty");
        usernameWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Please Don't leave the username empty!</div>";
    }
    //if any spaces found inside username, show error
    else if(spaceRegEx.test(valueInput))
    {
        usernameWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Spaces not allowed in the username!</div>";
        usernameBox.value = "";
    }
    //if less than 3 characters typed, show error
    else if (usernameBox.value.length < 3)
    {
        usernameWarningBox.innerHTML = "<div class='alert-warning p-2 m-1'>Please enter 3 characters minimum!</div>";
    }
    //clear all warnings
    else
    {
        clearWarning(usernameWarningBox);
    }

}
//validate first name
function validateFirstName(valueInput)
{
    var fNameBox = document.getElementById("fName");
    var fWarningBox = document.getElementById("firstNameWarnings");
    //all special characters
    const spcCharRegEx = new RegExp(/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/);
    //if any special characters present, show warning and highlight box
    if(spcCharRegEx.test(valueInput))
    {
        fWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Symbols not allowed here!</div>";
        fNameBox.focus();
        fNameBox.style.border = 'solid 5px red';
        //clear box value
        fNameBox.value = "";
        //reset box after 3 seconds
        setTimeout(resetBoxStyles, 3000);
        function resetBoxStyles()
        {
            fNameBox.style.border='solid 1px black';
            //console.log("here");
        }
    }
    else
    {
        clearWarning(fWarningBox);
    }
}
function validateLastName(valueInput)
{
    var lNameBox = document.getElementById("lName");
    var lWarningBox = document.getElementById("lastNameWarnings");
    //all special characters
    const spcCharRegEx = new RegExp(/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/);
    //if any special characters present, show warning and highlight box
    if(spcCharRegEx.test(valueInput))
    {
        //focus on the box
        lNameBox.focus();
        lNameBox.style.border = 'solid 5px red';
        lWarningBox.innerHTML = "<div class='alert-danger p-2 m-1'>Symbols not allowed here!</div>";
        //clear value
        lNameBox.value = "";
        //reset box after 3 seconds
        setTimeout(resetBoxStyles, 3000);
        function resetBoxStyles()
        {
            lNameBox.style.border='solid 1px black';
            //console.log("here");
        }
    }
    else
    {
        clearWarning(lWarningBox);
    }
}

