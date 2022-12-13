import {relojAnalogico} from "./rellotge.js";

relojAnalogico(document.getElementById('relojAnalogico'));
document.getElementById("continent").addEventListener("change", paisDesti);
let continents = {"Asia": ["India", "China", "Bangladesh", "Tailandia"], "Africa": ["Zimbabwe","Uganda","Senegal","Ghana"], "Europa": ["Alemania","Francia","Belgica","Italia"], "America": ["Argentina", "Mexico", "Peru", "Colombia"]};




paisDesti();
function paisDesti(){
  var con = document.getElementById("continent").value;
  var paisos = [];
  
  try{
    paisos.push(continents[con]);
  }catch{
    alert("continent erroni");
    return;
  }

  let selectP = document.getElementById("pais");

  while(selectP.firstChild){
    selectP.removeChild(selectP.firstChild);
  }

  for(var x = 0; x < paisos[0].length; x++){
    var opt = document.createElement("option");
    opt.value = paisos[0][x];
    opt.appendChild(document.createTextNode(paisos[0][x]));
    selectP.appendChild(opt);
  }


}