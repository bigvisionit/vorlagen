New Features PHP 7.0, 7.1, 7.2 and ES 6/7


ES6 / ES7 Updates


let variables:

for(let i = 0; i < 10; i++) {

    let x = i // x and i are only valid within the for loop

}

Var - variables x and i would still be present after the loop, which is not wanted!


constants:


const element = document.querySelector('#elementId');

const template = `HTML`;


All HTML elements, objects, arrays or fixed values should be defined as a constant, because they should not be changed during the code anyway!

Objects and arrays can also be changed afterwards, but may not be created from scratch, which makes sense.


Arrow functions:


One function:

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
   
       console.log(i); // Issue 1, 2

});


Default parameters:


function func(i, j = 1) {

    return i + j

}


Remaining parameters:


function func(i, j, ...name) {

    return i + j + name.length;

}

Call:

func(1, 2, 3, 4) // Issue 5

Remaining parameters can be called directly in a function using a specified name as an array.


Spread operator:


let arr1 = [ 1, 2, 3 ]

let arr2 = [ 1, 2,...arr1 ] // Edition [ 1, 2, 1, 2, 3 ]

Arrays can thus be easily combined.

As a parameter:

function func(i, j, ...name) {

    return i + j + name.length

}


Call:

func(1, 2, ...arr1) // Issue 6

Here the values of the array [ 1, 2, 3 ] are passed directly to the remaining parameter of the function.

As a string:

let str = "foo"

let chars = [...str  // [ "f", "o", "o" ]

The easiest way to convert strings into single chars.


String - Literals (Templating):


let x = 1;

let message = `The value ${x},

is displayed here. ${x} + 1 equals ${x+1}`

Large HTML content can also be written over several lines using the ``' character.

${} execute Vriablen or JavaScript code directly after assignment.


Object - Short notation:


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

output: { func1: function(i, j) {}, func2: function(i, j) {} }

Short notation to pass functions with names to an object.


Object - dynamic properties:


let obj = {

    i: 1,

    [ 'i' + 123 ]: 2

}

Output: { i: 1, i123: 2 }

Object properties can be named dynamically using [].


Variable from array assignment;


let arr = [ 1, 2, 3 ]

let [ x x, ] = arr // Output Variable x = 1, y = 3


The variables named x and y are generated with the values from the array.


Variable swap:

][x, y =[y, x]

The easiest way to swap variables.


Variable from object assignment:


function getSpecObj() {

    return { name1: 1, name2: 2, name3: 3 }

}

let { name1, name2, name3 } = getSpecObj() // Output variable name1 = 1, name2 = 2, name3 = 3

The variables with the names name1, name2 and name3 are created with the values from the object.


Depth assignment:

function getSpecObj() {

    return { name1: 1, name2: 2, name3: { name4: 4 } }

}

let { name1: i, name2: j, name3: { name4: x } } = getSpecObj() // Output Variable i = name1 = 1, j = name2 = 2, x = name4 = 4


The variables with the names i, j and x are created with the values from the object by assigning the object names.


Variable from object and array assignment with standard parameters:


Object assignment:


const obj = { x: 1 }

const arr = [ 1 ]

let { x, y = 2 } = obj // Output variable x = 1, y = 2

The variables with the names x and y are generated with the values from the object. y is assigned the value 2 by default if the object has no property with the same name.


Array assignment:

let [ x, y = 2, z  = arr // Output Variable x = 1, y = 2, z = undefined

The variables with the names x and y are generated with the values from the array. y is assigned the value 2 by default if the array has no value with the same index.


Object and array assignment as parameters of a function:


parameter as an array:

function func1([ param1, param2 ]) {

    Output Variable param1 = 1 param2 = 2

}

func1([ 1, 2 ]);

The values are passed in the order in the array of variables param1 and param2


parameter as an object:


function func2({ param1: p1, param2: p2 }) {

    Output variable p1 = 1, p2 = 2

}


func2({ param1: 1, param2: 2 }))

 
After the assignment, the values are transferred in the object of the variables p1 = param1 = 1 and p2 = param2 = 2


Abbreviated form:

function func3({ param1, param2 }) {

    Output Variable param1 param2

}

func3({ param1: 1, param2: 2 });

E flat 

Translated with www.DeepL.com/Translator