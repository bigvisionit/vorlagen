/*** ui elements class ***/
export default class UIElements {
  /*** create elements ***/
  // creates an element
  static createElement(type, attributes = {}, text, html) {
    const element = document.createElement(type);
    if(text) {
      element.appendChild(document.createTextNode(text));
    }
    if(html) {
      element.innerHTML = html;
    }
    for(let attr in attributes) {
      element.setAttribute(attr, attributes[attr]);
    }
    return element;
  }

  // creates an a element
  static createA(text, attributes = {}) {
    const element = document.createElement('a');
    element.href = 'javascript:void(0);';
    element.appendChild(document.createTextNode(text));
    for(let attr in attributes) {
      element.setAttribute(attr, attributes[attr]);
    }
    return element;
  }

  /*** remove elements ***/
  // remove an element
  static remove(element) {
    element.remove();
    return element;
  }

  // remove an element by query
  static removeByQuery(query, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    element.remove();
    return element;
  }

  // remove an element by id
  static removeByID(id) {
    const element = document.getElementById(id);
    element.remove();
    return element;
  }

  /*** get elements ***/
  // get an element
  static getElement(query, element) {
    if(element) {
      return element.querySelector(query);
    } else {
      return document.querySelector(query);
    }
  }

  // get an element by id
  static getElementByID(id) {
    return document.getElementById(id);
  }

  // get elements as NodeList or Array
  static getElements(query, element, asArray) {
    if(element) {
      return asArray? Array.from(element.querySelectorAll(query)) : element.querySelectorAll(query);
    } else {
      return asArray? Array.from(document.querySelectorAll(query)) : document.querySelectorAll(query);
    }
  }

  // get elements by class name as HTMLCollection or Array
  static getElementsByClassName(className, element, asArray) {
    if(element) {
      return asArray? Array.from(element.getElementsByClassName(classNamename)) : element.getElementsByClassName(className);
    } else {
      return asArray? Array.from(document.getElementsByClassName(className)) : document.getElementsByClassName(className);
    }
  }

  /*** show elements ***/
  // show an element
  static show(element, display = 'block', visibility) {
    if(visibility) {
      element.style.visibility = 'visible'; 
    } else {
      element.style.display = display;
    }
    return element;
  }

  // show an element by query
  static showByQuery(query, element, display = 'block', visibility) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    if(visibility) {
      element.style.visibility = 'visible'; 
    } else {
      element.style.display = display;
    }
    return element;
  }

  // show an element by id
  static showByID(id, display = 'block', visibility) {
    const element = document.getElementById(id);
    if(visibility) {
      element.style.visibility = 'visible'; 
    } else {
      element.style.display = display;
    }
    return element;
  }

  /*** hide elements ***/
  // hide an element
  static hide(element, visibility) {
    if(visibility) {
      element.style.visibility = 'hidden'; 
    } else {
      element.style.display = 'none';
    }
    return element;
  }

  // hide an element by query
  static hideByQuery(query, element, visibility) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    if(visibility) {
      element.style.visibility = 'hidden'; 
    } else {
      element.style.display = 'none';
    }
    return element;
  }

  // hide an element by id
  static hideByID(id, visibility) {
    const element = document.getElementById(id);
    if(visibility) {
      element.style.visibility = 'hidden'; 
    } else {
      element.style.display = 'none';
    }
    return element;
  }

  /*** toggle elements ***/
  // toggle an element
  static toggle(element, display = 'block', visibility) {
    if(window.getComputedStyle(element).display === display) {
      if(visibility) {
        element.style.visibility = 'hidden'; 
      } else {
        element.style.display = 'none';
      }
    } else {
      if(visibility) {
        element.style.visibility = 'visible'; 
      } else {
        element.style.display = display;
      }
    }
    return element;
  }

  // toggle an element by query
  static toggleByQuery(query, element, display = 'block', visibility) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    if(window.getComputedStyle(element).display === display) {
      if(visibility) {
        element.style.visibility = 'hidden'; 
      } else {
        element.style.display = 'none';
      }
    } else {
      if(visibility) {
        element.style.visibility = 'visible'; 
      } else {
        element.style.display = display;
      }
    }
    return element;
  }

  // toggle an element by id
  static toggleByID(id, display = 'block', visibility) {
    const element = document.getElementById(id);
    if(window.getComputedStyle(element).display === display) {
      if(visibility) {
        element.style.visibility = 'hidden'; 
      } else {
        element.style.display = 'none';
      }
    } else {
      if(visibility) {
        element.style.visibility = 'visible'; 
      } else {
        element.style.display = display;
      }
    }
    return element;
  }

  /*** replace elements ***/
  // replace an element
  static replace(element, newElement) {
    element.parentNode.replaceChild(newElement, element);
    return newElement;
  }

  // replace an element by query
  static replaceByQuery(query, newElement, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    element.parentNode.replaceChild(newElement, element);
    return newElement;
  }

  // replace an element by id
  static replaceByID(id, newElement) {
    const element = document.getElementById(id);
    element.parentNode.replaceChild(newElement, element);
    return newElement;
  }

  /*** add class to elements ***/
  // set an element's class
  static addClass(element, className) {
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(!element.classList.contains(className)) {
        element.classList.add(className);
      }
    });
    return element;
  }

  // set an element's class by query
  static addClassByQuery(query, className, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(!element.classList.contains(className)) {
        element.classList.add(className);
      }
    });
    return element;
  }

  // set an element's class by id
  static addClassByID(id, className) {
    const element = document.getElementById(id);
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(!element.classList.contains(className)) {
        element.classList.add(className);
      }
    });
    return element;
  }

  /*** remove class from elements ***/
  // remove an element's class
  static removeClass(element, className) {
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    return element;
  }

  // remove an element's class by query
  static removeClassByQuery(query, className, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    return element;
  }

  // remove an element's class by id
  static removeClassByID(id, className) {
    const element = document.getElementById(id);
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    return element;
  }

  /*** toggle class in elements ***/
  // toggle an element's class
  static toggleClass(element, className) {
    const classNames = className.split(' ');
    classNames.forEach(className => {
      element.classList.toggle(className);
    });
    return element;
  }

  // toggle an element's class by query
  static toggleClassByQuery(query, className, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    const classNames = className.split(' ');
    classNames.forEach(className => {
      element.classList.toggle(className);
    });
    return element;
  }

  // toggle an element's class by id
  static toggleClassByID(id, className) {
    const element = document.getElementById(id);
    const classNames = className.split(' ');
    classNames.forEach(className => {
      element.classList.toggle(className);
    });
    return element;
  }

  /*** replace classes in elements ***/
  // replace an element's class
  static replaceClass(element, className, newClassName) {
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    const newClassNames = newClassName.split(' ');
    newClassNames.forEach(newClassName => {
      if(!element.classList.contains(newClassName)) {
        element.classList.add(newClassName);
      }
    });
    return element;
  }

  // replace an element's class by query
  static replaceClassByQuery(query, className, newClassName, element) {
    if(element) {
      element = element.querySelector(query);
    } else {
      element = document.querySelector(query);
    }
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    const newClassNames = newClassName.split(' ');
    newClassNames.forEach(newClassName => {
      if(!element.classList.contains(newClassName)) {
        element.classList.add(newClassName);
      }
    });
    return element;
  }

  // replace an element's class by id
  static replaceClassByID(id, className, newClassName) {
    const element = document.getElementById(id);
    const classNames = className.split(' ');
    classNames.forEach(className => {
      if(element.classList.contains(className)) {
        element.classList.remove(className);
      }
    });
    const newClassNames = newClassName.split(' ');
    newClassNames.forEach(newClassName => {
      if(!element.classList.contains(newClassName)) {
        element.classList.add(newClassName);
      }
    });
    return element;
  }
}