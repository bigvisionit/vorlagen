/*
	JS Simple Modern Http Helper Class with usefull functions
	author: David Kempf
*/

/*** http class ***/
export default class ModernHttp {
  // GET Request (JSON)
  async get(url) {
    const response = await fetch(url);
    const resData = await response.json();
    return resData;
  }

  // GET Request (TEXT)
  async getContent(url) {
    const response = await fetch(url);
    const resData = await response.text();
    return resData;
  }

  // POST Request (JSON)
  async post(url, data) {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-type': 'application/json'
      },
      body: JSON.stringify(data)
    });
    const resData = await response.json();
    return resData;
  }

  // POST Request (TEXT)
  async postContent(url, data) {
    const response = await fetch(url, {
      method: 'POST',
      body: data
    });
    const resData = await response.text();
    return resData;
  }

  // PUT Request (REST-API | JSON)
  async put(url, data) {
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'Content-type': 'application/json'
      },
      body: JSON.stringify(data)
    });
    const resData = await response.json();
    return resData;
  }

  // DELETE Request (REST-API | JSON)
  async delete(url) {
    const response = await fetch(url, {
      method: 'DELETE',
      headers: {
        'Content-type': 'application/json'
      }
    });
    const resData = await true;
    return resData;
  }
}