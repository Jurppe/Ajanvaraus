var lastDate = "";

function mouseOver(date) {
    var dateArr = date.split("-");
    dateArr.splice(0,1);
    var finalDateArr = dateArr.join("-");
    document.getElementById("demo").innerHTML = "Varauspvm: " + finalDateArr;
    showReservation(finalDateArr);
}
function mouseOut() {
    document.getElementById("demo").innerHTML ="Osoita hiirellä päivää, jolloin näät onko vapaita aikoja";
}
function overlay() {
    el = document.getElementById("overlay");
    el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";

}

function showReservation(str) {
    if (str == "") {
        document.getElementById("demo").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("demo").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getReservation.php?q="+str,true);
        xmlhttp.send();
    }
}

function showDate(date) {
    var dateArr = date.split("-");
    dateArr.splice(0,1);
    var str = dateArr.join("-");
    lastDate=str;
    if (str == "") {
        document.getElementById("date").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("date").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getReservation.php?date="+str,true);
        xmlhttp.send();
    }
}

