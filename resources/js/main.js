/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/index.js":
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utilities */ \"./resources/js/utilities.js\");\n\r\n\r\n(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('body', 'click', () => {\r\n  const searchSelectDropdowns = document.querySelectorAll('.search-select-dropdown');\r\n  (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.sidebar', 'show', 'remove');\r\n  (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.notification-dropdown', 'show', 'remove');\r\n\r\n  if ((0,_utilities__WEBPACK_IMPORTED_MODULE_0__.isExist)('.search-select-dropdown')) {\r\n    searchSelectDropdowns.forEach(searchSelectDropdown => {\r\n      if (!searchSelectDropdown.classList.contains('hidden')) {\r\n        searchSelectDropdown.classList.add('hidden');\r\n      }\r\n    })\r\n  }\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.show-password-btn', 'click', ({ currentTarget }) => {\r\n  const types = { password: 'password', text: 'text' };\r\n\r\n  const parent = currentTarget.parentNode;\r\n  const input = parent.querySelector(\"input\");\r\n  const icon = currentTarget.querySelector('i');\r\n\r\n  if (input.type === types.password) {\r\n    icon.className = 'ri-eye-off-fill';\r\n    input.type = types.text;\r\n  } else {\r\n    icon.className = 'ri-eye-fill';\r\n    input.type = types.password;\r\n  }\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.code-input', 'input', ({ target }) => {\r\n  const nextInput = target.nextElementSibling;\r\n  if (nextInput && target.value.length > 0) {\r\n    nextInput.focus();\r\n  }\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.code-input', 'keydown', ({ key, target }) => {\r\n  const prevInput = target.previousElementSibling;\r\n  if (key === 'Backspace' && prevInput) {\r\n    target.value = \"\";\r\n    prevInput.focus();\r\n  }\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.show-sidebar', 'click', (e) => {\r\n  e.stopPropagation();\r\n  (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.sidebar', 'show');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.sidebar', 'click', (e) => {\r\n  e.stopPropagation();\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.notifications', 'click', (e) => {\r\n  e.stopPropagation();\r\n  (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.notification-dropdown', 'show');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.notification-dropdown', 'click', (e) => {\r\n  e.stopPropagation();\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.search-select-container', 'click', (e) => {\r\n  e.stopPropagation();\r\n  const searchSelectDropdown = e.currentTarget.querySelector('.search-select-dropdown');\r\n  searchSelectDropdown.classList.remove('hidden');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.clear-search-btn', 'click', (e) => {\r\n  e.stopPropagation();\r\n  const parentNode = e.currentTarget.parentNode;\r\n  const idInput = parentNode.querySelector('.pet-input');\r\n  const searchSelect = parentNode.querySelector('.search-select');\r\n  searchSelect.value = \"\";\r\n  idInput.value = \"\";\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.search-select-option', 'click', (e) => {\r\n  e.stopPropagation();\r\n  const { id, value } = e.currentTarget.dataset;\r\n  const parentNode = e.currentTarget.parentNode.parentNode;\r\n  const idInput = parentNode.querySelector('.pet-input');\r\n  const searchSelect = parentNode.querySelector('.search-select');\r\n  const searchSelectDropdown = parentNode.querySelector('.search-select-dropdown');\r\n  idInput.value = id;\r\n  searchSelect.value = value;\r\n  searchSelectDropdown.classList.add('hidden');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.accept-btn', 'click', () => {\r\n  ;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('#accept-dialog', 'show');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.decline-btn', 'click', () => {\r\n  ;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('#decline-dialog', 'show');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.close-dialog', 'click', () => {\r\n  ;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.dialog', 'show', 'remove');\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.custom-file-input', 'click', () => {\r\n  const fileInput = document.querySelector('.file-input');\r\n  fileInput.click();\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.file-input', 'change', (e) => {\r\n  const { name } = e.target.files[0];\r\n  const fileDatas = name.split('.');\r\n  const selectedTxt = document.querySelector('.selected-file');\r\n  const filename = name.length < 45 ? name : `${name.substring(0, fileDatas[0])}...${fileDatas[1]}`;\r\n  selectedTxt.textContent = filename;\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.chat-message', 'click', () => {\r\n  if (innerWidth < 992) {\r\n    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.chat-box', 'show')\r\n  }\r\n})\r\n\r\n;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.addEventListener)('.close-chat-box', 'click', () => {\r\n  ;(0,_utilities__WEBPACK_IMPORTED_MODULE_0__.dynamicStyle)('.chat-box', 'show', 'remove')\r\n})\n\n//# sourceURL=webpack://polangui_veterinary_clicnic/./resources/js/index.js?");

/***/ }),

/***/ "./resources/js/utilities.js":
/*!***********************************!*\
  !*** ./resources/js/utilities.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   addEventListener: () => (/* binding */ addEventListener),\n/* harmony export */   dynamicStyle: () => (/* binding */ dynamicStyle),\n/* harmony export */   isExist: () => (/* binding */ isExist),\n/* harmony export */   iterate: () => (/* binding */ iterate)\n/* harmony export */ });\nfunction isExist (selector) {\r\n  const elements = document.querySelectorAll(selector);\r\n  return elements.length > 0 ? true : false;\r\n}\r\n\r\nfunction addEventListener (selector, type = 'click', callback) {\r\n  if (!isExist(selector)) return\r\n\r\n  if (typeof selector === 'string') {\r\n    iterate(selector, (element) => {\r\n      element.addEventListener(type, callback);\r\n    })\r\n  } else {\r\n    selector.addEventListener(type, callback);\r\n  }\r\n}\r\n\r\nfunction dynamicStyle (selector, style = 'active', type = 'add') {\r\n  if (!isExist(selector))  return\r\n\r\n  const actions = {\r\n    ADD: 'add',\r\n    REMOVE: 'remove',\r\n    TOGGLE: 'toggle'\r\n  }\r\n\r\n  if (typeof selector === 'string') {\r\n    iterate(selector, (element) => {\r\n      if (type === actions.ADD) {\r\n        element.classList.add(style)\r\n      } else if (type === actions.TOGGLE) {\r\n        element.classList.toggle(style);\r\n      } else {\r\n        element.classList.remove(style)\r\n      }\r\n    });\r\n  } else {\r\n    if (type === actions.ADD) {\r\n      selector.classList.add(style)\r\n    } else if (type === actions.TOGGLE) {\r\n      selector.classList.toggle(style);\r\n    } else {\r\n      selector.classList.remove(style)\r\n    }\r\n  }\r\n}\r\n\r\nfunction iterate (selector, callback) {\r\n  if (!isExist(selector)) return\r\n\r\n  const elements = document.querySelectorAll(selector);\r\n  elements.forEach((element, index) => callback(element, index));\r\n}\n\n//# sourceURL=webpack://polangui_veterinary_clicnic/./resources/js/utilities.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/index.js");
/******/ 	
/******/ })()
;