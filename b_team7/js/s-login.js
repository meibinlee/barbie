const LOC_S_HOME = "s-home.html";
const URL_LOGIN = "php/s_login.php";
const SUCCESS = 0;

function setItems() {
  var item = localStorage.getItem("remember");
  if(item != null) {
    var remember = JSON.parse(item);
    document.getElementById("s_id").value = remember.s_id;
    document.getElementById("s_pw").value = remember.s_pw;
    document.getElementById("remember").checked = true;
  }
  else {
   document.getElementById("remember").checked = false;    
  }
}

function login() {
  var body = new Object();
  body.s_id = document.getElementById("s_id").value;
  body.s_pw = document.getElementById("s_pw").value;

  if (document.getElementById("remember").checked) {
    console.log("set Remember!!");
    localStorage.setItem("remember", JSON.stringify(body));
  }
  else {
    localStorage.removeItem("remember");
  }

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
      if(json.result == SUCCESS) {
        console.log("Log In Success!!");
        sessionStorage.setItem("salon", JSON.stringify(json.salon));
        sessionStorage.setItem("hairdresser1", JSON.stringify(json.hairdresser1));
        sessionStorage.setItem("hairdresser2", JSON.stringify(json.hairdresser2));
        sessionStorage.setItem("hairdresser3", JSON.stringify(json.hairdresser3));
        sessionStorage.setItem("price", JSON.stringify(json.price));
        sessionStorage.setItem("todayReservations", JSON.stringify(json.todayReservations));
        sessionStorage.setItem("tmrwReservations", JSON.stringify(json.tmrwReservations));
        location.assign(LOC_S_HOME);
      }
      else {
        sessionStorage.removeItem("salon");
        alert("Service Error\n" + json.error);
      }
    }
    else if (this.readyState == 4 && this.status != 200){
      alert("Connection Error\n" + this.responseText);
    }
  };
  http.open("POST", URL_LOGIN, true);
  http.setRequestHeader("Content-Type", "application/json");
  http.send(JSON.stringify(body));
}
