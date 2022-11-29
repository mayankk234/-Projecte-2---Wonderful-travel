import {relojAnalogico} from "./rellotge.js";

relojAnalogico(document.getElementById('relojAnalogico'));
document.getElementById("continent").addEventListener("change", paisDesti);


let continents = {"Asia": ["India", "Bangkok", "Bangladesh", "Tailandia"], "Africa": ["Zimbabwe","Uganda","Senegal","Ghana"], "Europa": ["Alemania","Francia","Belgica","Italia"], "America": ["Argentina", "Mexico", "Peru", "Colombia"]};


function paisDesti(){
  var paisos = [];
  var con = document.getElementById("continent").value;
  try {
    paisos.push(continents[con]);
  } catch (error) {
    throw Error("El continent que s'intenta escollir no existeix");
  }
  var selPais = document.getElementById("pais").options;

  selPais = [];

  selPais.push(paisos);

}