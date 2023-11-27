import { isExist, addEventListener, dynamicStyle } from "./utilities";

addEventListener('body', 'click', () => {
  const searchSelectDropdowns = document.querySelectorAll('.search-select-dropdown');
  dynamicStyle('.sidebar', 'show', 'remove');
  dynamicStyle('.notification-dropdown', 'show', 'remove');

  if (isExist('.search-select-dropdown')) {
    searchSelectDropdowns.forEach(searchSelectDropdown => {
      if (!searchSelectDropdown.classList.contains('hidden')) {
        searchSelectDropdown.classList.add('hidden');
      }
    })
  }
})

addEventListener('.show-password-btn', 'click', ({ currentTarget }) => {
  const types = { password: 'password', text: 'text' };

  const parent = currentTarget.parentNode;
  const input = parent.querySelector("input");
  const icon = currentTarget.querySelector('i');

  if (input.type === types.password) {
    icon.className = 'ri-eye-off-fill';
    input.type = types.text;
  } else {
    icon.className = 'ri-eye-fill';
    input.type = types.password;
  }
})

addEventListener('.code-input', 'input', ({ target }) => {
  const nextInput = target.nextElementSibling;
  if (nextInput && target.value.length > 0) {
    nextInput.focus();
  }
})

addEventListener('.code-input', 'keydown', ({ key, target }) => {
  const prevInput = target.previousElementSibling;
  if (key === 'Backspace' && prevInput) {
    target.value = "";
    prevInput.focus();
  }
})

addEventListener('.show-sidebar', 'click', (e) => {
  e.stopPropagation();
  dynamicStyle('.sidebar', 'show');
})

addEventListener('.sidebar', 'click', (e) => {
  e.stopPropagation();
})

addEventListener('.notifications', 'click', (e) => {
  e.stopPropagation();
  dynamicStyle('.notification-dropdown', 'show');
})

addEventListener('.notification-dropdown', 'click', (e) => {
  e.stopPropagation();
})

addEventListener('.search-select-container', 'click', (e) => {
  e.stopPropagation();
  const searchSelectDropdown = e.currentTarget.querySelector('.search-select-dropdown');
  searchSelectDropdown.classList.remove('hidden');
})

addEventListener('.clear-search-btn', 'click', (e) => {
  e.stopPropagation();
  const parentNode = e.currentTarget.parentNode;
  const idInput = parentNode.querySelector('.pet-input');
  const searchSelect = parentNode.querySelector('.search-select');
  searchSelect.value = "";
  idInput.value = "";
})

addEventListener('.search-select-option', 'click', (e) => {
  e.stopPropagation();
  const { id, value } = e.currentTarget.dataset;
  const parentNode = e.currentTarget.parentNode.parentNode;
  const idInput = parentNode.querySelector('.pet-input');
  const searchSelect = parentNode.querySelector('.search-select');
  const searchSelectDropdown = parentNode.querySelector('.search-select-dropdown');
  idInput.value = id;
  searchSelect.value = value;
  searchSelectDropdown.classList.add('hidden');
})

addEventListener('.accept-btn', 'click', () => {
  dynamicStyle('#accept-dialog', 'show');
})

addEventListener('.decline-btn', 'click', () => {
  dynamicStyle('#decline-dialog', 'show');
})

addEventListener('.close-dialog', 'click', () => {
  dynamicStyle('.dialog', 'show', 'remove');
})

addEventListener('.custom-file-input', 'click', () => {
  const fileInput = document.querySelector('.file-input');
  fileInput.click();
})

addEventListener('.file-input', 'change', (e) => {
  const { name } = e.target.files[0];
  const fileDatas = name.split('.');
  const selectedTxt = document.querySelector('.selected-file');
  const filename = name.length < 45 ? name : `${name.substring(0, fileDatas[0])}...${fileDatas[1]}`;
  selectedTxt.textContent = filename;
})
addEventListener('.close-chat-box', 'click', () => {
  dynamicStyle('.chat-box', 'show', 'remove')
})