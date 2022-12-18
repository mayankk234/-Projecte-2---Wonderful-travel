import { relojAnalogico } from "./rellotge.js";

relojAnalogico(document.getElementById('relojAnalogico'));
document.getElementById("continent").addEventListener("change", paisDesti);
document.getElementById("pais").addEventListener("change", preu);
document.getElementById("descompte").addEventListener("change", preu);
window.onload = paisDesti;


let preus = agafarPreus();
let continents = agafarPaisos();



function paisDesti() {
  var con = document.getElementById("continent").value;
  var paisos;
  
  try {
    paisos = continents[con];
  } catch {
    alert("continent erroni");
    return;
  }
  
  let selectP = document.getElementById("pais");
  
  while (selectP.firstChild) {
    selectP.removeChild(selectP.firstChild);
  }
  
  for (var x = 0; x < paisos.length; x++) {
    var opt = document.createElement("option");
    opt.value = paisos[x];
    opt.appendChild(document.createTextNode(paisos[x]));
    selectP.appendChild(opt);
  }

  preu();


}

function preu() {
  var pais = document.getElementById("pais").value;
  var pInput = document.getElementById("preu");
  var descompte = document.getElementById("descompte");

  if (pais in preus) {
    if (descompte.checked) {
      var preu = preus[pais] * 0.8;
      pInput.value = preu + " €";
    } else {
      pInput.value = preus[pais] + " €";
    }
  }else{
    pInput.value = '';
    alert("El pais escollit no es correcte");
  }

  
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


function agafarPreus() {
  var preus = getCookie("preus");
  try {
    if (preus != "") preus = JSON.parse(preus);
  } catch {
    alert("Per un problema, no es podran mostrar els preus");
  }
  return preus
}


function agafarPaisos() {
  var preus = getCookie("paisos");
  try {
    if (preus != "") preus = JSON.parse(preus);
  } catch {
    alert("Per un problema, no es podran mostrar els preus");
  }
  return preus
}
