# Simple ErrorHandler Class (PHP)

This is a simple ErrorHandler class with Logging functionality.

### Version
1.0.0


### Example usages

Include ErrorHandler.php in your project and it works!

You can change the style and error output information. 
Just change the output in the handle_exception() function.

You can also change the _multipleErrors - Option to show all exception errors.

SimpleLog.php is needed for logging the error messages.

If you want to change the path to the logfolder,
you have to change it in the __constrtuct method: $this->_file = dirname(__FILE__) . '/../yourpath/' . $this->_file;