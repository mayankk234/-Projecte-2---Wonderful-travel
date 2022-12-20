export function crearElement({ tipus, atributs, contingut }) {
    var element = document.createElement(tipus);
    if (atributs !== undefined) {
        if (typeof atributs != "object") throw Error("Arguments passat de manera incorrecte");
    }

    for (var key in atributs) {
        if (key == "class") {
            element.classList.add.apply(element.classList, atributs[key]);
        } else if(atributs[key] == ""){
            element.setAttribute(key, '');
        }
        else {
            element[key] = atributs[key];
        }
    }
    if (contingut) {
        element.appendChild(contingut);
    }
    return element;
}


export function modificarElement(element, atributs) {
    if (atributs === undefined || typeof atributs != "object")return;
    for (var atr in atributs) {
        if (atr == "class") {
            element.removeAttribute("class");
            element.classList.add.apply(element.classList, atributs[atr]);
        } 
        else {
            element[atr] = atributs[atr];
        }
    }
}


export function crearText(text) {
    return document.createTextNode(text);
}

export function up(element) {
    if (element.previousElementSibling)
        element.parentNode.insertBefore(element, element.previousElementSibling);
}

export function down(element) {
    if (element.nextElementSibling)
        element.parentNode.insertBefore(element.nextElementSibling, element);
}

export function abans(video,audio) {
        video.parentNode.insertBefore(video,audio);
}

export function first(element) {
    if (element.previousElementSibling)
        element.parentNode.insertBefore(element, element.parentNode.firstChild);
}

export function last(element) {
    if (element.nextElementSibling)
        element.parentNode.insertBefore(element, element.parentNode.lastChild);
    down(element);
}