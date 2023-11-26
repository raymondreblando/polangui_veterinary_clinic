export function isExist (selector) {
  const elements = document.querySelectorAll(selector);
  return elements.length > 0 ? true : false;
}

export function addEventListener (selector, type = 'click', callback) {
  if (!isExist(selector)) return

  if (typeof selector === 'string') {
    iterate(selector, (element) => {
      element.addEventListener(type, callback);
    })
  } else {
    selector.addEventListener(type, callback);
  }
}

export function dynamicStyle (selector, style = 'active', type = 'add') {
  if (!isExist(selector))  return

  const actions = {
    ADD: 'add',
    REMOVE: 'remove',
    TOGGLE: 'toggle'
  }

  if (typeof selector === 'string') {
    iterate(selector, (element) => {
      if (type === actions.ADD) {
        element.classList.add(style)
      } else if (type === actions.TOGGLE) {
        element.classList.toggle(style);
      } else {
        element.classList.remove(style)
      }
    });
  } else {
    if (type === actions.ADD) {
      selector.classList.add(style)
    } else if (type === actions.TOGGLE) {
      selector.classList.toggle(style);
    } else {
      selector.classList.remove(style)
    }
  }
}

export function iterate (selector, callback) {
  if (!isExist(selector)) return

  const elements = document.querySelectorAll(selector);
  elements.forEach((element, index) => callback(element, index));
}