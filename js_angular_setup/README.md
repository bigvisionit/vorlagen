Mac / Windows:


1. Node.js installieren

   1.1 Herunterladen (.pkg Datei, recommended LTS):

   https://nodejs.org/en/

   1.2. Testen - Terminal: "npm -v", "node -v"

   1.3. Node Version Manager installieren - Terminal (optional):

		"sudo npm install n -g"
   
   1.4. Node Version Installieren - Terminal (optional):

		"sudo n [version]"
  
1.5. Version auswählem - Terminal (optional):
	
	 "n"
   
2. Git (https://git-scm.com) (Windows) oder Xcode installieren (Mac):

   2.1 App Store, Suchen nach Xcode, Installieren und Starten
   
   2.2 Testen - Terminal: "git --version"
	
3. Im Verzeichnis package.json generieren und Module installieren - Terminal:

   3.1 "npm init" (optional "npm install" von package.json)
   
   3.2 Modul um 2 Node-Kommandos gleichzeitig auszuführen:
	   
	  "npm install concurrently --save-dev"
	  
   3.3 Lite - Server für Preview:
   
	   "npm install lite-server --save-dev"

   3.4 TypeScript:
   
	   "npm install typescript --save-dev"
   
   3.5 Typings (TypeScript-Definitionen):
   
	   "npm install typings --save-dev"
	   
   3.6 Core-JS für ES6/ES7/Polyfill Support:
   
	   "npm install core-js --save"
	   
   3.7 RxJS für Ereignisse und asynchrone Prozesse:
	
	   "npm install rxjs --save"
   
   3.8 Zone.js Domains wie bei Node.js:
	
	   "npm install zone.js --save"
	   
   3.9 Reflext-metadata um Metadaten in Klasse hinzuzufügen:
   
	   "npm install reflect-metadata --save"
	   
   3.10 SystemJs für ES6 Module Support:
	
	   "npm install systemjs --save"
	   
   3.11 Angular installieren:
   
	   "npm install @angular/core --save"
	   
	   "npm install @angular/common --save"
	   
	   "npm install @angular/compiler --save"
	   
	   "npm install @angular/platform-browser --save"
	   
	   "npm install @angular/platform-browser-dynamic --save"
	   
	   "npm install @angular/http --save"
	   
	   "npm install @angular/router --save"
	   
4. TypeScript Compiler einrichten:
	
	4.1 in "package.json" "tsc": "tsc" hinzufügen
		"scripts": {
			..
			"tsc": "tsc"
		}
	
	4.2 "tsconfig.json" erzeugen - Terminal:
	
		"npm run tsc -- -init"
		
	4.3 In "tsconfig.json" einstellen:
	
		"module": "commonjs",
		"target": "es5",
		"noImplicitAny": false,
		"sourceMap": true,
		"moduleResolution": "node",
		"experimentalDecorators": true,
		"emitDecoratorMetadata": true,
		"removeComments": false,
		
		einfügen:
		"files": [
			"node_modules/typescript/lib/lib.es6.d.ts"
		]
		
5. Typ-Definitionen installieren:

	5.1 in "package.json" "typings": "typings" hinzufügen
		"scripts": {
			..
			"typings": "typings"
		}
		
	5.2 "typings.json" erzeugen - Terminal:
	
		"npm run typings -- init"
		
	5.3	Typ-Definitionen für Node und Core-JS installieren - Terminal:
	
		"npm run typings -- install dt~node --save --global"
		
		"npm run typings -- install dt~core-js --save --global"
		
6.  Typings-Installation als Postscript an "npm install" anhängen:

	in "package.json" "postinstall": "typings install" hinzufügen
	"scripts": {
		..
		"postinstall": "typings install"
	}
	
7. SystemJs konfigurieren:

   system.config.js mit dem Inhalt erstellen:
   
	(function (global) {
		System.config({
			paths: {
				'npm:': 'node_modules/'
			},
			map: {
				app: 'app',
				'@angular/core': 'npm:@angular/core/bundles/core.umd.js',
				'@angular/common': 'npm:@angular/common/bundles/common.umd.js',
				'@angular/compiler': 'npm:@angular/compiler/bundles/compiler.umd.js',
				'@angular/platform-browser': 'npm:@angular/platform-browser/bundles/platform-browser.umd.js',
				'@angular/platform-browser-dynamic': 'npm:@angular/platform-browser-dynamic/bundles/platform-browser-dynamic.umd.js',
				'@angular/http': 'npm:@angular/http/bundles/http.umd.js',
				'@angular/router': 'npm:@angular/router/bundles/router.umd.js',
				'@angular/forms': 'npm:@angular/forms/bundles/forms.umd.js',
				'rxjs': 'npm:rxjs'
			},
			packages: {
				app: {
					main: './main.js',
					defaultExtension: 'js'
				},
				rxjs: {
					defaultExtension: 'js'
				}
			}
		});
	})(this);
	
8. index.html erstellen:

   index.html mit dem Inhalt erstellen:

	<!DOCTYPE html>
	<html lang="en">
	<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	  <title>Angular Setup</title>
	  
	  <!--polyfills-->
	  <script src="node_modules/core-js/client/shim.min.js"></script>
	  
	  <!--vendor-->
	  <script src="node_modules/zone.js/dist/zone.js"></script>
	  <script src="node_modules/reflect-metadata/Reflect.js"></script>
	  <script src="node_modules/systemjs/dist/system.src.js"></script>
	  
	  <script>
			System.import('system.config.js').then(function() {
				System.import('app');
			}).catch(function(err) {
				console.error(err);
			});
	  </script>
	  
	</head>
	<body>
	  
	</body>
	</html>
	
9. Start-Prozess definieren:

	in "package.json"
	"tsc:w": "tsc -w",
	"lite": "lite-server",
	"start": "tsc && concurrently \"npm run tsc:w\" \"npm run lite\""

	hinzufügen
	"scripts": {
		..
		"lite": "lite-server"
	}