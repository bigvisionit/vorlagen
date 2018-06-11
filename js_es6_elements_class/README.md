# Small UI Elements Class (JS)

This is a small UI Elements class written in ES6 JavaScript.

It is recommended using Webpack with Babel to generate ES5 JavaScript for older browsers.

Functions overview:

- create element function

- create a function

- remove by query function

- remove by id function

- get element (by query) function

- get element by id function

- get elements (by query) function

- get elements by class name function

- show function

- show by query function

- show by id funciton

- hide (by element) function

- hide by query function

- hide by id function

- toggle (by element) functiion

- toggle by query functiion

- toggle by id function

- replace (by element) function

- replace by query function

- replace by id function

- add class function

- add class by query function

- add class by id function

- remove class (by element)

- remove class by query function

- remove class by id function

- toggle class (by element) function

- toggle class by query function

- toggle class by ID function

- replace class (by element) function

- replace class by query funciton

- replace class by id function


### Version
1.0.0

### Example usage

// get and toggle the input with id 'input'
const input = UIElements.getElement('#input');
UIElements.toggle(input);

UIElements.addClass(input, 'toggle_on');


// get all elements in a container by query
const container = UIElements.getElement('#container ul');
const arrayOfElements = getElements('li', container, true);







