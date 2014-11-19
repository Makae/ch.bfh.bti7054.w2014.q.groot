function mouseOver(element) {
	console.log("Du bist auf: " + element.textContent);
	//element.style.display = 
}


function checkFormats(name, value) {
	console.log("Geprüftes Feld: "+ name +"  mit dem Wert: " + value);

	if(name=="firstname") {
		for(var i=0; i<value.length; i++) {
			if(!isNaN(value.charAt(i)))
				console.log("fehler"); 
			}
	}
	
	if(name=="streetnr"){
		if(isNaN(value)) {
			console.log("Strassennummer ist ungültig");
			return false;
		}
	}
	
	//Bei der Emailadresse auf @ Zeichen, .-toplevel prüfen
	return true;
	
}



function checkEntries() {
	
	//Alle Input Felder, die Text entgegennehmen mit dem QuerySelector auslesen. Speichern in nodes, was automatisch zu einer Nodelist wird
	var nodes = document.querySelectorAll("#personalForm input[type=text]");
	console.log("TEST: "+ nodes.length);
	
	for (var i=0; i<nodes.length; i++) {
		console.log("Feld gefunden: ");
		console.log("Wert "+i + ": " +nodes.item(i).value);
	}
	
	/*Aus dem personalForm alle Input Tags auslesen. Nachteil: Nimmt auch Country.
	 * Deshalb die Liste noch filtern, nach Elementen vom type == "text" */
	
	var elements = document.getElementById('personalForm').getElementsByTagName('input');
	var i=0;
	var allOK = true;
	var allVOK = true;
	
	fieldsArray = new Array();
		
	//Filtern nach den Input type=text elementen
	for(i; i<elements.length; i++) {
		if(elements.item(i).type =="text")
			fieldsArray.push(elements.item(i));}
	
	
	
	
	//nun habe ich ein Array mit nur noch den text Elementen
	for(var j=0; j<fieldsArray.length; j++) {


		
		if(fieldsArray[j].value=="") {
			fieldsArray[j].style.backgroundColor="#FF8000";
			allOK= false;
		}
		else
			fieldsArray[j].style.backgroundColor="white"; 
		}
	
	
	for(var j=0; j<fieldsArray.length; j++) {
		if(!checkFormats(fieldsArray[j].name, fieldsArray[j].value)) {
		console.log("Falscher Wert bei: " + fieldsArray[j].name);
		window.alert("Werte können nicht stimmen");
		allVOK= false;
		}
		
	}
	
	
	
	
	if(!allOK)
		window.alert("Bitte die markierten Felder ausfüllen");
	
	if(allOK&&allVOK)
	document.getElementById("personalForm").submit();
	
}






function onSubmit() {
input = window.confirm("Mit OK wird die Bestellung definitiv getätigt.");
if(!input) 
	return false;
else
	return true;

}







/*Funktion, die aufgerufen wird, nachdem man auf der ersten Bestellseite die Buchoption und die Zahlungsvariante inkl. Shipping
 * ausgewählt hat. Prüft, ob alle notwendigen Eingaben gemacht wurden. */

function nextValidation() {
	//Prüfen, ob Zahlungsmethode ausgewählt wurde:
	var nList = document.getElementsByName("paymentBox[]");	
	var filled = false;
	
	for(var i=0; i<nList.length; i++) {
		console.log(""+ nList.item(i).value);
		if(nList.item(i).checked==true)
			filled=true;
	}
	
	//warum sind hier die Values nicht mehr gesetzt?
	for (value in nList) {
		console.log("Box: "+ value.value);
	}
	
	if(!filled) {
		window.alert("Bitte Zahlung auswählen!");
	}
	return filled;
}





function uniqueCheck(box) {
	var nList = document.getElementsByName("paymentBox[]");	
	for(var i=0; i<nList.length; i++) {
		
	if(nList.item(i).value!=box.value){	
		if(box.checked && nList.item(i).checked) 
			nList.item(i).checked=false;
		}
	}
}





function confirmIT() {
    result = window.confirm("Do you really want to buy these products?"); 
    if (!result)
         return false; 
}

    
