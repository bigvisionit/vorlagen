# Simple Validation Class (JS)

This is a small (minified size: 4 KB) validation class written in JavaScript.

### Version
1.0.0

### Validation Types

[ISSET]

[NOT_EMPTY]

[MAIL]

[URL]

[DATE]

[ZIP]

[PHONE]

[INTEGER]

[NUMERIC]

[CURRENCY]

[IP]

[BASE64]

[ALPHA]

[ALPHANUM]

[LOWERCASE]

[UPPERCASE]

[MIN]

[MAX]

[BETWEEN]

[MATCH]

### Example usage

// Registration Check

// Username: must be between minimum length: 2 and maximum length: 20, not empty

// Password: must be between minimum length: 5 and maximum length: 50, not empty, match Password2

// Password2: must be between minimum length: 5 and maximum length: 50, not empty, match Password

// Email: must be a valid mail, not empty


if(Validate.isValid(

	{ name: 'Username', value: $('#username').val(), min: 2, max: 20, 
	validate: [ Validate.NOT_EMPTY, Validate.BETWEEN ] },
	
	{ name: 'Password', value: $('#password').val(), min: 5, max: 50, 
	validate: [ Validate.NOT_EMPTY, Validate.BETWEEN, Validate.MATCH ] },
	
	{ name: 'Password2', value: $('#password2').val(), min: 5, max: 50, 
	validate: [ Validate.NOT_EMPTY, Validate.BETWEEN, Validate.MATCH ] },
	
	{ name: 'Email', value: $('#email').val(), 
	validate: [ Validate.NOT_EMPTY, Validate.MAIL ] }
	
)) {

	// Valid ..

	// ........

	// ........ 
} else {
	
	// Not valid, get last not valid elements

	var lastNoValidData = Validate.getLastNoValidData();
	
	// Get only the names of not valid elements
	
	var noValidElements = Object.keys(lastNoValidData);
	
	var errorMessage = '';
	
	// Simple check for not valid elements
	
	for(var i = 0; i < noValidElements.length; i++) {
	
		// Username is not valid
	
		if(noValidElements[i] == 'Username') {
		
			errorMessage = translate('index.register.messageInvalidUsername');
			
			break;
			
		}
		
		// Email is not valid
		
		if(noValidElements[i] == 'Email') {
		
			errorMessage = translate('index.register.messageInvalidMail');
			
			break;
			
		}
		
	}
	
	// Deep check for not valid elements and validation info
	
	 for(var elementName in lastNoValidData) {

		// Loop through not valid elements validation info

		for(var i in lastNoValidData[elementName]) {

			// Group by not valid element name

			if('Password' == elementName) {

				// Validation info check

				for(var j in lastNoValidData[elementName][i]['notValid']) {

					switch(lastNoValidData[elementName][i]['notValid'][j]) {

						case 'NOT_EMPTY':

							errorMessage = translate('index.register.messagePassword1NotEmpty');

							break;
							
						case 'BETWEEN':

							errorMessage = translate('index.register.messagePassword1Min');

							break;
							
						case 'MATCH':

							errorMessage = translate('index.register.messagePassword1Match');

							break;

					}
				}

			}
			
			// Group by not valid element name

			if('Password2' == elementName) {

				// Validation info check

				for(var j in lastNoValidData[elementName][i]['notValid']) {

					switch(lastNoValidData[elementName][i]['notValid'][j]) {

						case 'NOT_EMPTY':

							errorMessage = translate('index.register.messagePassword2NotEmpty');

							break;
							
						case 'BETWEEN':

							errorMessage = translate('index.register.messagePassword2Min');

							break;
							
						case 'MATCH':

							errorMessage = translate('index.register.messagePassword2Match');

							break;

					}
				}

			}
		}
	}
	
}