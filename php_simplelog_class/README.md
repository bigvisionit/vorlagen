# Simple Log Class (PHP)

This is a simple Log class with some fantastic features.

options:

- _deleteOlderLogFiles: delete older files

- _deleteAfterDays: delete older files after days (_deleteOlderLogFiles must be set to true)

- _logByDays: creates every day a new logfile

- _logIP: logs the ip

If the log file becomes too large (over 1MB), it will be archived and a new one will be created.

### Version
1.0.0


### Example usages

logs a simple message in your logfile:

Log::getInstance()->write('My log message');

logs a simple message and start time in your logfile:

Log::getInstance()->startLog()

logs a simple message and stop time in your logfile:

Log::getInstance()->endLog()


logs a simple message with type and unique id (3rd parameter null -> generates a new one):

Log::getInstance()->log('My log message', SimpleLog::INFO)

it logs also the client data (platform, browser, ip)( (4rd parameter must be true)

you can also pass the file and line for error handling using the ErrorHandler class (paramater 5 and 6)


possible log types:

SimpleLog::INFO

SimpleLog::WARNING

SimpleLog::NOTICE

SimpleLog::ERROR

SimpleLog::DEBUG

SimpleLog::OTHER

SimpleLog::UNKNOWN

you can also add your own type


logs an exception:

Log::getInstance()->logException('My log message')

If you want to change the path to the logfolder,
you have to change it in the __constrtuct method: $this->_file = dirname(__FILE__) . '/../yourpath/' . $this->_file;