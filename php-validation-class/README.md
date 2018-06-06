# Simple Validation Class (PHP)

This is a small validation class written in PHP.

### Version
1.0.0

### Validation Types

[MAIL]

[URL]

[IP]

[DATE]

[ZIP]

[PHONE]

[INTEGER]

[NUMERIC]

[CURRENCY]

[BASE64]

[ALPHA]

[ALPHANUM]

[LOWERCASE]

[UPPERCASE]

[MIN]

[MAX]

[BETWEEN]

[NOT_EMPTY]

[MATCH]

### Example usage

// Registration Check

// Username: must be between minimum length: 2 and maximum length: 20, not empty

// Password: must be between minimum length: 5 and maximum length: 50, not empty, match Password2

// Password2: must be between minimum length: 5 and maximum length: 50, not empty, match Password

// Email: must be a valid mail, not empty

if(Validate::getInstance()->isValid(

	[ 'name' => 'Username', 'value' => $_POST['Username'], 'min' => 2, 'max' => 20, 
	'validate' => [ Validate::NOT_EMPTY, Validate::BETWEEN ] ],
	
	[ 'name' => 'Password', 'value' => $_POST['Password'], 'min' => 5, 'max' => 50, 
	'match' => $_POST['Password2'], 'validate' => [ Validate::NOT_EMPTY, Validate::BETWEEN, Validate::MATCH ] ],
	
    [ 'name' => 'Password2', 'value' => $_POST['Password2'], 'min' => 5, 'max' => 50, 
	'match' => $_POST['Password'], 'validate' => [ Validate::NOT_EMPTY, Validate::BETWEEN, Validate::MATCH ] ],
	
	[ 'name' => 'Email', 'value' => $_POST['Email'], 'validate' => [ Validate::NOT_EMPTY, Validate::MAIL ] ]
	
) {

	// Valid ..
	
	// ........
	
	// ........
	
} else {

	// Not valid, get last not valid elements

	$lastNoValidData = Validate::getInstance()->getLastNoValidData();
	
	// Get only the names of not valid elements
	
	$noValidElements = array_keys($lastNoValidData);
	
	// Simple check for not valid elements
	
	foreach($noValidElements as $noValidElement) {
	
		// Username is not valid
	
		if($noValidElement == 'Username') {
		
			$errorMessage = translate('index.register.messageInvalidUsername');
			
			break;
			
		}
		
		// Email is not valid
		
		if($noValidElement == 'Email') {
		
			$errorMessage = translate('index.register.messageInvalidMail');
			
			break;
			
		}
	}
	
	// Deep check for not valid elements and validation info
	
	foreach($lastNoValidData as $noValidData) {
	
		// Loop through not valid elements validation info
	
		foreach($noValidData as $noValidElem) {
		
			// Group by not valid element name
		
			if('Password' == $noValidElem['name']) {
			
				// Validation info check
			
				switch($noValidElem['notValid'][0]) {
				
					case 'NOT_EMPTY':
					
						$errorMessage = translate('index.register.messagePassword1NotEmpty');
						
						return;
						
					case 'BETWEEN':
					
						$errorMessage = translate('index.register.messagePassword1Min');
						
						return;
						
					case 'MATCH':
					
						$errorMessage = translate('index.register.messagePassword1Match');
						
						return;
						
				}
				
			}
			
			// Group by not valid element name
			
			if('Password2' == $noValidElem['name']) {
			
				// Validation info check
			
				switch($noValidElem['notValid'][0]) {
				
					case 'NOT_EMPTY':
					
						$errorMessage = translate('index.register.messagePassword2NotEmpty');
						
						return;
						
					case 'BETWEEN':
					
						$errorMessage = translate('index.register.messagePassword2Min');
						
						return;
						
					case 'MATCH':
					
						$errorMessage = translate('index.register.messagePassword2Match');
						
						return;
						
				}
				
			}
			
		}
		
	}
	
}