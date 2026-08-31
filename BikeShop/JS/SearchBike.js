function SearchBike()
{
    let search = document.getElementById("search").value.trim();

    let response = document.getElementById("productTable");

    let xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            response.innerHTML = this.responseText;
        }
        else
        {
            document.getElementById("productTable").innerHTML = this.status;
        }
    }


    xhttp.open("POST", "../Controller/SearchBikeController.php", true);


    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");


    xhttp.send("search=" + encodeURIComponent(search));

}