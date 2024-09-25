//global location variables, so the co ordinates can be directly accessed from here
var mylatitude;
var myLongitude;
//get users permission to access location
        if (!navigator.geolocation)
        {
            status.textContent = 'Geolocation is not supported by your browser!';
        }
        else
        {
            status.textContent = 'Locating now........';
            /*navigator.geolocation.getCurrentPosition(function (position) {*/
            //get the position (new co-ordinates) of the user while it changes
            navigator.geolocation.watchPosition(function (position)
                {
                    mylatitude = position.coords.latitude;
                    myLongitude = position.coords.longitude;
                    moveMarker(mylatitude,myLongitude);
                    //console.log("Current user location: ["+mylatitude+"] ["+myLongitude+"]");
                },
                function(error)
                {
                    //if user rejects the loation permission show error message
                    if (error.code == error.PERMISSION_DENIED)
                    {
                        //console.log("Location permission denied!");
                        alert("Please allow Location in order to update your live location on the MAP!");
                    }
                }
            );
        }

//recenter button handler
document.getElementById("recenterBtn").addEventListener('click', recenterCurrentUser, false);
//reload button handler
document.getElementById("reloadBtn").addEventListener('click', updateFriendsLocation, false);

//console.log(initialLat);
//console.log(initialLong);

//creating a new vector layer for the map
var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
//create a new map and embed into html element by using its ID
map = new OpenLayers.Map("Map");
//setting the co-ordinate reference system
var fromProjection = new OpenLayers.Projection("EPSG:4326"); // Transform from WGS 1984
var toProjection = new OpenLayers.Projection("EPSG:900913"); //to Spherical Mercator Projection
//setting position by using intial longitude and latitude
var position = new OpenLayers.LonLat(initialLong, initialLat).transform(fromProjection, toProjection);
//setting Map zoom level
var zoom = 5;

var mapnik = new OpenLayers.Layer.OSM();
map.addLayer(mapnik);
map.setCenter(position, zoom);
var markers = new OpenLayers.Layer.Markers("Markers");
map.addLayer(markers);
//setting array to store the data received using AJAX in a JSON format
let friendDataFromDBS = [];
//array to store the friends markers objects
let friendMark = [];

// Define markers as "features" of the vector layer:
//"FEATURE" :  A vector object for geographic features with a geometry and other attribute properties
//current user feature, the position of the marker is set upon the values given by the database
var currentUserMarker = new OpenLayers.Feature.Vector(
    new OpenLayers.Geometry.Point(initialLong, initialLat).transform(fromProjection, toProjection),
    {description: 'You'},
    {
        externalGraphic: 'images/pin.png',
        graphicHeight: 30,
        graphicWidth: 30,
        graphicXOffset: -12,
        graphicYOffset: -25
    }
);
// "addFeature" : Triggered when a feature is added to the source.
vectorLayer.addFeatures(currentUserMarker);
setCurrentMarker(currentUserMarker);
//"addLayer" : Adds the given layer to the top of this map.
map.addLayer(vectorLayer);
//Add a selector control to the vectorLayer with popup functions
var controls = {
    selector: new OpenLayers.Control.SelectFeature(vectorLayer, {
        onSelect: createPopup,
        onUnselect: destroyPopup
    })
};
//creates popup for the given feature
function createPopup(feature) {
    feature.popup = new OpenLayers.Popup.FramedCloud("pop",
        feature.geometry.getBounds().getCenterLonLat(),
        null,
        '<div class="markerContent">' + feature.attributes.description + '</div>',
        null,
        true,
        function () {
            controls['selector'].unselectAll();
        }
    );
    feature.popup.closeOnMove = true;
    map.addPopup(feature.popup);
}
//destroys the popup for the given feature
function destroyPopup(feature) {
    feature.popup.destroy();
    feature.popup = null;
}
map.addControl(controls['selector']);
controls['selector'].activate();
//update current user marker on the map whenever he changes position
function moveMarker(newLat,newLong)
{
    //remove the old marker
    removeMarker(getCurrentMarker());
    //update current user position and marker (feature)
    position = new OpenLayers.LonLat(newLong, newLat).transform(fromProjection, toProjection);
    currentUserMarker = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(newLong, newLat).transform(fromProjection, toProjection),
        {description: 'You'},
        {
            externalGraphic: 'images/pin.png',
            graphicHeight: 30,
            graphicWidth: 30,
            graphicXOffset: -12,
            graphicYOffset: -25
        }
    );
    //"addFeature" : Triggered when a feature is added to the source.
    //add the current user feature on the map vector layer
    vectorLayer.addFeatures(currentUserMarker);
    //passing the current user feature to the function
    setCurrentMarker(currentUserMarker);
}
//function to remove the current user feature, such as when he changes position
function removeMarker(currentUserM)
{
    vectorLayer.destroyFeatures(currentUserM);
}
//function to set the feature
function setCurrentMarker(crntMrk)
{
    currentUserMarker = crntMrk;
}
//function to get the feature
function getCurrentMarker()
{
    return currentUserMarker;
}
//runs after every 3 seconds, function to update the live location of the friends on the Map
function updateFriendsLocation() {
    //condition to make sure that some data is passed
    if(friendDataFromDBS!=null && typeof(friendDataFromDBS)!="undefined") {
        //remove any old features
        removeFrndMarker();
        //update features for each friend, looping through the JSON data
        friendDataFromDBS.forEach(function (obj) {
            /*
            console.log("----------------------------From DBS");
            console.log(obj.firstName)
            console.log(obj.lat);
            console.log(obj.lng);
            console.log("-------------------------------------");
            */
            // Define markers as "features" of the vector layer:
            //"FEATURE" :  A vector object for geographic features with a geometry and other attribute properties
            var feature = new OpenLayers.Feature.Vector(
                new OpenLayers.Geometry.Point(obj.lng, obj.lat ).transform(fromProjection, toProjection),
                {description:obj.firstName + ' ' + obj.lastName + '<br>' + '<img src="'+obj.userImage+'" width=100>'} ,
                {externalGraphic: 'images/pin2.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
            );
            // "addFeature" : Triggered when a feature is added to the source.
            vectorLayer.addFeatures(feature);
            //update array with new features
            friendMark.push(feature);
            //console.log("a:" + obj.firstName);
        });
    }
    else
    {
        //if no data is received then run the function again
        console.log("Getting friend location data from DBS now");
        updateLocationsDBS();
    }
}
//run update friends location function every 3 seconds
setInterval(function () {
    updateFriendsLocation();
}, 3000);
//remove all previous features of the friends
function removeFrndMarker()
{
    friendMark.forEach(function (obj)
    {
        vectorLayer.destroyFeatures(obj);
    });
    //friendMark = [];
}
//function using AJAX call to get all friend data from database, and pass the current user location to the database
//runs every 2 seconds
function updateLocationsDBS()
{
    var sendLat=mylatitude;
    var sendLong=myLongitude;
    /*console.log("------");
    console.log(sendLat);
    console.log(sendLong);*/
    //creating new HTTP request
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            //console.log(this.responseText);
            //get the response text, which was JSON encoded by PHP
            friendDataFromDBS = JSON.parse(this.responseText);
        }
    };

    xmlhttp.open("GET", "getLocationData.php?q=" + currentUserID + "," + sendLat + "," + sendLong, true);
    xmlhttp.send();
}
//2 second time interval
setInterval(function () {
    updateLocationsDBS();
}, 2000);
//called by the recenter button to focus on the current user marker with a zoom level of 10
function recenterCurrentUser()
{
    map.setCenter(position,10);
}