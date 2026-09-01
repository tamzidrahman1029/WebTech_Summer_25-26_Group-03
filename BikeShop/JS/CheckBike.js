function CheckBike()
{
    let bike_name = document.getElementById("bike_name").value.trim();

    let response = document.getElementById("bikeresponse");

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            response.innerHTML = this.responseText;
        }
        else
        {
            document.getElementById("bikeresponse").innerHTML = this.status;
        }
    }

    xhttp.open("POST", "../Controller/CheckBike.php", true);

    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    xhttp.send("bike_name=" + encodeURIComponent(bike_name));
}