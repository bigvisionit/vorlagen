# Small Modern Http Class (JS)

This is a small (2 KB uncompressed) modern http class written in ES7 JavaScript.

It uses async and await and can be used in ajax / rest requests.

It is recommended using Webpack with Babel to generate ES5 JavaScript for older browsers.

Functions overview:

- get function from url, returns json

- get content function from url, returns text

- post data function to url, returns json

- post content data function to url, returns text

- put data function to url, returns json

- delete data function to url, returns json


### Version
1.0.0

### Example usage

// simple get request

const http = new ModernHttp();

http.get('users').then(data => console.log(data)).catch(err => console.log(err));


// simple post request

const username = 'max';
http.post('users/add', { username }).then(data => console.log(data)).catch(err => console.log(err));