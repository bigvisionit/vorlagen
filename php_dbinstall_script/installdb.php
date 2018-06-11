<?php

// Define path to application directory
defined('INSTALL_SCRIPT_PATH') || define('INSTALL_SCRIPT_PATH', realpath(dirname(__FILE__)));

function checkPostParam($param) {
	return isset($_POST[$param]);
}

function compareVersions($version1, $version2) {
	return version_compare($version1, $version2);
}

function execSqlScript($sql) {
	if(checkPostParam('setup_db_type') && $_POST['setup_db_type'] == 'mysql' && checkPostParam('setup_db_name') && checkPostParam('setup_db_user') && checkPostParam('setup_db_password') && checkPostParam('setup_db_host') && checkPostParam('setup_db_port')) {
		$dbConnection = new PDO($_POST['setup_db_type'].':host='.$_POST['setup_db_host'].';port='.$_POST['setup_db_port'].';dbname='.$_POST['setup_db_name'].';charset=UTF8', $_POST['setup_db_user'], $_POST['setup_db_password']);
		
		$dbConnection->beginTransaction();
		try {
			$statement = $dbConnection->prepare($sql);
			$statement->execute();
			while ($statement->nextRowset()) {/* https://bugs.php.net/bug.php?id=61613 */};
			$dbConnection->commit();
		} catch (PDOException $e) {
			$dbConnection->rollBack();
			$errorInfo = $e->errorInfo;
			header("HTTP/1.1 500 Internal Server Error");
			echo 'ERROR WHILE EXECUTING SQL SCRIPT:'.PHP_EOL;
			echo 'ERROR SQL RETURNCODE: '.$errorInfo[1].PHP_EOL;
			echo 'ERROR SQL MESSAGE: '.$errorInfo[2].PHP_EOL;
			echo '#####################################'.PHP_EOL;
			echo '### [BUILD ERROR]'.PHP_EOL;
			echo '#####################################'.PHP_EOL;
			exit(1);
		}
		
		//$qry = $dbConnection->exec($sql);
	} else {
		throw new Exception('Database connection parameters are not available.');
	}
}

function checkDatabaseConnection() {
	if(checkPostParam('setup_db_type') && $_POST['setup_db_type'] == 'mysql' && checkPostParam('setup_db_name') && checkPostParam('setup_db_user') && checkPostParam('setup_db_password') && checkPostParam('setup_db_host') && checkPostParam('setup_db_port')) {
		$mysqli = @mysqli_connect($_POST['setup_db_host'], $_POST['setup_db_user'], $_POST['setup_db_password'], $_POST['setup_db_name'], $_POST['setup_db_port']);
		
		if (mysqli_connect_error()) {
			return false;
		}
		
		$mysqli->close();
		
		return true;
	}
	return false;
}


function openDatabaseConnection() {
	if(checkPostParam('setup_db_type') && $_POST['setup_db_type'] == 'mysql' && checkPostParam('setup_db_name') && checkPostParam('setup_db_user') && checkPostParam('setup_db_password') && checkPostParam('setup_db_host') && checkPostParam('setup_db_port')) {
		$mysqli = @mysqli_connect($_POST['setup_db_host'], $_POST['setup_db_user'], $_POST['setup_db_password'], $_POST['setup_db_name'], $_POST['setup_db_port']);

		if (mysqli_connect_error()) {
			return null;
		}

		$mysqli->close();

		return $mysqli;
	}
	return null;
}

function findExistingInstallation() {
	if(file_exists(INSTALL_SCRIPT_PATH . '/../application/configs/system.ini')
			&& file_exists(INSTALL_SCRIPT_PATH . '/../application/configs/system.ini')
			&& file_exists(INSTALL_SCRIPT_PATH . '/../library/Zend/Config/Ini.php') ) {

		set_include_path(implode(PATH_SEPARATOR, array(
				realpath(INSTALL_SCRIPT_PATH . '/../library'),
				get_include_path()
		)));

		require_once INSTALL_SCRIPT_PATH . '/../library/Zend/Config/Ini.php';

		$configSystem = new Zend_Config_Ini(INSTALL_SCRIPT_PATH . '/../application/configs/system.ini', 'production');
		$configSystem = new Zend_Config_Ini(INSTALL_SCRIPT_PATH . '/../application/configs/system.ini', 'production');

		$existingVersion = $configSystem->system->version;

		$result = array();

		$result['existing'] = true;

		$configData = array();
		$configData['version'] = $existingVersion;

		$configData['db.type'] = $configSystem->system->db->type;
		$configData['db.user'] = $configSystem->system->db->user;
		$configData['db.password'] = $configSystem->system->db->password;
		$configData['db.host'] = $configSystem->system->db->host;
		$configData['db.port'] = $configSystem->system->db->port;
		$configData['db.name'] = $configSystem->system->db->name;

		$result['configData'] = $configData;

		return $result;
	} else {
		$result = array();
		$result['existing'] = false;
		return $result;
	}
}

$action = (isset($_GET['action'])) ? $_GET['action'] : null;
if(empty($action)) {
	$action = 'start';
}

?><?php if($action == 'start') : ?>
<?php 
$dbInstallFiles = scandir(INSTALL_SCRIPT_PATH . '/../db/install/');
usort($dbInstallFiles, 'compareVersions');

$sizeInstallFiles = count($dbInstallFiles);

$installFile = $dbInstallFiles[($sizeInstallFiles-1)];
if($installFile == '..' || $installFile == '.') {
	throw new Exception('Could not find database installation files.');
}

$installFileVersion = str_replace('.sql', '', $installFile);
//echo $installFileVersion;

$dbScriptFolders = array();
$dbScriptFilesTmp = scandir(INSTALL_SCRIPT_PATH . '/../db/scripts/');
foreach($dbScriptFilesTmp as $scriptFileTmp) {
	if($scriptFileTmp != '.' && $scriptFileTmp != '..' && $scriptFileTmp != 'archive') {
		if(compareVersions($scriptFileTmp, $installFileVersion) > 0) {
			$dbScriptFolders[] = $scriptFileTmp;
		}
	}
}

usort($dbScriptFolders, 'compareVersions');

$dbScripts = array();

foreach($dbScriptFolders as $dbScriptFolder) {
	$tmpFiles = scandir(INSTALL_SCRIPT_PATH . '/../db/scripts/'.$dbScriptFolder.'/');
	sort($tmpFiles);

	foreach($tmpFiles as $tmpFile) {
		if($tmpFile != '..' && $tmpFile != '.') {
			$dbScripts[$dbScriptFolder][] = $tmpFile;
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>System Setup</title>
<style>
html { height: 100%; min-height: 100%; }
body { height: 100%; font-size: 13px; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; line-height: 1; text-align: center; color: #333333; }
ul, li, img, h1, h2, h3, h4, h5, h6, form, p, body, html { margin: 0; padding: 0; line-height: 1; }
img { border: 0; display: block; }
p { padding: 0 0 10px 0; font-size: 13px; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; line-height: 18px; }
li { line-height: 18px; }
a { color: #1799B5; text-decoration: none; }
a:hover { color: #14303D; text-decoration: underline; }
h1 { color: inherit; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; font-weight: 400; font-size: 26px; line-height: 32px; padding-bottom: 10px; }
h2 { color: #14303D; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; font-weight: 400; font-size: 26px; line-height: 32px; padding-bottom: 10px; }
h3 { color: #14303D; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; font-weight: 400; font-size: 18px; line-height: 28px; padding-bottom: 10px; }
h4 { color: #14303D; font-family: 'arial', 'helvetica', 'tahoma', 'sans-serif'; font-weight: 700; font-size: 14px; line-height: 22px; padding-bottom: 5px; }

a.button { white-space: nowrap; border: 1px solid #CCCCCC; font-size: 13px; font-weight: bold; color: #FFFFFF !important; text-decoration: none; background: #AAAAAA; line-height: 30px; padding: 6px 20px; }
a.button:hover { color: #FFFFFF !important; text-decoration: none; border: 1px solid #AAAAAA; background: #CCCCCC; }

span.connection_status { white-space: nowrap; border: 1px solid transparent; font-size: 13px; font-weight: bold; line-height: 30px; padding: 6px 0px; }
span.connection_error { white-space: nowrap; border: 1px solid transparent; font-size: 13px; font-weight: bold; line-height: 30px; padding: 6px 0px; }
span.connection_error.green { color: #008C00; }
span.connection_error.red { color: #CC0000; }

#container { background: #FFFFFF; width: 640px; margin: 0 auto; text-align: left; min-height: 300px; }
#content { padding: 30px 40px; }

#headContainer { 
min-width: 640px;
width: 100%;
text-align: left;
height: 100px;
padding-top: 0px;
}

#header { position: relative; width: 640px; height: 100px; margin: 0 auto; }
#header h1 { z-index: 10; position: absolute; display: block; overflow: hidden; 
width: 155px; height: 35px; 
top: 40px; left: 0px; 
text-indent: -999px; 
}

hr { border: none; border-top: 1px solid #DDDDDD; background-color: transparent; height: 1px; margin: 20px 0 20px 0; padding: 0; }
p + hr { margin-top: 10px; }


form { display: block; padding-bottom: 0px; padding-top: 0px; }
div.formwrapper, span.formwrapper { padding: 5px 5px; background: #FFFFFF;
   -moz-box-shadow:    inset 0px 1px 3px #999999;
   -webkit-box-shadow: inset 0px 1px 3px #999999;
   box-shadow:         inset 0px 1px 3px #999999;
}
input[type="text"] { font-family: inherit; font-size: 12px; width: 220px; height: 26px; margin: 0 0 0 0px; padding: 0 0 0 4px; line-height: 22px; border: 1px solid #999999; color: #333333; }
input[type="password"] { font-family: inherit; font-size: 12px; width: 220px; height: 26px; margin: 0 0 0 0px; padding: 0 0 0 4px; line-height: 22px; border: 1px solid #999999; color: #333333; }

div.formwrapper input[type="text"], span.formwrapper input[type="text"] { border: none; padding: 0; margin: 0; width: 100%; display: block; height: 22px; background: transparent; color: #333333; }
div.formwrapper input[type="password"] { border: none; padding: 0; margin: 0; width: 100%; display: block; height: 22px; background: transparent; color: #333333; }
div.formwrapper select, span.formwrapper select { border: none; padding: 2px 0 0 0; margin: 0; width: 100%; display: block; height: 22px; background: transparent; color: #333333; }
div.formwrapper textarea { border: none; padding: 0; margin: 0; width: 100%; display: block; background: transparent; color: #333333; }

div.formwrapper.readonly { background: #DDDDDD; }
div.formwrapper.readonly select { background: #DDDDDD; color: #666666; }
div.formwrapper.readonly input { background: #DDDDDD; color: #666666; }

select { font-family: inherit; font-size: 12px; width: 226px; height: 28px; margin: 0 0 0 0px; padding: 3px 0 3px 4px; line-height: 22px; border: 1px solid #999999; color: #333333; }


label { font-weight: bold; color: #333333; }
form  dl > dd label { font-weight: normal; }

form  dl { display: block; margin: 0; padding: 0; }
form  dl > dt { font-size: 13px; width: 150px; display: block; float: left; height: 34px; line-height: 34px; margin-bottom: 3px; padding-right: 10px; }
form  dl > dd { min-height: 34px; line-height: 34px; margin-bottom: 3px; padding: 0; display: block; margin-left: 170px; }

form ul.errors { margin-left: 0px; padding-bottom: 0px !important; margin-top: 2px; }
form ul.errors > li { color: #CC0000; font-size: 11px; list-style: none; 

#content { position: relative; z-index: 1; }
#content #loader { display: none; position: absolute; z-index: 100; background: #FFFFFF; left: 0px; top: 0px; right: 0px; bottom: 0px; background: rgba(255, 255, 255, 0.7); }
#content #loader.visible { display: block; }
#content #loader div { height: 100%; width: 100%; }
#content #loader p { position: absolute; top: 50%; text-align: center; left: 0px; right: 0px; padding-top: 50px; font-weight: bold; }

</style>
<script src="//code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

	$("form").submit(function(e) {
	    return false;
	});

	var checkField = function(fieldId, message, allowedValues) {
		var field = $(fieldId);
		var fieldDD = field.closest('dd');
		if($.trim(field.val()).length > 0) {
			var fieldValue = $.trim(field.val());
			if(allowedValues != null) {
				var allowedResult = false;
				$.each(allowedValues, function( index, value ) {
					if(fieldValue == value) {
						allowedResult = true;
						return false;
					}
				});

				if(allowedResult) {
					$('ul.errors', fieldDD).remove();
					return 0;
				}
			} else {
				$('ul.errors', fieldDD).remove();
				return 0;
			}
		}

		$('ul.errors', fieldDD).remove();
		fieldDD.append('<ul class="errors"><li>'+message+'</li></ul>');
		
		return 1;
	};

	var checkDbFields = function() {
		var result = 0;
		result += checkField('#setup_db_type', 'Please select a valid option.', ['mysql']);
		result += checkField('#setup_db_name', 'Please insert a valid database name.', null);
		result += checkField('#setup_db_user', 'Please insert a valid database username.', null);
		//result += checkField('#setup_db_password', 'Please insert a valid database password.', null);
		result += checkField('#setup_db_host', 'Please insert a valid database host.', null);
		result += checkField('#setup_db_port', 'Please insert a valid database port.', null);

		return result;
	};

	var checkAllFields = function() {
		var result = 0;
		result += checkDbFields();
		
		return result;
	};

	var getFieldValue = function(fieldId) {
		return $.trim($(fieldId).val());
	};

	var doCheckDatabaseConnection = function(startInstallation) {

		$('#loader p').text('');
		var formData = new FormData();

		formData.append('setup_db_type', getFieldValue('#setup_db_type'));
		formData.append('setup_db_name', getFieldValue('#setup_db_name'));
		formData.append('setup_db_user', getFieldValue('#setup_db_user'));
		formData.append('setup_db_password', getFieldValue('#setup_db_password'));
		formData.append('setup_db_host', getFieldValue('#setup_db_host'));
		formData.append('setup_db_port', getFieldValue('#setup_db_port'));

		

		$.ajax({
			type: "POST",
			url: '/installdb.php?action=testdb',
			data: formData,
			processData: false, contentType: false,
			beforeSend: function() {
				$('#loader').addClass('visible');
				$('#connection_status .connection_error').text('');
				$('#connection_status .connection_error').removeClass('red');
				$('#connection_status .connection_error').removeClass('green');
			}
		})
			.done(function(data) {
				$('#loader').removeClass('visible');
				if('ok' == data) {
					$('#connection_status .connection_error').text('Connecting successful.');
					$('#connection_status .connection_error').addClass('green');

					if(startInstallation) {
						doInstall();
					}
					
				} else {
					
					$('#connection_status .connection_error').text('Connecting failed.');
					$('#connection_status .connection_error').addClass('red');
					alert('Connecting failed.');
				}
				//$('#order_content').html(data);
				//initOrder();
			})
			.fail(function() {
				$('#loader').removeClass('visible');
				$('#content').html('<h2>Unexpected error</h2>');
			})
			.always(function() {
				
			});
		
	};


	var doExecSqlDrop = function() {

		var result = false;

		var formData = new FormData();

		formData.append('setup_db_type', getFieldValue('#setup_db_type'));
		formData.append('setup_db_name', getFieldValue('#setup_db_name'));
		formData.append('setup_db_user', getFieldValue('#setup_db_user'));
		formData.append('setup_db_password', getFieldValue('#setup_db_password'));
		formData.append('setup_db_host', getFieldValue('#setup_db_host'));
		formData.append('setup_db_port', getFieldValue('#setup_db_port'));
		
		$.ajax({
			type: "POST",
			url: '/installdb.php?action=execsqldrop',
			async: false,
			data: formData,
			processData: false, contentType: false,
			beforeSend: function() {
				$('#loader p').text('Dropping existing database... (Step 1/1)');
				$('#loader').addClass('visible');
			}
		})
			.done(function(data) {
				result = true;
				
			})
			.fail(function() {
				//$('#content').html('<h2>Unexpected error</h2>');
			})
			.always(function() {
				$('#loader').removeClass('visible');
			});

		return result;
	};


	var doFinish = function() {

		var result = false;

		var formData = new FormData();

		$.ajax({
			type: "POST",
			url: '/installdb.php?action=finish',
			async: false,
			data: formData,
			processData: false, contentType: false,
			beforeSend: function() {
				$('#loader p').text('Finish installation... (Step 1/1)');
				$('#loader').addClass('visible');
			}
		})
			.done(function(data) {
				if('ok' == data) {
					result = true;
				}
			})
			.fail(function() {
				//$('#content').html('<h2>Unexpected error</h2>');
			})
			.always(function() {
				$('#loader').removeClass('visible');
			});

		return result;
	};
	
	var doExecSqlScript = function(sqlScript, step, stepCount) {
		var result = false;

		var formData = new FormData();

		formData.append('setup_db_type', getFieldValue('#setup_db_type'));
		formData.append('setup_db_name', getFieldValue('#setup_db_name'));
		formData.append('setup_db_user', getFieldValue('#setup_db_user'));
		formData.append('setup_db_password', getFieldValue('#setup_db_password'));
		formData.append('setup_db_host', getFieldValue('#setup_db_host'));
		formData.append('setup_db_port', getFieldValue('#setup_db_port'));

		formData.append('script_exec', sqlScript);
		
		$.ajax({
			type: "POST",
			url: '/installdb.php?action=execsql',
			async: false,
			data: formData,
			processData: false, contentType: false,
			beforeSend: function() {
				$('#loader p').text('Installing database... (Step '+step+'/'+stepCount+')');
				$('#loader').addClass('visible');
			}
		})
			.done(function(data) {
				result = true;
				
			})
			.fail(function() {
				//$('#content').html('<h2>Unexpected error</h2>');
			})
			.always(function() {
				$('#loader').removeClass('visible');
			});

		return result;
	};


	var doInstall = function() {
		var formData = new FormData();

		formData.append('setup_db_version', getFieldValue('#setup_db_version'));
		formData.append('setup_db_script', getFieldValue('#setup_db_script'));
		formData.append('setup_db_type', getFieldValue('#setup_db_type'));
		formData.append('setup_db_name', getFieldValue('#setup_db_name'));
		formData.append('setup_db_user', getFieldValue('#setup_db_user'));
		formData.append('setup_db_password', getFieldValue('#setup_db_password'));
		formData.append('setup_db_host', getFieldValue('#setup_db_host'));
		formData.append('setup_db_port', getFieldValue('#setup_db_port'));

		$.ajax({
			type: "POST",
			url: '/installdb.php?action=install',
			data: formData,
			dataType: 'json',
			processData: false, contentType: false,
			beforeSend: function() {
				$('#loader p').text('Installing files... (Step 1/1)');
				$('#loader').addClass('visible');
				$('#connection_status .connection_error').text('');
				$('#connection_status .connection_error').removeClass('red');
				$('#connection_status .connection_error').removeClass('green');
			}
		})
			.done(function(data) {
				var resultStepDrop = false;
				var resultStepScripts = false;
				
				resultStepDrop = doExecSqlDrop();

				if(data.length > 0) {
					$.each(data, function( index, value ) {
						if(doExecSqlScript(value, (index+1), data.length)) {
							resultStepScripts = true;
						} else {
							resultStepScripts = false;
							return false;
						}
					});
				} else {
					resultStepScripts = true;
				}
				

				if(doFinish() && resultStepDrop && resultStepScripts) {
					$('#content').html('<h2>Installation successful</h2><p>The installation process was successful.</p><p><a href="'+getFieldValue('#setup_url')+'" class="button">Open System</a></p>');
				} else {
					$('#content').html('<h2>Installation error</h2><p>The installation process was not successful.</p><p><a href="#" onclick="window.location.reload(true);">Try again</a></p>');
				}
				
				//$('#order_content').html(data);
				//initOrder();
			})
			.fail(function() {
				$('#content').html('<h2>Unexpected error</h2>');
			})
			.always(function() {
				$('#loader').removeClass('visible');
			});
		
	};
		
	
	$('#button_test_db').click(function(event) {
		event.preventDefault();
		if(checkDbFields() > 0) {
			
		} else {
			doCheckDatabaseConnection(false, null);
		}
	});

	$('#button_start_installation').click(function(event) {
		event.preventDefault();
		if(checkAllFields() > 0) {

		} else {
			
			if(confirm("Do you really want to install a new System Database installation?")) {
				doCheckDatabaseConnection(true);
			}
			
		}
	})

	
	var dbScripts = <?= json_encode($dbScripts); ?>;
	$('#setup_db_version').change(function() {
		$('#setup_db_script').empty();
		for(dbScript in dbScripts[$(this).val()]) {
			$('#setup_db_script').append($('<option/>', { value: dbScripts[$(this).val()][dbScript], text: dbScripts[$(this).val()][dbScript], selected:  ((dbScript == Object.keys(dbScripts[$(this).val()])[Object.keys(dbScripts[$(this).val()]).length-1])? 'selected' : '')}));
		}
	});
});

</script>
</head>
<body>
<div id="headContainer">
<header id="header">
<h1>System Setup</h1>
</header>
</div>

<div id="container">
<section id="content">
<div id="loader"><div></div><p></p></div>

<?php 
$existingData = findExistingInstallation(); 
$existing = $existingData['existing'];
$configData = null;
if($existing) {
	$configData = $existingData['configData'];
}

?>

<h2>System Setup</h2>

<p>Welcome to the System Database installation tool.</p>

<form>
<hr />
<h3>Database Configuration</h3>
<p></p>

<dl>

<dt><label for="setup_db_version">Database Version:</label></dt>
<dd>
<div class="formwrapper">
<select name="setup_db_version" id="setup_db_version">
	<?php foreach($dbScriptFolders as $dbScriptFolder) : ?>
    <option value="<?= $dbScriptFolder; ?>"<?php if($existing && $configData['version'] == $dbScriptFolder) : ?> selected="selected"<?php endif; ?>><?= $dbScriptFolder; ?></option>
    <?php endforeach; ?>
</select>
</div>
</dd>

<dt><label for="setup_db_script">Database Script:</label></dt>
<dd>
<div class="formwrapper">
<select name="setup_db_script" id="setup_db_script">
	<?php foreach($dbScripts[$configData['version']] as $dbScript) : ?>
    <option value="<?= $dbScript; ?>"<?php if($dbScript === end($dbScripts[$configData['version']])) : ?> selected="selected"<?php endif; ?>><?= $dbScript; ?></option>
    <?php endforeach; ?>
</select>
</div>
</dd>

<dt><label for="setup_db_type">Database Type:</label></dt>
<dd>
<div class="formwrapper">
<select name="setup_db_type" id="setup_db_type">
    <option value="mysql"<?php if($existing && $configData['db.type'] == 'mysql') : ?> selected="selected"<?php endif; ?>>MySQL</option>
</select>
</div>
</dd>

<dt><label for="setup_db_name">Database Name:</label></dt>
<dd>
<div class="formwrapper">
<input type="text" name="setup_db_name" id="setup_db_name" value="<?php if($existing) : ?><?= $configData['db.name']; ?><?php else : ?>system<?php endif; ?>" />
</div>
</dd>

<dt><label for="setup_db_user">Database Username:</label></dt>
<dd>
<div class="formwrapper">
<input type="text" name="setup_db_user" id="setup_db_user" value="<?php if($existing) : ?><?= $configData['db.user']; ?><?php else : ?>system<?php endif; ?>" />
</div>
</dd>

<dt><label for="setup_db_password">Database Password:</label></dt>
<dd>
<div class="formwrapper">
<input type="password" name="setup_db_password" id="setup_db_password" value="<?php if($existing) : ?><?= $configData['db.password']; ?><?php else : ?>system<?php endif; ?>" />
</div>
</dd>

<dt><label for="setup_db_host">Database Host:</label></dt>
<dd>
<div class="formwrapper">
<input type="text" name="setup_db_host" id="setup_db_host" value="<?php if($existing) : ?><?= $configData['db.host']; ?><?php else : ?>localhost<?php endif; ?>" />
</div>
</dd>

<dt><label for="setup_db_port">Database Port:</label></dt>
<dd>
<div class="formwrapper">
<input type="text" name="setup_db_port" id="setup_db_port" value="<?php if($existing) : ?><?= $configData['db.port']; ?><?php else : ?>3306<?php endif; ?>" />
</div>
</dd>


</dl>

<p></p>
<p style="float: left; width: 300px;" id="connection_status"><span class="connection_status">Status:</span> <span class="connection_error"></span></p>
<p style="margin-left: 320px; text-align: right;"><a href="#" class="button" id="button_test_db">Test Database Connection</a></p>

<hr />
<p style="text-align: right;"><a href="#" class="button" id="button_start_installation">Start Installation</a></p>
<p></p>

</form>

</section>
</div>

</body>
</html>

<?php elseif($action == 'testdb') : ?><?php 
if(checkDatabaseConnection()) {
	echo 'ok';
} else {
	echo 'error';
}
?><?php elseif($action == 'install') : ?><?php 

	require_once INSTALL_SCRIPT_PATH . '/../library/Zend/Json/Encoder.php';

	$dbInstallFiles = scandir(INSTALL_SCRIPT_PATH . '/../db/install/');
	usort($dbInstallFiles, 'compareVersions');
	
	$sizeInstallFiles = count($dbInstallFiles);
	
	$installFile = $dbInstallFiles[($sizeInstallFiles-1)];
	if($installFile == '..' || $installFile == '.') {
		throw new Exception('Could not find database installation files.');
	}
	
	$installFileVersion = str_replace('.sql', '', $installFile);

	$RELEASE_VERSION = $_POST['setup_db_version'];
	$RELEASE_VERSION_SCRIPT = $_POST['setup_db_script'];
	
	$dbScriptFolders = array();
	$dbScriptFilesTmp = scandir(INSTALL_SCRIPT_PATH . '/../db/scripts/');
	foreach($dbScriptFilesTmp as $scriptFileTmp) {
		if($scriptFileTmp != '.' && $scriptFileTmp != '..' && $scriptFileTmp != 'archive') {
			if(compareVersions($scriptFileTmp, $RELEASE_VERSION) < 1 && compareVersions($scriptFileTmp, $installFileVersion) > 0) {
				$dbScriptFolders[] = $scriptFileTmp;
			}
		}
	}
	
	
	usort($dbScriptFolders, 'compareVersions');
	
	$dbScriptToExecute = array();
	$dbScriptToExecute[] = INSTALL_SCRIPT_PATH . '/../db/install/'.$installFile;
	
	foreach($dbScriptFolders as $dbScriptFolder) {
		$tmpFiles = scandir(INSTALL_SCRIPT_PATH . '/../db/scripts/'.$dbScriptFolder.'/');
		sort($tmpFiles);
		
		foreach($tmpFiles as $tmpFile) {
			if($tmpFile != '..' && $tmpFile != '.') {
				$dbScriptToExecute[] = INSTALL_SCRIPT_PATH . '/../db/scripts/'.$dbScriptFolder.'/'.$tmpFile;
			}
			
			if($dbScriptFolder === end($dbScriptFolders) && $RELEASE_VERSION_SCRIPT == $tmpFile) break;
		}
	}
	
	echo  Zend_Json_Encoder::encode($dbScriptToExecute);
// 		echo 'DB:<pre>';
// 		print_r($dbScriptToExecute);
// 		echo '</pre>';
?><?php elseif($action == 'execsqldrop') : ?><?php 
	execSqlScript("SET group_concat_max_len = 10000; SET FOREIGN_KEY_CHECKS = 0; SET @tables = NULL; SELECT GROUP_CONCAT('`', table_schema, '`.`', table_name, '`') INTO @tables FROM information_schema.tables WHERE table_schema = '".$_POST['setup_db_name']."'; SET @tables = CONCAT('DROP TABLE ', @tables); PREPARE stmt FROM @tables; EXECUTE stmt; DEALLOCATE PREPARE stmt; SET FOREIGN_KEY_CHECKS = 1;");
?><?php elseif($action == 'execsql') : ?><?php 
	if(checkPostParam('script_exec')) {
		$sql = file_get_contents($_POST['script_exec']);
		execSqlScript($sql);
	} else {
		throw new Exception('Not script given.');
	}
?><?php elseif($action == 'finish') : ?><?php 
	//unlink(__FILE__);
	echo 'ok';
?><?php endif; ?><?php 


