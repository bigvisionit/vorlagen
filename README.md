Updates


ES6 / ES7 Updates


1.  let - Variablen:

for(let i = 0; i < 10; i++) {

    let x = i // x und i sind nur innerhalb der for - Schleife gültig

}

Var - Variablen x und i wären auch nach der Schleife noch vorhanden, was nicht gewollt ist!


2.  Konstanten:


const element = document.querySelector('#elementId');

const template = `HTML`;


Alle HTML-Elemente, Objekte, Arrays oder feste Werte sollte als eine Konstante definiert werden, da sie sowieso im Laufe des Codes nicht geändert werden sollten!

Objekte und Arrays können auch danach geändert werden, dürfen jedoch nich komplett neu erstellt werden, was auch Sinn macht.


3.  Arrow-Functions:


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


4.  Standard-Parameter:


function func(i, j = 1) {

    return i + j

}


5.  Rest-Parameter:


function func(i, j, ...name) {

    return i + j + name.length;

}

Aufruf:

func(1, 2, 3, 4) // Ausgabe 5

Restliche Parameter können direkt in einer Funktion über einen festgelegten Namen als Array aufgerufen werden.


6.  Spread-Operator:


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


7.  String - Literale (Templating):


let x = 1;

let message = `Der Wert ${x},

wird hier ausgegeben. ${x} + 1 ergibt ${x+1}`

Großer HTML-Inhalt kann mit Hilfe des '`' - Zeichens auch über mehrere Zeilen geschrieben werden.

${} führen Vriablen oder JavaScript Code direkt nach der Zuweisung aus.


8.  Objekt - Kurzschreibweise:


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


9.  Objekt - dynamische Eigenschaften:


let obj = {

    i: 1,

    [ 'i' + 123 ]: 2

}

// Ausgabe: { i: 1, i123: 2 }

Objekt-Eigenschaften können über [] dynamisch benannt werden.


10.  Variable aus Array-Zuweisung;


let arr = [ 1, 2, 3 ]

let [ x, , y ] = arr // Ausgabe Variable x = 1, y = 3


Die Variblen mit dem Namen x und y werden mit den Werten aus dem Array erzeugt.


Variablen-Tausch:

[ x, y ] = [ y, x ]

Die einfachste Möglichkeit um Variablen zu vertauschen.


11.  Variable aus Objekt-Zuweisung:


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


12.  Variable aus Objekt- und Array-Zuweisung mit Standard-Parametern:


Objekt-Zuweisung:


const obj = { x: 1 }

const arr = [ 1 ]

let { x, y = 2 } = obj // Ausgabe Variable x = 1, y = 2

Die Variablen mit dem Namen x und y werden mit den Werten aus dem Objekt erzeugt. y wird standardmäßig mit dem Wert 2 belegt, wenn das Objekt keine Eigenschaft mit demselben Namen besitzt.


Array-Zuweisung:

let [ x, y = 2, z ] = arr // Ausgabe Variable x = 1, y = 2, z = undefined

Die Variablen mit dem Namen x und y werden mit den Werten aus dem Array erzeugt. y wird standardmäßig mit dem Wert 2 belegt, wenn das Array keinen Wert mit demselben Index besitzt.


13.  Objekt- und Array Zuweisung als Parameter einer Funktion:


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


14.  Klassen:


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


15.  Sets:


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


16.  Maps:


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


17.  Neuere Methoden:

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


18.  Promises - Asynchroner Aufruf von Methoden bei Rückgabe:


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


19.  Proxys - Dynamischer Aufruf und entsprechende Rückgabe in Objekt-Schreibweise:

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


20.  Reflection - Dynamischer Aufruf und entsprechende Rückgabe in Objekt-Schreibweise (ähnlich der Proxys):


let obj = { a: 1 }

Object.defineProperty(obj, 'b', { value: 2 })

obj['c'] = 3

console.log(Reflect.ownKeys(obj)) // Ausgabe [ 'a', 'b', 'c' ]







PHP 7 / 7.1 / 7.2 Updates


1. Sortieren von Arrays:


Der <=> Operator erspart einem eine komplette Überprüfung oder Vergleiche auf <, =, und >..


$arr = array(1,3,2);

usort($arr, function($a, $b) {

    return $a <=> $b;

});

//$arr => 1, 2, 3



2. Holen der Request-Werte (POST, GET etc.):


$userId = $_POST['ID_User'] ?? $_GET['ID_User'] ?? 'System kennt den User nicht!';

 
Hierbei werden auch keine Fehler beim direkten Zugriff aus $_POST geschmissen.


3. Anonyme Klassen:


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


4. Typdeklarationen


function ausgabe(string $wert): string {

    echo $wert;

}

seit PHP 7.1 auch '?datentyp' : Wert kann auch null sein

seit PHP 7.1 auch 'void' : Keine Rückgabe

seit PHP 7.2 auch 'object' möglich


5. Fehlerbehandlung


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

6. Zufallsfunktion


echo random_int(1, 100);


7. Parameter bei session_start direkt möglich (unterschiedliches Session-Handling möglich)


session_start([

    'cookie_lifetime' => 86400

]);


8. Definition von Array Konstanten


define('SETTINGS', [

    'setting1' => '1',

    'setting2' => '2'

]);


echo SETTINGS['setting1'];

9. Zugriffe auf Daten


$data = [

    'c' => 1,

    'd' => 2

];

['c' => $a, 'd' => $b] = $data;

echo $a;

echo $b;


10. Zugriff auf beliebige String-Positionen


$string[-1] // => das letzte Zeichen usw.

strpos($string, 'a', -2) // => zähle von hinten ab Position 2 usw.

 