# Simple Helper Class (PHP)

This is a simple Helper class with some useful functions.

All functions are static.

Functions overview:

- send mail

- log text to file (as string or as array of lines with custom separator)

- read text from file (as string or as array of lines with custom separator)

- read csv from file (as string or as array of lines with custom separator)

- include file to string

- resample image (e.g. for thumbnails or resizing)

- is localhost check

- string starts with and string ends with function

- print_r_pre and var_dump_pre (output with '<pre>' tag)

- get, post, request, server, session helper functions

- is post, is ajax helper functions

- unset session, is null or empty, is integer helper functions

- random string function (e.g. to generate passwords)

- get page url with params function

- get client ip function

- get client browser function (platform, browser name, version)

- get holidays function (get german holidays)

- is holiday function (check for german holidays from date)

### Version
1.0.0


### Example usages

//..
if(Helper::isPost()) {
	$username = Helper::post('username');
	
	if(null != $username) {
		// log user with date
		Helper::logText('User ' . $username . ' logged', 'logs/logs.txt', true);
	}
	//..
}
//..