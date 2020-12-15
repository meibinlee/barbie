const LOC_S_HOME = "s-home.html";
const URL_LOGIN = "php/s_login.php";
const URL_PROFILE = "php/s_profile.php";
const SUCCESS = 0;

var sSalon;
var pPrice;
var hHairdresser1;
var hHairdresser2;
var hHairdresser3;
var h_id_1;
var h_id_2;
var h_id_3;

function setItems(){
  showPrice();
  showProfile(); 
  showHairdresser1();
  showHairdresser2();
  showHairdresser3();
}

function showProfile(){
  var item = sessionStorage.getItem("salon");
  if(item != null) {
    sSalon = JSON.parse(item);
    document.getElementById("s_name").value = sSalon.s_name;
    document.getElementById("s_id").value = sSalon.s_id;
    document.getElementById("s_password").value = sSalon.s_pw;
    document.getElementById("s_phonenumber").value = sSalon.s_phonenumber;
    document.getElementById("s_address_si").value = sSalon.s_address_si;
    document.getElementById("s_address_gu").value = sSalon.s_address_gu;
    document.getElementById("s_address_detail").value = sSalon.s_address_detail;
  }
}

function showPrice(){
  var item = sessionStorage.getItem("price");
  if(item != null) {
    pPrice = JSON.parse(item);
    document.getElementById("dyeing").value = pPrice.dyeing;
    document.getElementById("perm").value = pPrice.perm;
    document.getElementById("cut").value = pPrice.cut;
  }
}

function showHairdresser1(){
  var item = sessionStorage.getItem("hairdresser1");
  if(item != null) {
    hHairdresser1 = JSON.parse(item);
    h_id_1 = hHairdresser1.h_id;
    document.getElementById("h_name_1").value = hHairdresser1.h_name;
    document.getElementById("h_gender_1").value = hHairdresser1.h_gender;
    document.getElementById("h_career_1").value = hHairdresser1.h_career;
  }
}

function showHairdresser2(){
  var item = sessionStorage.getItem("hairdresser2");
  if(item != null) {
    hHairdresser2 = JSON.parse(item);
    h_id_2 = hHairdresser2.h_id;
    document.getElementById("h_name_2").value = hHairdresser2.h_name;
    document.getElementById("h_gender_2").value = hHairdresser2.h_gender;
    document.getElementById("h_career_2").value = hHairdresser2.h_career;
  }
}

function showHairdresser3(){
  var item = sessionStorage.getItem("hairdresser3");
  if(item != null) {
    hHairdresser3 = JSON.parse(item);
    h_id_3 = hHairdresser3.h_id;
    document.getElementById("h_name_3").value = hHairdresser3.h_name;
    document.getElementById("h_gender_3").value = hHairdresser3.h_gender;
    document.getElementById("h_career_3").value = hHairdresser3.h_career;
  }
}

function updateProfile() {
  var json = new Object();
  json.s_name = document.getElementById("s_name").value;
  json.s_id = document.getElementById("s_id").value;
  json.s_pw = document.getElementById("s_password").value;
  json.s_phonenumber = document.getElementById("s_phonenumber").value;
  json.s_address_si = document.getElementById("s_address_si").value;
  json.s_address_gu = document.getElementById("s_address_gu").value;
  json.s_address_detail = document.getElementById("s_address_detail").value;
  json.h_id_1 = h_id_1;
  json.h_name_1 = document.getElementById("h_name_1").value;
  json.h_gender_1 = document.getElementById("h_gender_1").value;
  json.h_career_1 = document.getElementById("h_career_1").value;
  json.h_id_2 = h_id_2;
  json.h_name_2 = document.getElementById("h_name_2").value;
  json.h_gender_2 = document.getElementById("h_gender_2").value;
  json.h_career_2 = document.getElementById("h_career_2").value;
  json.h_id_3 = h_id_3;
  json.h_name_3 = document.getElementById("h_name_3").value;
  json.h_gender_3 = document.getElementById("h_gender_3").value;
  json.h_career_3 = document.getElementById("h_career_3").value;
  json.dyeing = document.getElementById("dyeing").value;
  json.perm = document.getElementById("perm").value;
  json.cut = document.getElementById("cut").value;

  var s_repeatPassword = document.getElementById("s_repeatPassword").value;
  if(s_repeatPassword != json.s_pw) {
    alert("Please Repeat Your Password");
    return;
  }

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
      if(json.result == 0) {
        sessionStorage.setItem("salon", JSON.stringify(json.body));
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
  body.s_id = sSalon.s_id;
  body.s_pw = sSalon.s_pw;

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


