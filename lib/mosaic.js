function sleep(ms) {
    return new Promise(
        resolve => setTimeout(resolve, ms)
    );
}

function getcount() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = async function() {
        if (this.readyState == 4 && this.status == 200) {
            var count = JSON.parse(this.responseText);
            do {
                await sleep(20);
                if (count.length > document.getElementById("count").innerHTML) {
                    document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) + 1;
                } else if (count.length < document.getElementById("count").innerHTML) {
                    document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) - 1;
                }
            } while (count.length != document.getElementById("count").innerHTML)
        }
    };
    xmlhttp.open("GET", "api/user.php", true);
    xmlhttp.send();

    setInterval(function() {
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var count = JSON.parse(this.responseText);
                do {
                    await sleep(20);
                    if (count.length > document.getElementById("count").innerHTML) {
                        document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) + 1;
                    } else if (count.length < document.getElementById("count").innerHTML) {
                        document.getElementById("count").innerHTML = parseInt(document.getElementById("count").innerHTML) - 1;
                    }
                } while (count.length != document.getElementById("count").innerHTML)
            }
        };
        xmlhttp.open("GET", "api/user.php", true);
        xmlhttp.send();
    }, 6000);
}

function hideprofile() {
    document.getElementById("sidebar").style.transform = 'translate(-100%)';
}

function showprofile() {
    document.getElementById("sidebar").style.transform = 'translate(0%)';
}