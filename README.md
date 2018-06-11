New Features PHP 7.0, 7.1, 7.2 and ES 6 / 7

(scroll down to read the german version )

ES6 / ES7 Updates


- Let variables:

for(let i = 0; i < 10; i++) {

    let x = i // x and i are only valid within the for loop

}

Var - variables x and i would still be present after the loop, which is not wanted!


- Constants:


const element = document.querySelector('#elementId');

const template = `HTML`;


All HTML elements, objects, arrays or fixed values should be defined as a constant, because they should not be changed during the code anyway!

Objects and arrays can also be changed afterwards, but may not be created from scratch, which makes sense.


- Arrow functions:


Simple function:

function func(i, j) {

    return i + j;

}

Can also be written like this:

(i, j) => i + j

Call: ((i, j) => i + j)(1, 1) // = 2

As callback:

const arr =[1, 2, 3];

arr.forEach(i => {

   if(i < 3)
   
       console.log(i); // result 1, 2

});


- Default parameters:


function func(i, j = 1) {

    return i + j

}


- Remaining parameters:


function func(i, j, ...name) {

    return i + j + name.length;

}

Call:

func(1, 2, 3, 4) // result 5

Remaining parameters can be called directly in a function using a specified name as an array.


- Spread operator:


let arr1 = [ 1, 2, 3 ]

let arr2 = [ 1, 2,...arr1 ] // result [ 1, 2, 1, 2, 3 ]

Arrays can be easily combined.

As a parameter:

function func(i, j, ...name) {

    return i + j + name.length

}


Call:

func(1, 2, ...arr1) // result 6

Here the values of the array [ 1, 2, 3 ] are passed directly to the remaining parameter of the function.

As a string:

let str = "foo"

let chars = [...str ]  // [ "f", "o", "o" ]

The easiest way to convert strings into single chars.


- String - Literals (Templating):


let x = 1;

let message = `The value ${x},

is displayed here. ${x} + 1 equals ${x+1}`

Large HTML content can also be written over several lines using the ``' character.

${} execute Vriablen or JavaScript code directly after assignment.


- Object - Short notation:


let i = 1, j = 2

obj = { i, j } // Output { i: 1, j: 2}

 
Short notation to pass variables with names to an object.


As a function:


obj = {

    func1(i, j) {

        …

    },

    func2(i, j) {

        …

    }

}

Output: { func1: function(i, j) {}, func2: function(i, j) {} }

Short notation to pass functions with names to an object.


- Object - dynamic properties:


let obj = {

    i: 1,

    [ 'i' + 123 ]: 2

}

Output: { i: 1, i123: 2 }

Object properties can be named dynamically using [].


- Variable from array assignment:


let arr = [ 1, 2, 3 ]

let [ x, , y ] = arr // Output Variable x = 1, y = 3


The variables named x and y are generated with the values from the array.


- Variable swap:

[x, y] =[y, x]

The easiest way to swap variables.


- Variable from object assignment:


function getSpecObj() {

    return { name1: 1, name2: 2, name3: 3 }

}

let { name1, name2, name3 } = getSpecObj() // Output variable name1 = 1, name2 = 2, name3 = 3

The variables with the names name1, name2 and name3 are created with the values from the object.


- Depth assignment:

function getSpecObj() {

    return { name1: 1, name2: 2, name3: { name4: 4 } }

}

let { name1: i, name2: j, name3: { name4: x } } = getSpecObj() // Output Variable i = name1 = 1, j = name2 = 2, x = name4 = 4


The variables with the names i, j and x are created with the values from the object by assigning the object names.


Variable from object and array assignment with standard parameters:


- Object assignment:


const obj = { x: 1 }

const arr = [ 1 ]

let { x, y = 2 } = obj // Output variable x = 1, y = 2

The variables with the names x and y are generated with the values from the object. y is assigned the value 2 by default if the object has no property with the same name.


- Array assignment:

let [ x, y = 2, z] = arr // Output Variable x = 1, y = 2, z = undefined

The variables with the names x and y are generated with the values from the array. y is assigned the value 2 by default if the array has no value with the same index.


Object and array assignment as parameters of a function:


- Parameter as an array:

function func1([ param1, param2 ]) {

    Output Variable param1 = 1 param2 = 2

}

func1([ 1, 2 ]);

The values are passed in the order in the array of variables param1 and param2


- Parameter as an object:


function func2({ param1: p1, param2: p2 }) {

    Output variable p1 = 1, p2 = 2

}


func2({ param1: 1, param2: 2 }))

 
After the assignment, the values are transferred in the object of the variables p1 = param1 = 1 and p2 = param2 = 2


- Abbreviated form:

function func3({ param1, param2 }) {

    Output Variable param1 param2

}

func3({ param1: 1, param2: 2 });

After the assignment, the values are transferred in the object of the variables param1 = 1 and param2 = 2.


- Classes:


class className {

    constructor(i, j) {

        this._i = i

        this.j = j

        this.increment()

    }

    set i(i) { this._i = i }

    get i() { return this._i }

    increment() {

        this._i++;

        this._j++;

    }

    static func() {

        //do something..

    }

}

class className2 extends className {

    constructor(i, j) {

        super(i, j)

    }

}

Call:

const myObj = new className(1, 1); // Output myObj.i = 1

Classes can be created using the word "class". constructor is created using the word "constructor".

Inheritance is specified by the word "extends" and the call of the superclass by the word "super".

Static methods are defined using the keyword "static".

Getter and Setter are set using the words "get" and "set".


- Sets:


const s = new Set()

s.add(1).add(2) // Add values

Sets can contain any values and are always stored sorted

Output of the set size:

console.log(s.size)

Check for the presence of a value:

console.log(s.has(2)) // Output true

Remove value from the set:

s.delete(2);

Scroll through a set in the order of insertion:

for(let key of s.values()) {

    console.log(key) // result 1, 2

}


- Maps:


let m = new Map()

m.set("test", 1) // Assign the value 1 to the "test" key

Maps can contain any values and are set via a key

Output of a value via the key:

console.log(m.get('test')); // Output 1

Output of map size:

console.log(m.size) // result 1

Remove the value from the map using the key:

m.delete("test");

Scrolling through a map:

for(let[key, val] of m.entries()) {

    console.log(key + " " = " + val)

}


- Newer methods:

- Merge objects:

var obj1 = { prop1: 1 }

var obj2 = { prop2: 2, prop3: 3 }

var obj3 = { prop3: 4, prop5: 5 }

Object.assign(obj1, obj2, obj3) // Output { prop1: 1, prop2: 2, prop3: 4, prop5: 5 }

Objects can be merged using Object.assign()


- Array search:

[ 1, 3, 4, 2 ].find(x => x > 3) // result 4

[ 1, 3, 4, 2 ].findIndex(x => x > 3) // result 2


- String repetition:

"test".repeat(3) // Output "testtesttest"


- String search:

"hello".includes("ell") // Output "true"

"hello".includes("ell", 1) // Parameter 2 = Index, Output "true"

 
- String startsWith and endsWith:

 
"hello".startsWith("ello", 1) // Parameter 2 = Index, Output true

"hello".endsWith("hello", 4) // Parameter 2 = Index, Output "true"

 

- NaN and finite test:


Number.isNaN(NaN) // Output "true".

Number.isFinite(NaN) // Output "false


- Check for secure integers within the validity range:


Number.isSafeInteger(1) // Output true

Number.isSafeInteger(9007199254740992) // Output "false


- Truncate the decimal places:

Math.trunc(99.9)) // 99


- Promises - Asynchronous call of methods on return:


function msgAfterTimeout(message, name, timeout) {

    return new Promise((resolve, reject) => {

        setTimeout(() => resolve(`${message} Hello ${name}!`), timeout)

    })

}

msgAfterTimeout("", "Hans", 100).then((message) =>

		msgAfterTimeout(message, "sausage", 200)

	).then((message) => {

		console.log(`done after 300ms:${message}`)

	}

)


- Combine several promises:

function fetchAsync(url, timeout, onData, onError) {

    …

}

let fetchPromised = (url, timeout) => {

    return new Promise((resolve, reject) => {

        fetchAsync(url, timeout, resolve, reject)

    })

}

Promise.all([

    fetchPromised("url1", 500),

    fetchPromised("url2", 500),

    fetchPromised("url3", 500)

]).then((data) => {

    let [ data1, data2, data3  = data

    console.log(`success: data1=${data1} data2=${data2} data3=${data3}`)

}, (err) => {

   console.log(`error: ${err}`)

})


- Proxies - Dynamic call and corresponding return in object notation:

let target = {

    test: "Welcome, test"

}

let proxy = new Proxy(target, {

    get(receiver, name) {

        return name in receiver ? receiver[name] `Not known: ${name}`

    }

})

proxy.test // Output "Welcome, test"

proxy.maxmustermann // result "Not known: maxmustermann"


- Reflection - Dynamic call and corresponding return in object notation (similar to proxies):


let obj = { a: 1 }

Object.defineProperty(obj, 'b', { value: 2 }))

obj['c'] = 3

console.log(Reflect.ownKeys(obj)) // Output [ 'a', 'b', 'c' ]



<hr />



PHP 7 / 7.1 / 7.2 Updates


- Sorting of arrays:


The <=> operator saves you a complete check or comparison for <, =, and >...


$arr = array(1,3,2);

usort($arr, function($a, $b) {

    return $a <=> $b;

});

aar => 1, 2, 3



- Get request values (POST, GET, etc.):


$userId = $_POST['ID_User']? $_GET['ID_User']? System does not know the user!';

No errors are thrown during direct access from $_POST.


- Anonymous classes:


class User {

	public $name;

	public function hello() {

				   echo 'Hello ' . $this->name;

	}

}

$maxMustermann = new class('Max Mustermann') extends User {

	public function __construct($name) {

				   $this->name = $name;

	}

};

echo $maxMustermann->hello();


- Type declarations:


function output(string $value): string {

    echo $value;

}

since PHP 7.1 also '?data type': value can also be zero

since PHP 7.1 also'void': No return value

since PHP 7.2 also 'object' possible


- Error handling:


try {

    Calling an unknown function

    unknownfunction();

catch(Exception $e) {

    not executed in PHP 5.6!

    not executed in PHP 7 because of type'Error

} catch(Error $e) {

    executed in PHP 7

    does not exist in PHP 5.6.

} finally {

    not executed in PHP 5.6!

    executed in PHP 7

}

alternative:

//..

catch(Exception | Error $e) { // catches exception and error

    //..

}

//..

//..or...

//..

catch(Throwable) { // catches exception and error and all throwables

    //..

}

//..

- Random function:


echo random_int(1, 100);


- Parameters at session_start 

(different session handling possible)


session_start([

    cookie_lifetime' => 86400

]);


- Definition of array constants:


define('SETTINGS', [

    'setting1' => '1',

    setting2' => '2'

]);


echo SETTINGS['setting1'];

- Access to data:


$data = [

    'c' => 1,

    'd' => 2

];

['c' => $a, 'd' => $b] = $data;

echo $a;

echo $b;


- Access to any string positions:


$string[-1] // => the last character etc.

strpos($string, 'a', -2) // => count from the back from position 2 etc.




<hr />



Deutsche Version:

(German Version)


New Features PHP 7.0, 7.1, 7.2 and ES 6/7

(German)

ES6 / ES7 Updates


- let - Variablen:

for(let i = 0; i < 10; i++) {

    let x = i // x und i sind nur innerhalb der for - Schleife gültig

}

Var - Variablen x und i wären auch nach der Schleife noch vorhanden, was nicht gewollt ist!


- Konstanten:


const element = document.querySelector('#elementId');

const template = `HTML`;


Alle HTML-Elemente, Objekte, Arrays oder feste Werte sollte als eine Konstante definiert werden, da sie sowieso im Laufe des Codes nicht geändert werden sollten!

Objekte und Arrays können auch danach geändert werden, dürfen jedoch nich komplett neu erstellt werden, was auch Sinn macht.


- Arrow-Functions:


Eine Funktion:

function func(i, j) {

    return i + j;

}

Kann auch so geschrieben werden:

(i, j) => i + j

Aufruf: ((i, j) => i + j)(1, 1) // = 2

Als Callback:

const arr = [1, 2, 3];

arr.forEach(i => {

   if(i < 3)
   
       console.log(i); // Ausgabe 1, 2

});


- Standard-Parameter:


function func(i, j = 1) {

    return i + j

}


-  Rest-Parameter:


function func(i, j, ...name) {

    return i + j + name.length;

}

Aufruf:

func(1, 2, 3, 4) // Ausgabe 5

Restliche Parameter können direkt in einer Funktion über einen festgelegten Namen als Array aufgerufen werden.


- Spread-Operator:


let arr1 = [ 1, 2, 3 ]

let arr2 = [ 1, 2, ...arr1 ] // Ausgabe [ 1, 2, 1, 2, 3 ]

Arrays können so einfach zusammengefasst werden.

Als Parameter:

function func(i, j, ...name) {

    return i + j + name.length

}


Aufruf:

func(1, 2, ...arr1) // Ausgabe 6

Hier werden die Werte des Array [ 1, 2, 3 ] direkt an den Rest-Parameter der Funktion übergeben.

Als String:

let str = "foo"

let chars = [ ...str ] // [ "f", "o", "o" ]

Die einfachste Möglichkeit um Strings in einzelne in Chars umzuwandeln.


- String - Literale (Templating):


let x = 1;

let message = `Der Wert ${x},

wird hier ausgegeben. ${x} + 1 ergibt ${x+1}`

Großer HTML-Inhalt kann mit Hilfe des '`' - Zeichens auch über mehrere Zeilen geschrieben werden.

${} führen Vriablen oder JavaScript Code direkt nach der Zuweisung aus.


- Objekt - Kurzschreibweise:


let i = 1, j = 2

obj = { i, j } // Ausgabe { i: 1, j: 2}

 
Kurzschreibweise um Variablen mit Namen an einen Objekt übergeben zu können.


Als Funktion:


obj = {

    func1(i, j) {

        …

    },

    func2(i, j) {

        …

    }

}

// Ausgabe: { func1: function(i, j) {}, func2: function(i, j) {} }

Kurzschreibweise um Funktionen mit Namen an einen Objekt übergeben zu können.


- Objekt - dynamische Eigenschaften:


let obj = {

    i: 1,

    [ 'i' + 123 ]: 2

}

// Ausgabe: { i: 1, i123: 2 }

Objekt-Eigenschaften können über [] dynamisch benannt werden.


- Variable aus Array-Zuweisung;


let arr = [ 1, 2, 3 ]

let [ x, , y ] = arr // Ausgabe Variable x = 1, y = 3


Die Variblen mit dem Namen x und y werden mit den Werten aus dem Array erzeugt.


Variablen-Tausch:

[ x, y ] = [ y, x ]

Die einfachste Möglichkeit um Variablen zu vertauschen.


- Variable aus Objekt-Zuweisung:


function getSpecObj() {

    return { name1: 1, name2: 2, name3: 3 }

}

let { name1, name2, name3 } = getSpecObj() // Ausgabe Variable name1 = 1, name2 = 2, name3 = 3

Die Variablen mit dem Namen name1, name2 und name3 werden mit den Werten aus dem Objekt erzeugt.


Tiefen-Zuweisung:

function getSpecObj() {

    return { name1: 1, name2: 2, name3: { name4: 4 } }

}

let { name1: i, name2: j, name3: { name4: x } } = getSpecObj() // Ausgabe Variable i = name1 = 1, j = name2 = 2, x = name4 = 4


Die Variablen mit dem Namen i, j und x werden mit den Werten aus dem Objekt durch Zuweisung der Objekt-Namen erzeugt.


- Variable aus Objekt- und Array-Zuweisung mit Standard-Parametern:


Objekt-Zuweisung:


const obj = { x: 1 }

const arr = [ 1 ]

let { x, y = 2 } = obj // Ausgabe Variable x = 1, y = 2

Die Variablen mit dem Namen x und y werden mit den Werten aus dem Objekt erzeugt. y wird standardmäßig mit dem Wert 2 belegt, wenn das Objekt keine Eigenschaft mit demselben Namen besitzt.


Array-Zuweisung:

let [ x, y = 2, z ] = arr // Ausgabe Variable x = 1, y = 2, z = undefined

Die Variablen mit dem Namen x und y werden mit den Werten aus dem Array erzeugt. y wird standardmäßig mit dem Wert 2 belegt, wenn das Array keinen Wert mit demselben Index besitzt.


- Objekt- und Array Zuweisung als Parameter einer Funktion:


Parameter als Array:

function func1([ param1, param2 ]) {

    //Ausgabe Variable param1 = 1 param2 = 2

}

func1([ 1, 2 ]);

Es werden die Werte nach der Reihenfolge im Array der Variable param1 und param2 übergeben


Parameter als Objekt:


function func2({ param1: p1, param2: p2 }) {

    //Ausgabe Variable p1 = 1, p2 = 2

}


func2({ param1: 1, param2: 2 })

 
Es werden die Werte nach der Zuweisung im Objekt der Variable p1 = param1 = 1 und p2 = param2 = 2 übergeben


Kurzschreibweise:

function func3({ param1, param2 }) {

    //Ausgabe Variable param1 param2

}

func3({ param1: 1, param2: 2 });

Es werden die Werte nach der Zuweisung im Objekt der Variable param1 = 1 und param2 = 2 übergeben


- Klassen:


class className {

    constructor(i, j) {

        this._i = i

        this._j = j

        this.increment()

    }

    set i(i) { this._i = i }

    get i() { return this._i }

    increment() {

        this._i++;

        this._j++;

    }

    static func() {

        //do something..

    }

}

class className2 extends className {

    constructor(i, j) {

        super(i, j)

    }

}

Aufruf:

const myObj = new className(1, 1); // Ausgabe myObj.i = 1

Klassen können über das Wort "class" erstellt werden. Konstruktor wird über das Wort "constructor" erstellt.

Vererbung wird über das Wort "extends" angegeben und der Aufruf der Oberklasse über das Wort "super".

Statische Methoden werden über das Schlüsselwort "static" definiert.

Getter und Setter werden über die Wörter "get" und "set" gesetzt.


- Sets:


const s = new Set()

s.add(1).add(2) // Werte hinzufügen

Sets können beliebige Werte enthalten und werden immer sortiert abgespeichert

Ausgabe der Set-Größe:

console.log(s.size)

Prüfung auf Vorhandensein eines Wertes:

console.log(s.has(2)) // Ausgabe "true"

Wert aus dem Set entfernen:

s.delete(2);

Durchlaufen eins Sets nach der Reihenfolge des Einfügens:

for(let key of s.values()) {

    console.log(key) // Ausgabe 1, 2

}


- Maps:


let m = new Map()

m.set("test", 1) // Schlüssel "test" den Wert 1 zuweisen

Maps können beliebige Werte enthalten und werden über ein Key gesetzt

Ausgabe eines Wertes über den Key:

console.log(m.get('test')); // Ausgabe 1

Ausgabe der Map-Größe:

console.log(m.size) // Ausgabe 1

Wert über den Schlüssel aus der Map entfernen:

m.delete("test");

Durchlaufen einer Map:

for(let[key, val] of m.entries()) {

    console.log(key + " = " + val)

}


- Neuere Methoden:

Objekte zusammenfügen:

var obj1 = { prop1: 1 }

var obj2 = { prop2: 2, prop3: 3 }

var obj3 = { prop3: 4, prop5: 5 }

Object.assign(obj1, obj2, obj3) // Ausgabe { prop1: 1, prop2: 2, prop3: 4, prop5: 5 }

Objekte können über Object.assign() gemerged werden


Array-Suche:

[ 1, 3, 4, 2 ].find(x => x > 3) // Ausgabe 4

[ 1, 3, 4, 2 ].findIndex(x => x > 3) // Ausgabe 2


String-Wiederholung:

"test".repeat(3) // Ausgabe "testtesttest"


String-Suche:

"hello".includes("ell")       // Ausgabe "true"

"hello".includes("ell", 1)    // Parameter 2 = Index, Ausgabe "true"

 
String startsWith und endsWith:

 
"hello".startsWith("ello", 1) // Parameter 2 = Index, Ausgabe "true"

"hello".endsWith("hell", 4)   // Parameter 2 = Index, Ausgabe "true"

 

NaN und Finite Prüfung:


Number.isNaN(NaN) // Ausgabe "true"

Number.isFinite(NaN) // Ausgabe "false"


Prüfung auf sichere Integers innerhalb des Gültigkeitbereichs:


Number.isSafeInteger(1) // Ausgabe "true"

Number.isSafeInteger(9007199254740992) // Ausgabe "false"


Abschneiden der Nachkommastellen:

Math.trunc(99.9)) // 99


- Promises - Asynchroner Aufruf von Methoden bei Rückgabe:


function msgAfterTimeout(nachricht, name, timeout) {

    return new Promise((resolve, reject) => {

        setTimeout(() => resolve(`${nachricht} Hallo ${name}!`), timeout)

    })

}

msgAfterTimeout("", "Hans", 100).then((nachricht) =>

		msgAfterTimeout(nachricht, "Wurst", 200)

	).then((nachricht) => {

		console.log(`done after 300ms:${nachricht}`)

	}

)


Mehrere Promises kombinieren:

function fetchAsync(url, timeout, onData, onError) {

    …

}

let fetchPromised = (url, timeout) => {

    return new Promise((resolve, reject) => {

        fetchAsync(url, timeout, resolve, reject)

    })

}

Promise.all([

    fetchPromised("url1", 500),

    fetchPromised("url2", 500),

    fetchPromised("url3", 500)

]).then((data) => {

    let [ data1, data2, data3 ] = data

    console.log(`success: data1=${data1} data2=${data2} data3=${data3}`)

}, (err) => {

   console.log(`error: ${err}`)

})


- Proxys - Dynamischer Aufruf und entsprechende Rückgabe in Objekt-Schreibweise:

let target = {

    test: "Willkommen, test"

}

let proxy = new Proxy(target, {

    get(receiver, name) {

        return name in receiver ? receiver[name] : `Nicht bekannt: ${name}`

    }

})

proxy.test // Ausgabe "Willkommen, test"

proxy.maxmustermann // Ausgabe "Nicht bekannt: maxmustermann"


- Reflection - Dynamischer Aufruf und entsprechende Rückgabe in Objekt-Schreibweise (ähnlich der Proxys):


let obj = { a: 1 }

Object.defineProperty(obj, 'b', { value: 2 })

obj['c'] = 3

console.log(Reflect.ownKeys(obj)) // Ausgabe [ 'a', 'b', 'c' ]







PHP 7 / 7.1 / 7.2 Updates


- Sortieren von Arrays:


Der <=> Operator erspart einem eine komplette Überprüfung oder Vergleiche auf <, =, und >..


$arr = array(1,3,2);

usort($arr, function($a, $b) {

    return $a <=> $b;

});

//$arr => 1, 2, 3



- Holen der Request-Werte (POST, GET etc.):


$userId = $_POST['ID_User'] ?? $_GET['ID_User'] ?? 'System kennt den User nicht!';

 
Hierbei werden auch keine Fehler beim direkten Zugriff aus $_POST geschmissen.


- Anonyme Klassen:


class User {

	public $name;

	public function hallo() {

	echo 'Hallo ' . $this->name;

	}

}

$maxMustermann = new class('Max Mustermann') extends User {

	public function __construct($name) {

	$this->name = $name;

	}

};

echo $maxMustermann->hallo();


- Typdeklarationen


function ausgabe(string $wert): string {

    echo $wert;

}

seit PHP 7.1 auch '?datentyp' : Wert kann auch null sein

seit PHP 7.1 auch 'void' : Keine Rückgabe

seit PHP 7.2 auch 'object' möglich


- Fehlerbehandlung


try {

    //Aufruf einer unbekannten Funktion

    unbekannteFunktion();

} catch(Exception $e) {

    //in PHP 5.6 nicht ausgeführt!

    //in PHP 7 nicht ausgeführt weil Typ 'Error'

} catch(Error $e) {

    //in PHP 7 ausgeführt

    //gibt es in PHP 5.6 gar nicht..

} finally {

    //in PHP 5.6 nicht ausgeführt!

    //in PHP 7 ausgeführt

}

alternativ:

//..

} catch(Exception | Error $e) { // fängt Exception und Error ab

    //..

}

//..

//..oder..

//..

} catch(Throwable) { // fängt Exception und Error und alle Throwables ab

    //..

}

//..

- Zufallsfunktion


echo random_int(1, 100);


- Parameter bei session_start direkt möglich (unterschiedliches Session-Handling möglich)


session_start([

    'cookie_lifetime' => 86400

]);


- Definition von Array Konstanten


define('SETTINGS', [

    'setting1' => '1',

    'setting2' => '2'

]);


echo SETTINGS['setting1'];

- Zugriffe auf Daten


$data = [

    'c' => 1,

    'd' => 2

];

['c' => $a, 'd' => $b] = $data;

echo $a;

echo $b;


- Zugriff auf beliebige String-Positionen


$string[-1] // => das letzte Zeichen usw.

strpos($string, 'a', -2) // => zähle von hinten ab Position 2 usw.
