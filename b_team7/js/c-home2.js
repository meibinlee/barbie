const LOC_NEXT = "c-home.html";
const URL_PROFILE = "php/c_home.php";
const SUCCESS = 0;

var cCustomer;
var salon;
var reservation;

function setItems(){
  getCountries();

  var item = sessionStorage.getItem("customer");
  if(item != null) {
    cCustomer = JSON.parse(item);
    document.getElementById("customer_name").innerHTML = "<h2><b>" + cCustomer.c_name + "'s HOME</b></h2>";
  }
  else {
    location.assign(LOC_LOGIN);
  }
}

function showNearSalon() {
   var buff = '';

   var buff = '<table class="w3-table w3-bordered w3-striped w3-border test w3-hoverable">';
   buff += '<tr class="w3-black">';
   buff += '<th>SALON<th>';
   buff += '<th>PHONENUMBER<th>';
   buff += '<th>SI<th>';
   buff += '<th>GU<th>';

   for (customer of cCustomer) {
      buff += '<tr>';
      buff += '<td>' + customer.c_id + '</td>';
      buff += '<td>' + customer.c_phonenumber + '</td>';
      buff += '<td>' + customer.c_address_si + '</td>';
      buff += '<td>' + customer.c_address_gu + '</td></tr>';
   }
   buff =+ '<table>'

   document.getElementById("customer").innerHTML = buff; 
}

function showTodayReservation() {
   var buff = '';

   var buff = '<table class="w3-table w3-bordered w3-striped w3-border test w3-hoverable">';
   buff += '<tr class="w3-black">';
   buff += '<th>DATE<th>';
   buff += '<th>TIME<th>';

   for (user of cUser) {
      buff += '<tr>';
      buff += '<td>' + reservation.r_date + '</td>';
      buff += '<td>' + reservation.r_time + '</td></tr>';
   }
   buff =+ '<table>'

   document.getElementById("reservation").innerHTML = buff; 
}