function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}

function getcount() {
  var xmlhttp = new XMLHttpRequest();
  setInterval(function() {
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var count = JSON.parse(this.responseText);
        if (count.length >= document.getElementById("count").innerHTML) {
          do{
            document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) + 1;
            sleep(20);
          }while(count.length >= document.getElementById("count").innerHTML)
        } else if (count.length >= document.getElementById("count").innerHTML) {
          do{
            document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) - 1;
            sleep(20);
          }while(count.length >= document.getElementById("count").innerHTML)
        }
      }
    };
    xmlhttp.open("GET", "api/user.php", true);
    xmlhttp.send();
  }, 6000);
}
