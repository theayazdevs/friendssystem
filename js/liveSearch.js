//live search function using AJAX call to get the data from the database for the matching query and filters
function liveSearch(toSearch)
{
    //declaring and initialising filter value
    var filterVal = "";
    //getting the HTML radio button element
    var radios = document.getElementsByName('radioBtn');
    //getting the radio button that is currently selected
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            filterVal=radios[i].value;
            //only one radio button can be selected, so the loop does not need to check for others
            break;
        }
    }
    //console.log(filterVal);
    //getting the HTML element in which to show the search results
    var showResults = document.getElementById("suggestions");
    //making sure that the search value is not null
    if(toSearch && toSearch!="") {
        //HTTP request to get records from the database
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                //get and store the response text
                var searchResults = this.responseText;
                //check if results returned are not empty or null
                if (searchResults != null && searchResults != "None") {
                    //clear the element to show new search results
                    showResults.innerHTML = "";
                    //JSON parsing data received by using the AJAX call
                    var dataFromDBS = JSON.parse(searchResults);
                    dataFromDBS.forEach(function (obj) {
                        //create a new div element
                        var divCreator = document.createElement('div');
                        //update the div with following HTML
                        divCreator.innerHTML = "<a href='viewProfile.php?id="+ obj.id +"' class='igonre-css'><div class='row m-1 p-1 warning'><div class='col-lg-3'><img  src='" + obj.userImage +
                            "' width='50px'></div>" + "<div class='col-lg-3'>" + obj.firstName + " " + obj.lastName + "</div><div class='col-lg-3'>" + obj.username +
                            "</div><div class='col-lg-3'>" + obj.email + "</div></div></a>";
                        //show results on the HTML page
                        showResults.appendChild(divCreator);
                    });
                }
                else
                {
                    //error if no match found
                    showResults.innerHTML = "<div class='alert-danger p-2'>No Match Found!</div>";
                }
            }
        };
        //calling the php page to get the search results
        xmlhttp.open("GET", "getLiveSearchData.php?s=" + toSearch + "," + filterVal, true);
        xmlhttp.send();
    }
    else
    {
        //if search box is empty
        showResults.innerHTML = "<div class='alert-info p-2'>Please input some values in the search box!</div>";
    }
}