const LOC_NEXT = "s-login.html";
const URL_SIGNUP = "php/s_signup.php";
const URL_USER_CHECK_ID = "php/s_checkid.php";
const SUCCESS = 0;

function setItems(){
}

function checkId() {
  var json = new Object();
  json.s_id = document.getElementById("s_id").value;
  if(json.s_id == ""){
    alert("Enter ID");
    return;
  }

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
     if(json.result == SUCCESS) {
        document.getElementById("checker").innerHTML = "Checked!";
      }
      else {
        alert("Service Error\n" + json.error);
      }
    }
    else if (this.readyState == 4 && this.status != 200){
      alert("Connection Error\n" + this.responseText);
    }
  };
  http.open("POST", URL_USER_CHECK_ID, true);
  http.setRequestHeader("Content-Type", "application/json");
  http.send(JSON.stringify(json));
}

function signup() {
  if(document.getElementById("checker").innerHTML != "Checked!"){
    alert("Check your ID first!");
    return;
  }
  var json = new Object();
  json.s_name = document.getElementById("s_name").value;
  json.s_id = document.getElementById("s_id").value;
  json.s_pw = document.getElementById("s_password").value;
  json.s_phonenumber = document.getElementById("s_phonenumber").value;
  json.s_address_si = document.getElementById("s_address_si").value;
  json.s_address_gu = document.getElementById("s_address_gu").value;
  json.s_address_detail = document.getElementById("s_address_detail").value;
  json.h_name_1 = document.getElementById("h_name_1").value;
  json.h_gender_1 = document.getElementById("h_gender_1").value;
  json.h_career_1 = document.getElementById("h_career_1").value;
  json.h_name_2 = document.getElementById("h_name_2").value;
  json.h_gender_2 = document.getElementById("h_gender_2").value;
  json.h_career_2 = document.getElementById("h_career_2").value;
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

  if (json.s_pw.length < 4 ){
    alert("Please Enter At Least 4 Characters");
    return;
  }

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var json = JSON.parse(this.responseText);
      if(json.result == 0) {
        console.log("success");
        location.assign(LOC_NEXT);
      }
      else {
        alert("Service Error\n" + json.error);
      }
    }
    else if (this.readyState == 4 && this.status != 200){
      alert("Connection Error\n" + this.responseText);
    }
  };
  http.open("POST", URL_SIGNUP, true);
  http.setRequestHeader("Content-Type", "application/json");
  http.send(JSON.stringify(json));
}



