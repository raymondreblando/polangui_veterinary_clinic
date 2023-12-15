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

export function setSpeciesBreed(species) {
  const speciesOthers = document.querySelector('.breed-others');
  const breedSelect = document.querySelector('.breed-select');
  breedSelect.innerHTML = '';
  const defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.text = 'Select Breed';
  breedSelect.appendChild(defaultOption);

  const breeds = {
    cat: ['Abyssinian Cat', 'Bengal Cat', 'Burmese', 'Persian Cat', 'Pusakal', 'Siamese Cat'],
    dog: ['American Bully', 'French Bulldog', 'Golden Retriever', 'Siberian Husky', 'Poodle', 'Chihuahua', 'Chow Chow', 'Pomerauian', 'Shih Tzu']
  };

  if (breeds.hasOwnProperty(species.toLowerCase())) {
    const speciesBreeds = breeds[species.toLowerCase()];
    speciesBreeds.forEach(breed => {
      const option = document.createElement('option');
      option.value = breed;
      option.text = breed;
      breedSelect.appendChild(option);
    })

    const otherOption = document.createElement('option');
    otherOption.value = 'Others';
    otherOption.text = 'Others';
    breedSelect.appendChild(otherOption);

    breedSelect.addEventListener('change', (e) => {
      speciesOthers.value = e.target.value;
    })
  } else {
    speciesOthers.value = '';
    breedSelect.innerHTML = '';
    const otherOption = document.createElement('option');
    otherOption.value = 'Others';
    otherOption.text = 'Others';
    breedSelect.appendChild(otherOption);
    dynamicStyle('.breed-select', 'hidden');
    dynamicStyle('.breed-others', 'hidden', 'remove');
  }
}