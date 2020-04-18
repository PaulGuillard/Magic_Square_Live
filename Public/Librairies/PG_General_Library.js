class PGGeneralLibrary{ //export default class : export allows selective export of components from this file, without loading the complete file. To import: import ComponentName from './PG_General_Library'

static getJsonObjectFromAPI(url) { //requires a getResponse variable defined in the code using this method

	let resultsArray = [];
	let jsonResponse = get(url, onGetRequestDone);

	function get(getUrl, onResponseValid) {
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() {
		    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
		    	if (this.responseText != '') 
		    	{
		    		console.log('retour de la requete GET : ' + this.responseText);
		    		let getResponse = JSON.parse(this.responseText);
		        	onResponseValid(getResponse);
		    	}
		    }
		};
		request.open("GET", getUrl);
		request.send();
	}

	function onGetRequestDone(result) {
	    resultsArray.push(result);
	}

	return resultsArray;

}

static getArray(url) { //requires a getResponse variable defined in the code using this method

	let resultsArray = [];
	let jsonResponse = get(url, onGetRequestDone);

	function get(getUrl, onResponseValid) {
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() {
		    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
		    	if (this.responseText != '') 
		    	{
		    		console.log('retour de la requete GET : ' + this.responseText);
		    		let getResponse = this.responseText;
		        	onResponseValid(getResponse);
		    	}
		    }
		    else
		    {
		    	console.log('Error during getArray method application');
		    }
		};
		request.open("GET", getUrl);
		request.send();
	}

	function onGetRequestDone(result) {
		resultsArray.push(JSON.parse(result));
	    /*resultsArray.push(result);*/
	}

	return resultsArray; //Returns a table of format [[Data]] - result[0] is the result as a table

}

static postJsonObject(url, jsonData) {
	var request = new XMLHttpRequest();
	request.open("POST", url);
	request.setRequestHeader("Content-Type", "application/json");
	request.send(JSON.stringify(jsonData));
}

static checkText(text, minLength) {
	if (minLength && minLength == 0) {
		return /^[0-9a-zA-Z'-_@!?()+\/.#&"ÇÀÉÊÈëËïÏÔàâçèéêîôùûÜÛ\w\d\s\n\t\r]*$/.test(text); /*'-_@!?()+/.#&"\s\n*/
	}
	else
	{
		return /^[0-9a-zA-Z'-_@!?()+\/.#&"ÇÀÉÊÈëËïÏÔàâçèéêîôùûÜÛ\w\d\s\n\t\r]+$/.test(text); /*'-_@!?()+/.#&"\s\n*/
	}
}

static checkEmail(email) {
	return /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(email);
}

static checkNumber(number, minLength) {
	if (minLength) {
		return /^[0-9]{minLength,}$/.test(number);
	}
	else
	{
		return /^[0-9]{1,}$/.test(number);
	}
}

}