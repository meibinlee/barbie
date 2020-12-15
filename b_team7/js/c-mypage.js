const LOC_C_HOME = "c-home.html";
const URL_LOGIN = "php/c_login.php";
const URL_PROFILE = "php/c_profile.php";
const SUCCESS = 0;

var cCustomer;

function setItems(){
  var item = sessionStorage.getItem("customer");
  if(item != null) {
    cCustomer = JSON.parse(item);
    document.getElementById("c_name").value = cCustomer.c_name;
    document.getElementById("c_id").value = cCustomer.c_id;
    document.getElementById("c_password").value = cCustomer.c_pw;
    document.getElementById("c_birthdate").value = cCustomer.c_birthdate;
    document.getElementById("c_phonenumber").value = cCustomer.c_phonenumber;
    document.getElementById("c_address_si").value = cCustomer.c_address_si;
    document.getElementById("c_address_gu").value = cCustomer.c_address_gu;


    var c_gender = document.getElementsByName("gender");
    if(cCustomer.c_gender == "m"){
      c_gender[0].checked = true;
    }
    else if(cCustomer.c_gender == "f"){
      c_gender[1].checked = true;
    }

  }
  else {
    location.assign(LOC_LOGIN);
  }
}

function profile() {
  var json = new Object();
  json.c_name = document.getElementById("c_name").value;
  json.c_id = document.getElementById("c_id").value;
  json.c_pw = document.getElementById("c_password").value;
  json.c_phonenumber = document.getElementById("c_phonenumber").value;
  json.c_address_si = document.getElementById("c_address_si").value;
  json.c_address_gu = document.getElementById("c_address_gu").value;

  var c_repeatPassword = document.getElementById("c_repeatPassword").value;
  if(c_repeatPassword != json.c_pw) {
    alert("Please Repeat Your Password");
    return;
  }

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
      if(json.result == 0) {
        sessionStorage.setItem("customer", JSON.stringify(json.body));
        alert("Update Profile SUCCESS!");
        refresh();
      }
      else {
        alert("Service Error\n" + json.error);
      }
    }
    else if (this.readyState == 4 && this.status != 200){
      alert("Connection Error\n" + this.responseText);
    }
  };
  http.open("POST", URL_PROFILE, true);
  http.setRequestHeader("Content-Type", "application/json");
  http.send(JSON.stringify(json));
}

function refresh() {
  var body = new Object();
  body.c_id = cCustomer.c_id;
  body.c_pw = cCustomer.c_pw;

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
      if(json.result == SUCCESS) {
        console.log("Refresh Success!!");
        sessionStorage.setItem("customer", JSON.stringify(json.customer));
        sessionStorage.setItem("nearSalons", JSON.stringify(json.nearSalons));
        sessionStorage.setItem("myReservations", JSON.stringify(json.myReservations));
        location.assign(LOC_C_HOME);
      }
      else {
        sessionStorage.removeItem("customer");
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


