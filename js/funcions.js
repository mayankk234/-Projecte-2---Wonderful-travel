import { relojAnalogico } from "./rellotge.js";
import * as lib from "./llibreria/elements.js";

document.getElementById("continent").addEventListener("change", paisDesti);
document.getElementById("pais").addEventListener("change", preu);
document.getElementById("descompte").addEventListener("change", preu);
window.onload = paisDesti;



let ampm = true;
let preus = agafarPreus();
let continents = agafarPaisos();
let reserves = agafarReserves();

rellotgeAMPM(ampm);

document.getElementById("relojAnalogico").addEventListener("dblclick",rellotgeAMPM);




dataActual();
mostrarReservas();

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


  selectP.appendChild(lib.crearElement({ tipus: "option", atributs: { "disabled": "", "selected": "", "value": "", "hidden": "" } }));

  if (paisos != undefined) {
    for (var x = 0; x < paisos.length; x++) {
      var opt = document.createElement("option");
      opt.value = paisos[x];
      opt.appendChild(document.createTextNode(paisos[x]));
      selectP.appendChild(opt);
    }
  }

  preu();
  imatge();

}

function dataActual() {
  var now = new Date();

  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);

  var today = now.getFullYear() + "-" + (month) + "-" + (day);

  document.getElementById("date").value = today;
}

function imatge() {
  let divImatge = document.getElementById("imatge");
  var pais = document.getElementById("pais").value;

  while (divImatge.firstChild) {
    divImatge.removeChild(divImatge.firstChild);
  }

  if (pais in preus) {
    console.log(pais);
    divImatge.appendChild(lib.crearElement({ tipus: "img", atributs: { "id": "img", "src": "../imatges/" + pais + ".jpg", "width": "300", "height": '200' } }));
  }
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
  } else {
    pInput.value = '';
  }
  imatge();


}

function mostrarReservas() {
  if (reserves == []) {
    return;
  }
  var divReserves = document.getElementById('reserves');

  for (let reserva of reserves) {
    var imatge = "../imatges/" + reserva.desti + ".jpg";
    var card = lib.crearElement({tipus:"div",atributs:{"class":["card" , "col-4","mb,3"],"style" : "width: 22rem"}});
    card.appendChild(lib.crearElement({tipus:"img",atributs:{"src": imatge, "class" : ["mt-2"]}}))
    var cardBody = lib.crearElement({tipus:"div",atributs:{"class":["card-body"]}});
    card.appendChild(cardBody);
    var divRow = lib.crearElement({tipus:"div",atributs:{"class": ["row"]},contingut:lib.crearElement({tipus:"div",atributs:{"class":["col-6"]}})});
    divRow.appendChild(lib.crearElement({tipus:"div",atributs:{"class":["col-6","text-end"]}}));
    divRow.childNodes[0].appendChild(lib.crearElement({tipus:"h5",atributs :{"class":["card-title"]},contingut: lib.crearText("Destí: " + reserva.desti)}));
    divRow.childNodes[1].appendChild(lib.crearElement({tipus:"a", atributs:{"href" : "../logica/index.php?delete=" + reserva.id},contingut: lib.crearElement({tipus:"img",atributs:{"src":"../imatges/trash-fill.svg"}})}));
    cardBody.appendChild(divRow);
    cardBody.appendChild(lib.crearElement({tipus:"p",atributs :{"class":["card-text"]},contingut: lib.crearText("Nom: " + reserva.nom)}));
    cardBody.appendChild(lib.crearElement({tipus:"p",atributs :{"class":["card-text"]},contingut: lib.crearText("Telefon: " + reserva.telefon)}));
    cardBody.appendChild(lib.crearElement({tipus:"p",atributs :{"class":["card-text"]},contingut: lib.crearText("Persones: " + reserva.persones)}));
    cardBody.appendChild(lib.crearElement({tipus:"p",atributs :{"class":["card-text"]},contingut: lib.crearText("Data: " + reserva.date)}));
    cardBody.appendChild(lib.crearElement({tipus:"p",atributs :{"class":["card-text"]},contingut: lib.crearText("Preu total: " + reserva.preu + "€")}));
    divReserves.appendChild(card);
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
  var paisos = getCookie("paisos");
  try {
    if (paisos != "") paisos = JSON.parse(paisos);
  } catch {
    alert("Per un problema, no es podran mostrar els paisos");
  }
  return paisos
}
function agafarReserves() {
  var reserves = getCookie("reserves");
  try {
    if (reserves != "") reserves = JSON.parse(reserves);
  } catch {
    alert("Per un problema, no es podran mostrar les reserves");
  }
  return reserves
}

function rellotgeAMPM(){
  if(ampm){
    relojAnalogico(document.getElementById('relojAnalogico'),true);
    ampm = false;
  }else{
    relojAnalogico(document.getElementById('relojAnalogico'),false);
    ampm = true;
  }
}
