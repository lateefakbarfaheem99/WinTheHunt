function MoveOption(objSourceElement, objTargetElement) {
	var aryTempSourceOptions = new Array();
	var x = 0;                //looping through source element to find selected options
	for (var i = 0; i < objSourceElement.length; i++) {
		if (objSourceElement.options[i].selected) {                //need to move this option to target element
			var intTargetLen = objTargetElement.length++;
			objTargetElement.options[intTargetLen].text = objSourceElement.options[i].text;
			objTargetElement.options[intTargetLen].value = objSourceElement.options[i].value;
		} else {                //storing options that stay to recreate select element
			var objTempValues = new Object();
			objTempValues.text = objSourceElement.options[i].text;
			objTempValues.value = objSourceElement.options[i].value;
			aryTempSourceOptions[x] = objTempValues;
			x++;
		}
	}                //resetting length of source
	objSourceElement.length = aryTempSourceOptions.length;        //looping through temp array to recreate source select element
	for (var i = 0; i < aryTempSourceOptions.length; i++) {
		objSourceElement.options[i].text = aryTempSourceOptions[i].text;
		objSourceElement.options[i].value = aryTempSourceOptions[i].value;
		objSourceElement.options[i].selected = false;
	}
}

function SelectOption(objTargetElement) {
	for (var i = 0; i < objTargetElement.length; i++) {
		objTargetElement.options[i].selected = true;
	}
}