(self["webpackChunkjob_searcher"] = self["webpackChunkjob_searcher"] || []).push([["sidebar"],{

/***/ "./assets/js/core/Ajax/AjaxContentLoad.ts":
/*!************************************************!*\
  !*** ./assets/js/core/Ajax/AjaxContentLoad.ts ***!
  \************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
/**
 * @description handles loading content via ajax
 */

var AjaxContentLoad =
/** @class */
function () {
  function AjaxContentLoad() {}
  /**
   * @description Will insert given content int o main wrapper
   *
   * @param content
   */


  AjaxContentLoad.loadContentIntoMainWrapper = function (content) {
    var mainWrapper = document.querySelector(AjaxContentLoad.MAIN_WRAPPER_SELECTOR);
    mainWrapper.innerHTML = content;
  };
  /**
   * @description Will append scripts into the `.main-container-wrapper` and execute them afterwards
   *
   * @param scriptSources
   */


  AjaxContentLoad.appendAndExecuteScriptsIntoMainWrapper = function (scriptSources) {
    var mainWrapper = document.querySelector(AjaxContentLoad.MAIN_WRAPPER_SELECTOR);

    for (var _i = 0, scriptSources_1 = scriptSources; _i < scriptSources_1.length; _i++) {
      var source = scriptSources_1[_i];
      var scriptToAppend = document.createElement('SCRIPT');
      scriptToAppend.setAttribute('src', source);
      mainWrapper.appendChild(scriptToAppend);
    }
  };

  AjaxContentLoad.MAIN_WRAPPER_SELECTOR = ".main-container-wrapper";
  return AjaxContentLoad;
}();

exports.default = AjaxContentLoad;

/***/ }),

/***/ "./assets/js/core/dto/AbstractDto.ts":
/*!*******************************************!*\
  !*** ./assets/js/core/dto/AbstractDto.ts ***!
  \*******************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
/**
 * @description Common methods / data used for children DTO classes
 */

var AbstractDto =
/** @class */
function () {
  function AbstractDto() {}
  /**
   * Returns found value for key in array, if non is found - returns defaultValue
   * @param array {array}
   * @param key {string}
   * @param defaultValue
   * @returns {null|string}
   */


  AbstractDto.prototype.getFromArray = function (array, key, defaultValue) {
    if (defaultValue === void 0) {
      defaultValue = null;
    }

    if ("undefined" === typeof array[key]) {
      return defaultValue;
    }

    return array[key];
  };
  /**
   * Checks if the value is non empty/null/undefined
   * @return {boolean}
   */


  AbstractDto.prototype.isset = function (value) {
    if ("undefined" === typeof value || "" === value || null === value || 0 === value.length) {
      return false;
    }

    return true;
  };

  return AbstractDto;
}();

exports.default = AbstractDto;

/***/ }),

/***/ "./assets/js/core/dto/AjaxResponseDto.ts":
/*!***********************************************!*\
  !*** ./assets/js/core/dto/AjaxResponseDto.ts ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! core-js/modules/es.object.set-prototype-of.js */ "./node_modules/core-js/modules/es.object.set-prototype-of.js");

__webpack_require__(/*! core-js/modules/es.object.create.js */ "./node_modules/core-js/modules/es.object.create.js");

__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

__webpack_require__(/*! core-js/modules/es.object.keys.js */ "./node_modules/core-js/modules/es.object.keys.js");

var __extends = this && this.__extends || function () {
  var _extendStatics = function extendStatics(d, b) {
    _extendStatics = Object.setPrototypeOf || {
      __proto__: []
    } instanceof Array && function (d, b) {
      d.__proto__ = b;
    } || function (d, b) {
      for (var p in b) {
        if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
      }
    };

    return _extendStatics(d, b);
  };

  return function (d, b) {
    if (typeof b !== "function" && b !== null) throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");

    _extendStatics(d, b);

    function __() {
      this.constructor = d;
    }

    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
  };
}();

var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var AbstractDto_1 = __importDefault(__webpack_require__(/*! ./AbstractDto */ "./assets/js/core/dto/AbstractDto.ts"));
/**
 * @description Main object used to convert standard array response from backend (upon ajax calls)
 *              might not contain all returned fields - should be expanded if needed / the same about backend
 *              ajaxResponse
 */


var AjaxResponseDto =
/** @class */
function (_super) {
  __extends(AjaxResponseDto, _super);

  function AjaxResponseDto() {
    var _this = _super !== null && _super.apply(this, arguments) || this;
    /**
     * @type int
     */


    _this.code = 200;
    /**
     * @type string
     */

    _this.message = "";
    /**
     * @type string
     */

    _this.template = "";
    /**
     * @type boolean
     */

    _this.success = false;
    /**
     * @type Array<string>
     */

    _this.scriptsSources = [];
    return _this;
  }
  /**
   * Builds DTO from data array
   * @returns {AjaxResponseDto}
   * @param object
   */


  AjaxResponseDto.fromAxiosResponse = function (object) {
    var ajaxResponseDto = new AjaxResponseDto();
    ajaxResponseDto.code = object.code;
    ajaxResponseDto.message = object.message;
    ajaxResponseDto.template = object.template;
    ajaxResponseDto.success = object.success;
    ajaxResponseDto.dataBag = object.dataBag;
    ajaxResponseDto.scriptsSources = object.scriptsSources;
    return ajaxResponseDto;
  };
  /**
   * @return {boolean}
   */


  AjaxResponseDto.prototype.isCodeSet = function () {
    return this.isset(this.code);
  };
  /**
   * @return {boolean}
   */


  AjaxResponseDto.prototype.isMessageSet = function () {
    return this.isset(this.message);
  };
  /**
   * @return {boolean}
   */


  AjaxResponseDto.prototype.isTemplateSet = function () {
    return this.isset(this.template);
  };
  /**
   * @return {boolean}
   */


  AjaxResponseDto.prototype.isSuccessSet = function () {
    return this.isset(this.success);
  };
  /**
   * @return {boolean}
   */


  AjaxResponseDto.prototype.isSuccessCode = function () {
    if (this.code >= 200 && this.code < 300) {
      return true;
    }

    return false;
  };
  /**
   * @returns {boolean}
   */


  AjaxResponseDto.prototype.isInternalServerErrorCode = function () {
    return this.code >= 500;
  };
  /**
   * @returns {boolean}
   */


  AjaxResponseDto.prototype.isDataBagSet = function () {
    return 0 !== Object.keys(this.dataBag).length;
  };
  /**
   * @returns {boolean}
   */


  AjaxResponseDto.prototype.areScriptsSet = function () {
    return 0 != this.scriptsSources.length;
  };

  return AjaxResponseDto;
}(AbstractDto_1["default"]);

exports.default = AjaxResponseDto;

/***/ }),

/***/ "./assets/vue/PreconfiguredVue.ts":
/*!****************************************!*\
  !*** ./assets/vue/PreconfiguredVue.ts ***!
  \****************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! core-js/modules/es.object.create.js */ "./node_modules/core-js/modules/es.object.create.js");

__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

var __createBinding = this && this.__createBinding || (Object.create ? function (o, m, k, k2) {
  if (k2 === undefined) k2 = k;
  Object.defineProperty(o, k2, {
    enumerable: true,
    get: function get() {
      return m[k];
    }
  });
} : function (o, m, k, k2) {
  if (k2 === undefined) k2 = k;
  o[k2] = m[k];
});

var __setModuleDefault = this && this.__setModuleDefault || (Object.create ? function (o, v) {
  Object.defineProperty(o, "default", {
    enumerable: true,
    value: v
  });
} : function (o, v) {
  o["default"] = v;
});

var __importStar = this && this.__importStar || function (mod) {
  if (mod && mod.__esModule) return mod;
  var result = {};
  if (mod != null) for (var k in mod) {
    if (k !== "default" && Object.prototype.hasOwnProperty.call(mod, k)) __createBinding(result, mod, k);
  }

  __setModuleDefault(result, mod);

  return result;
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var vue = __importStar(__webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js"));

var PreconfiguredVue =
/** @class */
function () {
  function PreconfiguredVue() {}
  /**
   * @description creates vue instance for dom element but uses preconfigured vue with common reusable logic,
   *              this provides the same output as creating SPA with vue in root such as body
   *
   * @param domElementSelector
   * @param options
   */


  PreconfiguredVue.createApp = function (domElementSelector, options) {
    //@ts-ignore
    options.delimiters = PreconfiguredVue.VUE_DEFAULT_DELIMITERS;
    vue.createApp(options).mount(domElementSelector);
  };
  /**
   * @description delimiters used to translate vue logic, required since twig utilizes the `{{ }}`
   */


  PreconfiguredVue.VUE_DEFAULT_DELIMITERS = ["[[", "]]"];
  return PreconfiguredVue;
}();

exports.default = PreconfiguredVue;

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts ***!
  \**************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var AjaxResponseDto_1 = __importDefault(__webpack_require__(/*! ../../js/core/dto/AjaxResponseDto */ "./assets/js/core/dto/AjaxResponseDto.ts"));

var AjaxContentLoad_1 = __importDefault(__webpack_require__(/*! ../../js/core/Ajax/AjaxContentLoad */ "./assets/js/core/Ajax/AjaxContentLoad.ts"));

var PreconfiguredVue_1 = __importDefault(__webpack_require__(/*! ../PreconfiguredVue */ "./assets/vue/PreconfiguredVue.ts"));

var axios_1 = __importDefault(__webpack_require__(/*! axios */ "./node_modules/axios/index.js"));

PreconfiguredVue_1["default"].createApp('#sidebar-menu', {
  methods: {
    /**
     * @description will load page content
     */
    loadPageContent: function loadPageContent(event) {
      var url = event.currentTarget.dataset.ajaxHref;
      axios_1["default"].defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // this makes symfony think that this is ajax request

      axios_1["default"].get(url).then(function (response) {
        var ajaxResponseDto = AjaxResponseDto_1["default"].fromAxiosResponse(response.data);
        AjaxContentLoad_1["default"].loadContentIntoMainWrapper(ajaxResponseDto.template);
        AjaxContentLoad_1["default"].appendAndExecuteScriptsIntoMainWrapper(ajaxResponseDto.scriptsSources);
      });
    }
  }
});
exports.default = {};

/***/ }),

/***/ "./assets/vue/page-elements/sidebar.vue":
/*!**********************************************!*\
  !*** ./assets/vue/page-elements/sidebar.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./sidebar.vue?vue&type=script&lang=ts */ "./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts");
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);


/* hot reload */
if (false) {}

_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__.default.__file = "assets/vue/page-elements/sidebar.vue"

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__.default);

/***/ }),

/***/ "./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts":
/*!**********************************************************************!*\
  !*** ./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport default from dynamic */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0___default.a)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!../../../node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./sidebar.vue?vue&type=script&lang=ts */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/page-elements/sidebar.vue?vue&type=script&lang=ts");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_sidebar_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
 

/***/ })

},
0,[["./assets/vue/page-elements/sidebar.vue","runtime","vendors"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9qb2Itc2VhcmNoZXIvLi9hc3NldHMvanMvY29yZS9BamF4L0FqYXhDb250ZW50TG9hZC50cyIsIndlYnBhY2s6Ly9qb2Itc2VhcmNoZXIvLi9hc3NldHMvanMvY29yZS9kdG8vQWJzdHJhY3REdG8udHMiLCJ3ZWJwYWNrOi8vam9iLXNlYXJjaGVyLy4vYXNzZXRzL2pzL2NvcmUvZHRvL0FqYXhSZXNwb25zZUR0by50cyIsIndlYnBhY2s6Ly9qb2Itc2VhcmNoZXIvLi9hc3NldHMvdnVlL1ByZWNvbmZpZ3VyZWRWdWUudHMiLCJ3ZWJwYWNrOi8vam9iLXNlYXJjaGVyLy4vYXNzZXRzL3Z1ZS9wYWdlLWVsZW1lbnRzL3NpZGViYXIudnVlIiwid2VicGFjazovL2pvYi1zZWFyY2hlci8uL2Fzc2V0cy92dWUvcGFnZS1lbGVtZW50cy9zaWRlYmFyLnZ1ZT9jNTdmIiwid2VicGFjazovL2pvYi1zZWFyY2hlci8uL2Fzc2V0cy92dWUvcGFnZS1lbGVtZW50cy9zaWRlYmFyLnZ1ZT82MzgxIl0sIm5hbWVzIjpbIk9iamVjdCIsInZhbHVlIiwiQWpheENvbnRlbnRMb2FkIiwibG9hZENvbnRlbnRJbnRvTWFpbldyYXBwZXIiLCJjb250ZW50IiwibWFpbldyYXBwZXIiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJNQUlOX1dSQVBQRVJfU0VMRUNUT1IiLCJpbm5lckhUTUwiLCJhcHBlbmRBbmRFeGVjdXRlU2NyaXB0c0ludG9NYWluV3JhcHBlciIsInNjcmlwdFNvdXJjZXMiLCJfaSIsInNjcmlwdFNvdXJjZXNfMSIsImxlbmd0aCIsInNvdXJjZSIsInNjcmlwdFRvQXBwZW5kIiwiY3JlYXRlRWxlbWVudCIsInNldEF0dHJpYnV0ZSIsImFwcGVuZENoaWxkIiwiZXhwb3J0cyIsIkFic3RyYWN0RHRvIiwicHJvdG90eXBlIiwiZ2V0RnJvbUFycmF5IiwiYXJyYXkiLCJrZXkiLCJkZWZhdWx0VmFsdWUiLCJpc3NldCIsIl9fZXh0ZW5kcyIsImV4dGVuZFN0YXRpY3MiLCJkIiwiYiIsInNldFByb3RvdHlwZU9mIiwiX19wcm90b19fIiwiQXJyYXkiLCJwIiwiaGFzT3duUHJvcGVydHkiLCJjYWxsIiwiVHlwZUVycm9yIiwiU3RyaW5nIiwiX18iLCJjb25zdHJ1Y3RvciIsImNyZWF0ZSIsIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJBYnN0cmFjdER0b18xIiwicmVxdWlyZSIsIkFqYXhSZXNwb25zZUR0byIsIl9zdXBlciIsIl90aGlzIiwiYXBwbHkiLCJhcmd1bWVudHMiLCJjb2RlIiwibWVzc2FnZSIsInRlbXBsYXRlIiwic3VjY2VzcyIsInNjcmlwdHNTb3VyY2VzIiwiZnJvbUF4aW9zUmVzcG9uc2UiLCJvYmplY3QiLCJhamF4UmVzcG9uc2VEdG8iLCJkYXRhQmFnIiwiaXNDb2RlU2V0IiwiaXNNZXNzYWdlU2V0IiwiaXNUZW1wbGF0ZVNldCIsImlzU3VjY2Vzc1NldCIsImlzU3VjY2Vzc0NvZGUiLCJpc0ludGVybmFsU2VydmVyRXJyb3JDb2RlIiwiaXNEYXRhQmFnU2V0Iiwia2V5cyIsImFyZVNjcmlwdHNTZXQiLCJfX2NyZWF0ZUJpbmRpbmciLCJvIiwibSIsImsiLCJrMiIsInVuZGVmaW5lZCIsImRlZmluZVByb3BlcnR5IiwiZW51bWVyYWJsZSIsImdldCIsIl9fc2V0TW9kdWxlRGVmYXVsdCIsInYiLCJfX2ltcG9ydFN0YXIiLCJyZXN1bHQiLCJ2dWUiLCJQcmVjb25maWd1cmVkVnVlIiwiY3JlYXRlQXBwIiwiZG9tRWxlbWVudFNlbGVjdG9yIiwib3B0aW9ucyIsImRlbGltaXRlcnMiLCJWVUVfREVGQVVMVF9ERUxJTUlURVJTIiwibW91bnQiLCJBamF4UmVzcG9uc2VEdG9fMSIsIkFqYXhDb250ZW50TG9hZF8xIiwiUHJlY29uZmlndXJlZFZ1ZV8xIiwiYXhpb3NfMSIsIm1ldGhvZHMiLCJsb2FkUGFnZUNvbnRlbnQiLCJldmVudCIsInVybCIsImN1cnJlbnRUYXJnZXQiLCJkYXRhc2V0IiwiYWpheEhyZWYiLCJkZWZhdWx0cyIsImhlYWRlcnMiLCJjb21tb24iLCJ0aGVuIiwicmVzcG9uc2UiLCJkYXRhIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBYTs7OztBQUNiQSw4Q0FBNkM7QUFBRUMsT0FBSyxFQUFFO0FBQVQsQ0FBN0M7QUFDQTtBQUNBO0FBQ0E7O0FBQ0EsSUFBSUMsZUFBZTtBQUFHO0FBQWUsWUFBWTtBQUM3QyxXQUFTQSxlQUFULEdBQTJCLENBQzFCO0FBQ0Q7QUFDSjtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0lBLGlCQUFlLENBQUNDLDBCQUFoQixHQUE2QyxVQUFVQyxPQUFWLEVBQW1CO0FBQzVELFFBQUlDLFdBQVcsR0FBR0MsUUFBUSxDQUFDQyxhQUFULENBQXVCTCxlQUFlLENBQUNNLHFCQUF2QyxDQUFsQjtBQUNBSCxlQUFXLENBQUNJLFNBQVosR0FBd0JMLE9BQXhCO0FBQ0gsR0FIRDtBQUlBO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7OztBQUNJRixpQkFBZSxDQUFDUSxzQ0FBaEIsR0FBeUQsVUFBVUMsYUFBVixFQUF5QjtBQUM5RSxRQUFJTixXQUFXLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBVCxDQUF1QkwsZUFBZSxDQUFDTSxxQkFBdkMsQ0FBbEI7O0FBQ0EsU0FBSyxJQUFJSSxFQUFFLEdBQUcsQ0FBVCxFQUFZQyxlQUFlLEdBQUdGLGFBQW5DLEVBQWtEQyxFQUFFLEdBQUdDLGVBQWUsQ0FBQ0MsTUFBdkUsRUFBK0VGLEVBQUUsRUFBakYsRUFBcUY7QUFDakYsVUFBSUcsTUFBTSxHQUFHRixlQUFlLENBQUNELEVBQUQsQ0FBNUI7QUFDQSxVQUFJSSxjQUFjLEdBQUdWLFFBQVEsQ0FBQ1csYUFBVCxDQUF1QixRQUF2QixDQUFyQjtBQUNBRCxvQkFBYyxDQUFDRSxZQUFmLENBQTRCLEtBQTVCLEVBQW1DSCxNQUFuQztBQUNBVixpQkFBVyxDQUFDYyxXQUFaLENBQXdCSCxjQUF4QjtBQUNIO0FBQ0osR0FSRDs7QUFTQWQsaUJBQWUsQ0FBQ00scUJBQWhCLEdBQXdDLHlCQUF4QztBQUNBLFNBQU9OLGVBQVA7QUFDSCxDQTVCb0MsRUFBckM7O0FBNkJBa0IsZUFBQSxHQUFrQmxCLGVBQWxCLEM7Ozs7Ozs7Ozs7O0FDbENhOzs7O0FBQ2JGLDhDQUE2QztBQUFFQyxPQUFLLEVBQUU7QUFBVCxDQUE3QztBQUNBO0FBQ0E7QUFDQTs7QUFDQSxJQUFJb0IsV0FBVztBQUFHO0FBQWUsWUFBWTtBQUN6QyxXQUFTQSxXQUFULEdBQXVCLENBQ3RCO0FBQ0Q7QUFDSjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNJQSxhQUFXLENBQUNDLFNBQVosQ0FBc0JDLFlBQXRCLEdBQXFDLFVBQVVDLEtBQVYsRUFBaUJDLEdBQWpCLEVBQXNCQyxZQUF0QixFQUFvQztBQUNyRSxRQUFJQSxZQUFZLEtBQUssS0FBSyxDQUExQixFQUE2QjtBQUFFQSxrQkFBWSxHQUFHLElBQWY7QUFBc0I7O0FBQ3JELFFBQUksZ0JBQWdCLE9BQU9GLEtBQUssQ0FBQ0MsR0FBRCxDQUFoQyxFQUF1QztBQUNuQyxhQUFPQyxZQUFQO0FBQ0g7O0FBQ0QsV0FBT0YsS0FBSyxDQUFDQyxHQUFELENBQVo7QUFDSCxHQU5EO0FBT0E7QUFDSjtBQUNBO0FBQ0E7OztBQUNJSixhQUFXLENBQUNDLFNBQVosQ0FBc0JLLEtBQXRCLEdBQThCLFVBQVUxQixLQUFWLEVBQWlCO0FBQzNDLFFBQUksZ0JBQWdCLE9BQU9BLEtBQXZCLElBQ0csT0FBT0EsS0FEVixJQUVHLFNBQVNBLEtBRlosSUFHRyxNQUFNQSxLQUFLLENBQUNhLE1BSG5CLEVBRzJCO0FBQ3ZCLGFBQU8sS0FBUDtBQUNIOztBQUNELFdBQU8sSUFBUDtBQUNILEdBUkQ7O0FBU0EsU0FBT08sV0FBUDtBQUNILENBL0JnQyxFQUFqQzs7QUFnQ0FELGVBQUEsR0FBa0JDLFdBQWxCLEM7Ozs7Ozs7Ozs7O0FDckNhOzs7Ozs7Ozs7O0FBQ2IsSUFBSU8sU0FBUyxHQUFJLFFBQVEsS0FBS0EsU0FBZCxJQUE2QixZQUFZO0FBQ3JELE1BQUlDLGNBQWEsR0FBRyx1QkFBVUMsQ0FBVixFQUFhQyxDQUFiLEVBQWdCO0FBQ2hDRixrQkFBYSxHQUFHN0IsTUFBTSxDQUFDZ0MsY0FBUCxJQUNYO0FBQUVDLGVBQVMsRUFBRTtBQUFiLGlCQUE2QkMsS0FBN0IsSUFBc0MsVUFBVUosQ0FBVixFQUFhQyxDQUFiLEVBQWdCO0FBQUVELE9BQUMsQ0FBQ0csU0FBRixHQUFjRixDQUFkO0FBQWtCLEtBRC9ELElBRVosVUFBVUQsQ0FBVixFQUFhQyxDQUFiLEVBQWdCO0FBQUUsV0FBSyxJQUFJSSxDQUFULElBQWNKLENBQWQ7QUFBaUIsWUFBSS9CLE1BQU0sQ0FBQ3NCLFNBQVAsQ0FBaUJjLGNBQWpCLENBQWdDQyxJQUFoQyxDQUFxQ04sQ0FBckMsRUFBd0NJLENBQXhDLENBQUosRUFBZ0RMLENBQUMsQ0FBQ0ssQ0FBRCxDQUFELEdBQU9KLENBQUMsQ0FBQ0ksQ0FBRCxDQUFSO0FBQWpFO0FBQStFLEtBRnJHOztBQUdBLFdBQU9OLGNBQWEsQ0FBQ0MsQ0FBRCxFQUFJQyxDQUFKLENBQXBCO0FBQ0gsR0FMRDs7QUFNQSxTQUFPLFVBQVVELENBQVYsRUFBYUMsQ0FBYixFQUFnQjtBQUNuQixRQUFJLE9BQU9BLENBQVAsS0FBYSxVQUFiLElBQTJCQSxDQUFDLEtBQUssSUFBckMsRUFDSSxNQUFNLElBQUlPLFNBQUosQ0FBYyx5QkFBeUJDLE1BQU0sQ0FBQ1IsQ0FBRCxDQUEvQixHQUFxQywrQkFBbkQsQ0FBTjs7QUFDSkYsa0JBQWEsQ0FBQ0MsQ0FBRCxFQUFJQyxDQUFKLENBQWI7O0FBQ0EsYUFBU1MsRUFBVCxHQUFjO0FBQUUsV0FBS0MsV0FBTCxHQUFtQlgsQ0FBbkI7QUFBdUI7O0FBQ3ZDQSxLQUFDLENBQUNSLFNBQUYsR0FBY1MsQ0FBQyxLQUFLLElBQU4sR0FBYS9CLE1BQU0sQ0FBQzBDLE1BQVAsQ0FBY1gsQ0FBZCxDQUFiLElBQWlDUyxFQUFFLENBQUNsQixTQUFILEdBQWVTLENBQUMsQ0FBQ1QsU0FBakIsRUFBNEIsSUFBSWtCLEVBQUosRUFBN0QsQ0FBZDtBQUNILEdBTkQ7QUFPSCxDQWQyQyxFQUE1Qzs7QUFlQSxJQUFJRyxlQUFlLEdBQUksUUFBUSxLQUFLQSxlQUFkLElBQWtDLFVBQVVDLEdBQVYsRUFBZTtBQUNuRSxTQUFRQSxHQUFHLElBQUlBLEdBQUcsQ0FBQ0MsVUFBWixHQUEwQkQsR0FBMUIsR0FBZ0M7QUFBRSxlQUFXQTtBQUFiLEdBQXZDO0FBQ0gsQ0FGRDs7QUFHQTVDLDhDQUE2QztBQUFFQyxPQUFLLEVBQUU7QUFBVCxDQUE3Qzs7QUFDQSxJQUFJNkMsYUFBYSxHQUFHSCxlQUFlLENBQUNJLG1CQUFPLENBQUMsMERBQUQsQ0FBUixDQUFuQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUNBLElBQUlDLGVBQWU7QUFBRztBQUFlLFVBQVVDLE1BQVYsRUFBa0I7QUFDbkRyQixXQUFTLENBQUNvQixlQUFELEVBQWtCQyxNQUFsQixDQUFUOztBQUNBLFdBQVNELGVBQVQsR0FBMkI7QUFDdkIsUUFBSUUsS0FBSyxHQUFHRCxNQUFNLEtBQUssSUFBWCxJQUFtQkEsTUFBTSxDQUFDRSxLQUFQLENBQWEsSUFBYixFQUFtQkMsU0FBbkIsQ0FBbkIsSUFBb0QsSUFBaEU7QUFDQTtBQUNSO0FBQ0E7OztBQUNRRixTQUFLLENBQUNHLElBQU4sR0FBYSxHQUFiO0FBQ0E7QUFDUjtBQUNBOztBQUNRSCxTQUFLLENBQUNJLE9BQU4sR0FBZ0IsRUFBaEI7QUFDQTtBQUNSO0FBQ0E7O0FBQ1FKLFNBQUssQ0FBQ0ssUUFBTixHQUFpQixFQUFqQjtBQUNBO0FBQ1I7QUFDQTs7QUFDUUwsU0FBSyxDQUFDTSxPQUFOLEdBQWdCLEtBQWhCO0FBQ0E7QUFDUjtBQUNBOztBQUNRTixTQUFLLENBQUNPLGNBQU4sR0FBdUIsRUFBdkI7QUFDQSxXQUFPUCxLQUFQO0FBQ0g7QUFDRDtBQUNKO0FBQ0E7QUFDQTtBQUNBOzs7QUFDSUYsaUJBQWUsQ0FBQ1UsaUJBQWhCLEdBQW9DLFVBQVVDLE1BQVYsRUFBa0I7QUFDbEQsUUFBSUMsZUFBZSxHQUFHLElBQUlaLGVBQUosRUFBdEI7QUFDQVksbUJBQWUsQ0FBQ1AsSUFBaEIsR0FBdUJNLE1BQU0sQ0FBQ04sSUFBOUI7QUFDQU8sbUJBQWUsQ0FBQ04sT0FBaEIsR0FBMEJLLE1BQU0sQ0FBQ0wsT0FBakM7QUFDQU0sbUJBQWUsQ0FBQ0wsUUFBaEIsR0FBMkJJLE1BQU0sQ0FBQ0osUUFBbEM7QUFDQUssbUJBQWUsQ0FBQ0osT0FBaEIsR0FBMEJHLE1BQU0sQ0FBQ0gsT0FBakM7QUFDQUksbUJBQWUsQ0FBQ0MsT0FBaEIsR0FBMEJGLE1BQU0sQ0FBQ0UsT0FBakM7QUFDQUQsbUJBQWUsQ0FBQ0gsY0FBaEIsR0FBaUNFLE1BQU0sQ0FBQ0YsY0FBeEM7QUFDQSxXQUFPRyxlQUFQO0FBQ0gsR0FURDtBQVVBO0FBQ0o7QUFDQTs7O0FBQ0laLGlCQUFlLENBQUMxQixTQUFoQixDQUEwQndDLFNBQTFCLEdBQXNDLFlBQVk7QUFDOUMsV0FBTyxLQUFLbkMsS0FBTCxDQUFXLEtBQUswQixJQUFoQixDQUFQO0FBQ0gsR0FGRDtBQUdBO0FBQ0o7QUFDQTs7O0FBQ0lMLGlCQUFlLENBQUMxQixTQUFoQixDQUEwQnlDLFlBQTFCLEdBQXlDLFlBQVk7QUFDakQsV0FBTyxLQUFLcEMsS0FBTCxDQUFXLEtBQUsyQixPQUFoQixDQUFQO0FBQ0gsR0FGRDtBQUdBO0FBQ0o7QUFDQTs7O0FBQ0lOLGlCQUFlLENBQUMxQixTQUFoQixDQUEwQjBDLGFBQTFCLEdBQTBDLFlBQVk7QUFDbEQsV0FBTyxLQUFLckMsS0FBTCxDQUFXLEtBQUs0QixRQUFoQixDQUFQO0FBQ0gsR0FGRDtBQUdBO0FBQ0o7QUFDQTs7O0FBQ0lQLGlCQUFlLENBQUMxQixTQUFoQixDQUEwQjJDLFlBQTFCLEdBQXlDLFlBQVk7QUFDakQsV0FBTyxLQUFLdEMsS0FBTCxDQUFXLEtBQUs2QixPQUFoQixDQUFQO0FBQ0gsR0FGRDtBQUdBO0FBQ0o7QUFDQTs7O0FBQ0lSLGlCQUFlLENBQUMxQixTQUFoQixDQUEwQjRDLGFBQTFCLEdBQTBDLFlBQVk7QUFDbEQsUUFBSSxLQUFLYixJQUFMLElBQWEsR0FBYixJQUNHLEtBQUtBLElBQUwsR0FBWSxHQURuQixFQUN3QjtBQUNwQixhQUFPLElBQVA7QUFDSDs7QUFDRCxXQUFPLEtBQVA7QUFDSCxHQU5EO0FBT0E7QUFDSjtBQUNBOzs7QUFDSUwsaUJBQWUsQ0FBQzFCLFNBQWhCLENBQTBCNkMseUJBQTFCLEdBQXNELFlBQVk7QUFDOUQsV0FBUSxLQUFLZCxJQUFMLElBQWEsR0FBckI7QUFDSCxHQUZEO0FBR0E7QUFDSjtBQUNBOzs7QUFDSUwsaUJBQWUsQ0FBQzFCLFNBQWhCLENBQTBCOEMsWUFBMUIsR0FBeUMsWUFBWTtBQUNqRCxXQUFRLE1BQU1wRSxNQUFNLENBQUNxRSxJQUFQLENBQVksS0FBS1IsT0FBakIsRUFBMEIvQyxNQUF4QztBQUNILEdBRkQ7QUFHQTtBQUNKO0FBQ0E7OztBQUNJa0MsaUJBQWUsQ0FBQzFCLFNBQWhCLENBQTBCZ0QsYUFBMUIsR0FBMEMsWUFBWTtBQUNsRCxXQUFRLEtBQUssS0FBS2IsY0FBTCxDQUFvQjNDLE1BQWpDO0FBQ0gsR0FGRDs7QUFHQSxTQUFPa0MsZUFBUDtBQUNILENBOUZvQyxDQThGbkNGLGFBQWEsV0E5RnNCLENBQXJDOztBQStGQTFCLGVBQUEsR0FBa0I0QixlQUFsQixDOzs7Ozs7Ozs7OztBQ3pIYTs7Ozs7O0FBQ2IsSUFBSXVCLGVBQWUsR0FBSSxRQUFRLEtBQUtBLGVBQWQsS0FBbUN2RSxNQUFNLENBQUMwQyxNQUFQLEdBQWlCLFVBQVM4QixDQUFULEVBQVlDLENBQVosRUFBZUMsQ0FBZixFQUFrQkMsRUFBbEIsRUFBc0I7QUFDNUYsTUFBSUEsRUFBRSxLQUFLQyxTQUFYLEVBQXNCRCxFQUFFLEdBQUdELENBQUw7QUFDdEIxRSxRQUFNLENBQUM2RSxjQUFQLENBQXNCTCxDQUF0QixFQUF5QkcsRUFBekIsRUFBNkI7QUFBRUcsY0FBVSxFQUFFLElBQWQ7QUFBb0JDLE9BQUcsRUFBRSxlQUFXO0FBQUUsYUFBT04sQ0FBQyxDQUFDQyxDQUFELENBQVI7QUFBYztBQUFwRCxHQUE3QjtBQUNILENBSHdELEdBR25ELFVBQVNGLENBQVQsRUFBWUMsQ0FBWixFQUFlQyxDQUFmLEVBQWtCQyxFQUFsQixFQUFzQjtBQUN4QixNQUFJQSxFQUFFLEtBQUtDLFNBQVgsRUFBc0JELEVBQUUsR0FBR0QsQ0FBTDtBQUN0QkYsR0FBQyxDQUFDRyxFQUFELENBQUQsR0FBUUYsQ0FBQyxDQUFDQyxDQUFELENBQVQ7QUFDSCxDQU5xQixDQUF0Qjs7QUFPQSxJQUFJTSxrQkFBa0IsR0FBSSxRQUFRLEtBQUtBLGtCQUFkLEtBQXNDaEYsTUFBTSxDQUFDMEMsTUFBUCxHQUFpQixVQUFTOEIsQ0FBVCxFQUFZUyxDQUFaLEVBQWU7QUFDM0ZqRixRQUFNLENBQUM2RSxjQUFQLENBQXNCTCxDQUF0QixFQUF5QixTQUF6QixFQUFvQztBQUFFTSxjQUFVLEVBQUUsSUFBZDtBQUFvQjdFLFNBQUssRUFBRWdGO0FBQTNCLEdBQXBDO0FBQ0gsQ0FGOEQsR0FFMUQsVUFBU1QsQ0FBVCxFQUFZUyxDQUFaLEVBQWU7QUFDaEJULEdBQUMsQ0FBQyxTQUFELENBQUQsR0FBZVMsQ0FBZjtBQUNILENBSndCLENBQXpCOztBQUtBLElBQUlDLFlBQVksR0FBSSxRQUFRLEtBQUtBLFlBQWQsSUFBK0IsVUFBVXRDLEdBQVYsRUFBZTtBQUM3RCxNQUFJQSxHQUFHLElBQUlBLEdBQUcsQ0FBQ0MsVUFBZixFQUEyQixPQUFPRCxHQUFQO0FBQzNCLE1BQUl1QyxNQUFNLEdBQUcsRUFBYjtBQUNBLE1BQUl2QyxHQUFHLElBQUksSUFBWCxFQUFpQixLQUFLLElBQUk4QixDQUFULElBQWM5QixHQUFkO0FBQW1CLFFBQUk4QixDQUFDLEtBQUssU0FBTixJQUFtQjFFLE1BQU0sQ0FBQ3NCLFNBQVAsQ0FBaUJjLGNBQWpCLENBQWdDQyxJQUFoQyxDQUFxQ08sR0FBckMsRUFBMEM4QixDQUExQyxDQUF2QixFQUFxRUgsZUFBZSxDQUFDWSxNQUFELEVBQVN2QyxHQUFULEVBQWM4QixDQUFkLENBQWY7QUFBeEY7O0FBQ2pCTSxvQkFBa0IsQ0FBQ0csTUFBRCxFQUFTdkMsR0FBVCxDQUFsQjs7QUFDQSxTQUFPdUMsTUFBUDtBQUNILENBTkQ7O0FBT0FuRiw4Q0FBNkM7QUFBRUMsT0FBSyxFQUFFO0FBQVQsQ0FBN0M7O0FBQ0EsSUFBSW1GLEdBQUcsR0FBR0YsWUFBWSxDQUFDbkMsbUJBQU8sQ0FBQyx1REFBRCxDQUFSLENBQXRCOztBQUNBLElBQUlzQyxnQkFBZ0I7QUFBRztBQUFlLFlBQVk7QUFDOUMsV0FBU0EsZ0JBQVQsR0FBNEIsQ0FDM0I7QUFDRDtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0lBLGtCQUFnQixDQUFDQyxTQUFqQixHQUE2QixVQUFVQyxrQkFBVixFQUE4QkMsT0FBOUIsRUFBdUM7QUFDaEU7QUFDQUEsV0FBTyxDQUFDQyxVQUFSLEdBQXFCSixnQkFBZ0IsQ0FBQ0ssc0JBQXRDO0FBQ0FOLE9BQUcsQ0FBQ0UsU0FBSixDQUFjRSxPQUFkLEVBQXVCRyxLQUF2QixDQUE2Qkosa0JBQTdCO0FBQ0gsR0FKRDtBQUtBO0FBQ0o7QUFDQTs7O0FBQ0lGLGtCQUFnQixDQUFDSyxzQkFBakIsR0FBMEMsQ0FBQyxJQUFELEVBQU8sSUFBUCxDQUExQztBQUNBLFNBQU9MLGdCQUFQO0FBQ0gsQ0FwQnFDLEVBQXRDOztBQXFCQWpFLGVBQUEsR0FBa0JpRSxnQkFBbEIsQzs7Ozs7Ozs7Ozs7QUMzQ2E7Ozs7QUFDYixJQUFJMUMsZUFBZSxHQUFJLFFBQVEsS0FBS0EsZUFBZCxJQUFrQyxVQUFVQyxHQUFWLEVBQWU7QUFDbkUsU0FBUUEsR0FBRyxJQUFJQSxHQUFHLENBQUNDLFVBQVosR0FBMEJELEdBQTFCLEdBQWdDO0FBQUUsZUFBV0E7QUFBYixHQUF2QztBQUNILENBRkQ7O0FBR0E1Qyw4Q0FBNkM7QUFBRUMsT0FBSyxFQUFFO0FBQVQsQ0FBN0M7O0FBQ0EsSUFBSTJGLGlCQUFpQixHQUFHakQsZUFBZSxDQUFDSSxtQkFBTyxDQUFDLGtGQUFELENBQVIsQ0FBdkM7O0FBQ0EsSUFBSThDLGlCQUFpQixHQUFHbEQsZUFBZSxDQUFDSSxtQkFBTyxDQUFDLG9GQUFELENBQVIsQ0FBdkM7O0FBQ0EsSUFBSStDLGtCQUFrQixHQUFHbkQsZUFBZSxDQUFDSSxtQkFBTyxDQUFDLDZEQUFELENBQVIsQ0FBeEM7O0FBQ0EsSUFBSWdELE9BQU8sR0FBR3BELGVBQWUsQ0FBQ0ksbUJBQU8sQ0FBQyw0Q0FBRCxDQUFSLENBQTdCOztBQUNBK0Msa0JBQWtCLFdBQWxCLENBQTJCUixTQUEzQixDQUFxQyxlQUFyQyxFQUFzRDtBQUNsRFUsU0FBTyxFQUFFO0FBQ0w7QUFDUjtBQUNBO0FBQ1FDLG1CQUFlLEVBQUUseUJBQVVDLEtBQVYsRUFBaUI7QUFDOUIsVUFBSUMsR0FBRyxHQUFHRCxLQUFLLENBQUNFLGFBQU4sQ0FBb0JDLE9BQXBCLENBQTRCQyxRQUF0QztBQUNBUCxhQUFPLFdBQVAsQ0FBZ0JRLFFBQWhCLENBQXlCQyxPQUF6QixDQUFpQ0MsTUFBakMsQ0FBd0Msa0JBQXhDLElBQThELGdCQUE5RCxDQUY4QixDQUVrRDs7QUFDaEZWLGFBQU8sV0FBUCxDQUFnQmhCLEdBQWhCLENBQW9Cb0IsR0FBcEIsRUFBeUJPLElBQXpCLENBQThCLFVBQVVDLFFBQVYsRUFBb0I7QUFDOUMsWUFBSS9DLGVBQWUsR0FBR2dDLGlCQUFpQixXQUFqQixDQUEwQmxDLGlCQUExQixDQUE0Q2lELFFBQVEsQ0FBQ0MsSUFBckQsQ0FBdEI7QUFDQWYseUJBQWlCLFdBQWpCLENBQTBCMUYsMEJBQTFCLENBQXFEeUQsZUFBZSxDQUFDTCxRQUFyRTtBQUNBc0MseUJBQWlCLFdBQWpCLENBQTBCbkYsc0NBQTFCLENBQWlFa0QsZUFBZSxDQUFDSCxjQUFqRjtBQUNILE9BSkQ7QUFLSDtBQVpJO0FBRHlDLENBQXREO0FBZ0JBckMsZUFBQSxHQUFrQixFQUFsQixDOzs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDekIwRDtBQUNMO0FBQ3JEO0FBQ0EsSUFBSSxLQUFVLEVBQUUsRUFRZjs7QUFFRCxnRkFBYTs7QUFFYixpRUFBZSx5RTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNmZ1EsQyIsImZpbGUiOiJzaWRlYmFyLmpzIiwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG4vKipcbiAqIEBkZXNjcmlwdGlvbiBoYW5kbGVzIGxvYWRpbmcgY29udGVudCB2aWEgYWpheFxuICovXG52YXIgQWpheENvbnRlbnRMb2FkID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xuICAgIGZ1bmN0aW9uIEFqYXhDb250ZW50TG9hZCgpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogQGRlc2NyaXB0aW9uIFdpbGwgaW5zZXJ0IGdpdmVuIGNvbnRlbnQgaW50IG8gbWFpbiB3cmFwcGVyXG4gICAgICpcbiAgICAgKiBAcGFyYW0gY29udGVudFxuICAgICAqL1xuICAgIEFqYXhDb250ZW50TG9hZC5sb2FkQ29udGVudEludG9NYWluV3JhcHBlciA9IGZ1bmN0aW9uIChjb250ZW50KSB7XG4gICAgICAgIHZhciBtYWluV3JhcHBlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoQWpheENvbnRlbnRMb2FkLk1BSU5fV1JBUFBFUl9TRUxFQ1RPUik7XG4gICAgICAgIG1haW5XcmFwcGVyLmlubmVySFRNTCA9IGNvbnRlbnQ7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBAZGVzY3JpcHRpb24gV2lsbCBhcHBlbmQgc2NyaXB0cyBpbnRvIHRoZSBgLm1haW4tY29udGFpbmVyLXdyYXBwZXJgIGFuZCBleGVjdXRlIHRoZW0gYWZ0ZXJ3YXJkc1xuICAgICAqXG4gICAgICogQHBhcmFtIHNjcmlwdFNvdXJjZXNcbiAgICAgKi9cbiAgICBBamF4Q29udGVudExvYWQuYXBwZW5kQW5kRXhlY3V0ZVNjcmlwdHNJbnRvTWFpbldyYXBwZXIgPSBmdW5jdGlvbiAoc2NyaXB0U291cmNlcykge1xuICAgICAgICB2YXIgbWFpbldyYXBwZXIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKEFqYXhDb250ZW50TG9hZC5NQUlOX1dSQVBQRVJfU0VMRUNUT1IpO1xuICAgICAgICBmb3IgKHZhciBfaSA9IDAsIHNjcmlwdFNvdXJjZXNfMSA9IHNjcmlwdFNvdXJjZXM7IF9pIDwgc2NyaXB0U291cmNlc18xLmxlbmd0aDsgX2krKykge1xuICAgICAgICAgICAgdmFyIHNvdXJjZSA9IHNjcmlwdFNvdXJjZXNfMVtfaV07XG4gICAgICAgICAgICB2YXIgc2NyaXB0VG9BcHBlbmQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdTQ1JJUFQnKTtcbiAgICAgICAgICAgIHNjcmlwdFRvQXBwZW5kLnNldEF0dHJpYnV0ZSgnc3JjJywgc291cmNlKTtcbiAgICAgICAgICAgIG1haW5XcmFwcGVyLmFwcGVuZENoaWxkKHNjcmlwdFRvQXBwZW5kKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgQWpheENvbnRlbnRMb2FkLk1BSU5fV1JBUFBFUl9TRUxFQ1RPUiA9IFwiLm1haW4tY29udGFpbmVyLXdyYXBwZXJcIjtcbiAgICByZXR1cm4gQWpheENvbnRlbnRMb2FkO1xufSgpKTtcbmV4cG9ydHMuZGVmYXVsdCA9IEFqYXhDb250ZW50TG9hZDtcbiIsIlwidXNlIHN0cmljdFwiO1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xuLyoqXG4gKiBAZGVzY3JpcHRpb24gQ29tbW9uIG1ldGhvZHMgLyBkYXRhIHVzZWQgZm9yIGNoaWxkcmVuIERUTyBjbGFzc2VzXG4gKi9cbnZhciBBYnN0cmFjdER0byA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBBYnN0cmFjdER0bygpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogUmV0dXJucyBmb3VuZCB2YWx1ZSBmb3Iga2V5IGluIGFycmF5LCBpZiBub24gaXMgZm91bmQgLSByZXR1cm5zIGRlZmF1bHRWYWx1ZVxuICAgICAqIEBwYXJhbSBhcnJheSB7YXJyYXl9XG4gICAgICogQHBhcmFtIGtleSB7c3RyaW5nfVxuICAgICAqIEBwYXJhbSBkZWZhdWx0VmFsdWVcbiAgICAgKiBAcmV0dXJucyB7bnVsbHxzdHJpbmd9XG4gICAgICovXG4gICAgQWJzdHJhY3REdG8ucHJvdG90eXBlLmdldEZyb21BcnJheSA9IGZ1bmN0aW9uIChhcnJheSwga2V5LCBkZWZhdWx0VmFsdWUpIHtcbiAgICAgICAgaWYgKGRlZmF1bHRWYWx1ZSA9PT0gdm9pZCAwKSB7IGRlZmF1bHRWYWx1ZSA9IG51bGw7IH1cbiAgICAgICAgaWYgKFwidW5kZWZpbmVkXCIgPT09IHR5cGVvZiBhcnJheVtrZXldKSB7XG4gICAgICAgICAgICByZXR1cm4gZGVmYXVsdFZhbHVlO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBhcnJheVtrZXldO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogQ2hlY2tzIGlmIHRoZSB2YWx1ZSBpcyBub24gZW1wdHkvbnVsbC91bmRlZmluZWRcbiAgICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgICAqL1xuICAgIEFic3RyYWN0RHRvLnByb3RvdHlwZS5pc3NldCA9IGZ1bmN0aW9uICh2YWx1ZSkge1xuICAgICAgICBpZiAoXCJ1bmRlZmluZWRcIiA9PT0gdHlwZW9mIHZhbHVlXG4gICAgICAgICAgICB8fCBcIlwiID09PSB2YWx1ZVxuICAgICAgICAgICAgfHwgbnVsbCA9PT0gdmFsdWVcbiAgICAgICAgICAgIHx8IDAgPT09IHZhbHVlLmxlbmd0aCkge1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiB0cnVlO1xuICAgIH07XG4gICAgcmV0dXJuIEFic3RyYWN0RHRvO1xufSgpKTtcbmV4cG9ydHMuZGVmYXVsdCA9IEFic3RyYWN0RHRvO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19leHRlbmRzID0gKHRoaXMgJiYgdGhpcy5fX2V4dGVuZHMpIHx8IChmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGV4dGVuZFN0YXRpY3MgPSBmdW5jdGlvbiAoZCwgYikge1xuICAgICAgICBleHRlbmRTdGF0aWNzID0gT2JqZWN0LnNldFByb3RvdHlwZU9mIHx8XG4gICAgICAgICAgICAoeyBfX3Byb3RvX186IFtdIH0gaW5zdGFuY2VvZiBBcnJheSAmJiBmdW5jdGlvbiAoZCwgYikgeyBkLl9fcHJvdG9fXyA9IGI7IH0pIHx8XG4gICAgICAgICAgICBmdW5jdGlvbiAoZCwgYikgeyBmb3IgKHZhciBwIGluIGIpIGlmIChPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwoYiwgcCkpIGRbcF0gPSBiW3BdOyB9O1xuICAgICAgICByZXR1cm4gZXh0ZW5kU3RhdGljcyhkLCBiKTtcbiAgICB9O1xuICAgIHJldHVybiBmdW5jdGlvbiAoZCwgYikge1xuICAgICAgICBpZiAodHlwZW9mIGIgIT09IFwiZnVuY3Rpb25cIiAmJiBiICE9PSBudWxsKVxuICAgICAgICAgICAgdGhyb3cgbmV3IFR5cGVFcnJvcihcIkNsYXNzIGV4dGVuZHMgdmFsdWUgXCIgKyBTdHJpbmcoYikgKyBcIiBpcyBub3QgYSBjb25zdHJ1Y3RvciBvciBudWxsXCIpO1xuICAgICAgICBleHRlbmRTdGF0aWNzKGQsIGIpO1xuICAgICAgICBmdW5jdGlvbiBfXygpIHsgdGhpcy5jb25zdHJ1Y3RvciA9IGQ7IH1cbiAgICAgICAgZC5wcm90b3R5cGUgPSBiID09PSBudWxsID8gT2JqZWN0LmNyZWF0ZShiKSA6IChfXy5wcm90b3R5cGUgPSBiLnByb3RvdHlwZSwgbmV3IF9fKCkpO1xuICAgIH07XG59KSgpO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIEFic3RyYWN0RHRvXzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcIi4vQWJzdHJhY3REdG9cIikpO1xuLyoqXG4gKiBAZGVzY3JpcHRpb24gTWFpbiBvYmplY3QgdXNlZCB0byBjb252ZXJ0IHN0YW5kYXJkIGFycmF5IHJlc3BvbnNlIGZyb20gYmFja2VuZCAodXBvbiBhamF4IGNhbGxzKVxuICogICAgICAgICAgICAgIG1pZ2h0IG5vdCBjb250YWluIGFsbCByZXR1cm5lZCBmaWVsZHMgLSBzaG91bGQgYmUgZXhwYW5kZWQgaWYgbmVlZGVkIC8gdGhlIHNhbWUgYWJvdXQgYmFja2VuZFxuICogICAgICAgICAgICAgIGFqYXhSZXNwb25zZVxuICovXG52YXIgQWpheFJlc3BvbnNlRHRvID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKF9zdXBlcikge1xuICAgIF9fZXh0ZW5kcyhBamF4UmVzcG9uc2VEdG8sIF9zdXBlcik7XG4gICAgZnVuY3Rpb24gQWpheFJlc3BvbnNlRHRvKCkge1xuICAgICAgICB2YXIgX3RoaXMgPSBfc3VwZXIgIT09IG51bGwgJiYgX3N1cGVyLmFwcGx5KHRoaXMsIGFyZ3VtZW50cykgfHwgdGhpcztcbiAgICAgICAgLyoqXG4gICAgICAgICAqIEB0eXBlIGludFxuICAgICAgICAgKi9cbiAgICAgICAgX3RoaXMuY29kZSA9IDIwMDtcbiAgICAgICAgLyoqXG4gICAgICAgICAqIEB0eXBlIHN0cmluZ1xuICAgICAgICAgKi9cbiAgICAgICAgX3RoaXMubWVzc2FnZSA9IFwiXCI7XG4gICAgICAgIC8qKlxuICAgICAgICAgKiBAdHlwZSBzdHJpbmdcbiAgICAgICAgICovXG4gICAgICAgIF90aGlzLnRlbXBsYXRlID0gXCJcIjtcbiAgICAgICAgLyoqXG4gICAgICAgICAqIEB0eXBlIGJvb2xlYW5cbiAgICAgICAgICovXG4gICAgICAgIF90aGlzLnN1Y2Nlc3MgPSBmYWxzZTtcbiAgICAgICAgLyoqXG4gICAgICAgICAqIEB0eXBlIEFycmF5PHN0cmluZz5cbiAgICAgICAgICovXG4gICAgICAgIF90aGlzLnNjcmlwdHNTb3VyY2VzID0gW107XG4gICAgICAgIHJldHVybiBfdGhpcztcbiAgICB9XG4gICAgLyoqXG4gICAgICogQnVpbGRzIERUTyBmcm9tIGRhdGEgYXJyYXlcbiAgICAgKiBAcmV0dXJucyB7QWpheFJlc3BvbnNlRHRvfVxuICAgICAqIEBwYXJhbSBvYmplY3RcbiAgICAgKi9cbiAgICBBamF4UmVzcG9uc2VEdG8uZnJvbUF4aW9zUmVzcG9uc2UgPSBmdW5jdGlvbiAob2JqZWN0KSB7XG4gICAgICAgIHZhciBhamF4UmVzcG9uc2VEdG8gPSBuZXcgQWpheFJlc3BvbnNlRHRvKCk7XG4gICAgICAgIGFqYXhSZXNwb25zZUR0by5jb2RlID0gb2JqZWN0LmNvZGU7XG4gICAgICAgIGFqYXhSZXNwb25zZUR0by5tZXNzYWdlID0gb2JqZWN0Lm1lc3NhZ2U7XG4gICAgICAgIGFqYXhSZXNwb25zZUR0by50ZW1wbGF0ZSA9IG9iamVjdC50ZW1wbGF0ZTtcbiAgICAgICAgYWpheFJlc3BvbnNlRHRvLnN1Y2Nlc3MgPSBvYmplY3Quc3VjY2VzcztcbiAgICAgICAgYWpheFJlc3BvbnNlRHRvLmRhdGFCYWcgPSBvYmplY3QuZGF0YUJhZztcbiAgICAgICAgYWpheFJlc3BvbnNlRHRvLnNjcmlwdHNTb3VyY2VzID0gb2JqZWN0LnNjcmlwdHNTb3VyY2VzO1xuICAgICAgICByZXR1cm4gYWpheFJlc3BvbnNlRHRvO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICAgKi9cbiAgICBBamF4UmVzcG9uc2VEdG8ucHJvdG90eXBlLmlzQ29kZVNldCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIHRoaXMuaXNzZXQodGhpcy5jb2RlKTtcbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEByZXR1cm4ge2Jvb2xlYW59XG4gICAgICovXG4gICAgQWpheFJlc3BvbnNlRHRvLnByb3RvdHlwZS5pc01lc3NhZ2VTZXQgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHJldHVybiB0aGlzLmlzc2V0KHRoaXMubWVzc2FnZSk7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgICAqL1xuICAgIEFqYXhSZXNwb25zZUR0by5wcm90b3R5cGUuaXNUZW1wbGF0ZVNldCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIHRoaXMuaXNzZXQodGhpcy50ZW1wbGF0ZSk7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgICAqL1xuICAgIEFqYXhSZXNwb25zZUR0by5wcm90b3R5cGUuaXNTdWNjZXNzU2V0ID0gZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gdGhpcy5pc3NldCh0aGlzLnN1Y2Nlc3MpO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICAgKi9cbiAgICBBamF4UmVzcG9uc2VEdG8ucHJvdG90eXBlLmlzU3VjY2Vzc0NvZGUgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIGlmICh0aGlzLmNvZGUgPj0gMjAwXG4gICAgICAgICAgICAmJiB0aGlzLmNvZGUgPCAzMDApIHtcbiAgICAgICAgICAgIHJldHVybiB0cnVlO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEByZXR1cm5zIHtib29sZWFufVxuICAgICAqL1xuICAgIEFqYXhSZXNwb25zZUR0by5wcm90b3R5cGUuaXNJbnRlcm5hbFNlcnZlckVycm9yQ29kZSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuICh0aGlzLmNvZGUgPj0gNTAwKTtcbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEByZXR1cm5zIHtib29sZWFufVxuICAgICAqL1xuICAgIEFqYXhSZXNwb25zZUR0by5wcm90b3R5cGUuaXNEYXRhQmFnU2V0ID0gZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gKDAgIT09IE9iamVjdC5rZXlzKHRoaXMuZGF0YUJhZykubGVuZ3RoKTtcbiAgICB9O1xuICAgIC8qKlxuICAgICAqIEByZXR1cm5zIHtib29sZWFufVxuICAgICAqL1xuICAgIEFqYXhSZXNwb25zZUR0by5wcm90b3R5cGUuYXJlU2NyaXB0c1NldCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuICgwICE9IHRoaXMuc2NyaXB0c1NvdXJjZXMubGVuZ3RoKTtcbiAgICB9O1xuICAgIHJldHVybiBBamF4UmVzcG9uc2VEdG87XG59KEFic3RyYWN0RHRvXzEuZGVmYXVsdCkpO1xuZXhwb3J0cy5kZWZhdWx0ID0gQWpheFJlc3BvbnNlRHRvO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19jcmVhdGVCaW5kaW5nID0gKHRoaXMgJiYgdGhpcy5fX2NyZWF0ZUJpbmRpbmcpIHx8IChPYmplY3QuY3JlYXRlID8gKGZ1bmN0aW9uKG8sIG0sIGssIGsyKSB7XG4gICAgaWYgKGsyID09PSB1bmRlZmluZWQpIGsyID0gaztcbiAgICBPYmplY3QuZGVmaW5lUHJvcGVydHkobywgazIsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBmdW5jdGlvbigpIHsgcmV0dXJuIG1ba107IH0gfSk7XG59KSA6IChmdW5jdGlvbihvLCBtLCBrLCBrMikge1xuICAgIGlmIChrMiA9PT0gdW5kZWZpbmVkKSBrMiA9IGs7XG4gICAgb1trMl0gPSBtW2tdO1xufSkpO1xudmFyIF9fc2V0TW9kdWxlRGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19zZXRNb2R1bGVEZWZhdWx0KSB8fCAoT2JqZWN0LmNyZWF0ZSA/IChmdW5jdGlvbihvLCB2KSB7XG4gICAgT2JqZWN0LmRlZmluZVByb3BlcnR5KG8sIFwiZGVmYXVsdFwiLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2IH0pO1xufSkgOiBmdW5jdGlvbihvLCB2KSB7XG4gICAgb1tcImRlZmF1bHRcIl0gPSB2O1xufSk7XG52YXIgX19pbXBvcnRTdGFyID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydFN0YXIpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICBpZiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSByZXR1cm4gbW9kO1xuICAgIHZhciByZXN1bHQgPSB7fTtcbiAgICBpZiAobW9kICE9IG51bGwpIGZvciAodmFyIGsgaW4gbW9kKSBpZiAoayAhPT0gXCJkZWZhdWx0XCIgJiYgT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG1vZCwgaykpIF9fY3JlYXRlQmluZGluZyhyZXN1bHQsIG1vZCwgayk7XG4gICAgX19zZXRNb2R1bGVEZWZhdWx0KHJlc3VsdCwgbW9kKTtcbiAgICByZXR1cm4gcmVzdWx0O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciB2dWUgPSBfX2ltcG9ydFN0YXIocmVxdWlyZShcInZ1ZVwiKSk7XG52YXIgUHJlY29uZmlndXJlZFZ1ZSA9IC8qKiBAY2xhc3MgKi8gKGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBQcmVjb25maWd1cmVkVnVlKCkge1xuICAgIH1cbiAgICAvKipcbiAgICAgKiBAZGVzY3JpcHRpb24gY3JlYXRlcyB2dWUgaW5zdGFuY2UgZm9yIGRvbSBlbGVtZW50IGJ1dCB1c2VzIHByZWNvbmZpZ3VyZWQgdnVlIHdpdGggY29tbW9uIHJldXNhYmxlIGxvZ2ljLFxuICAgICAqICAgICAgICAgICAgICB0aGlzIHByb3ZpZGVzIHRoZSBzYW1lIG91dHB1dCBhcyBjcmVhdGluZyBTUEEgd2l0aCB2dWUgaW4gcm9vdCBzdWNoIGFzIGJvZHlcbiAgICAgKlxuICAgICAqIEBwYXJhbSBkb21FbGVtZW50U2VsZWN0b3JcbiAgICAgKiBAcGFyYW0gb3B0aW9uc1xuICAgICAqL1xuICAgIFByZWNvbmZpZ3VyZWRWdWUuY3JlYXRlQXBwID0gZnVuY3Rpb24gKGRvbUVsZW1lbnRTZWxlY3Rvciwgb3B0aW9ucykge1xuICAgICAgICAvL0B0cy1pZ25vcmVcbiAgICAgICAgb3B0aW9ucy5kZWxpbWl0ZXJzID0gUHJlY29uZmlndXJlZFZ1ZS5WVUVfREVGQVVMVF9ERUxJTUlURVJTO1xuICAgICAgICB2dWUuY3JlYXRlQXBwKG9wdGlvbnMpLm1vdW50KGRvbUVsZW1lbnRTZWxlY3Rvcik7XG4gICAgfTtcbiAgICAvKipcbiAgICAgKiBAZGVzY3JpcHRpb24gZGVsaW1pdGVycyB1c2VkIHRvIHRyYW5zbGF0ZSB2dWUgbG9naWMsIHJlcXVpcmVkIHNpbmNlIHR3aWcgdXRpbGl6ZXMgdGhlIGB7eyB9fWBcbiAgICAgKi9cbiAgICBQcmVjb25maWd1cmVkVnVlLlZVRV9ERUZBVUxUX0RFTElNSVRFUlMgPSBbXCJbW1wiLCBcIl1dXCJdO1xuICAgIHJldHVybiBQcmVjb25maWd1cmVkVnVlO1xufSgpKTtcbmV4cG9ydHMuZGVmYXVsdCA9IFByZWNvbmZpZ3VyZWRWdWU7XG4iLCJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBBamF4UmVzcG9uc2VEdG9fMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwiLi4vLi4vanMvY29yZS9kdG8vQWpheFJlc3BvbnNlRHRvXCIpKTtcbnZhciBBamF4Q29udGVudExvYWRfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwiLi4vLi4vanMvY29yZS9BamF4L0FqYXhDb250ZW50TG9hZFwiKSk7XG52YXIgUHJlY29uZmlndXJlZFZ1ZV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCIuLi9QcmVjb25maWd1cmVkVnVlXCIpKTtcbnZhciBheGlvc18xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJheGlvc1wiKSk7XG5QcmVjb25maWd1cmVkVnVlXzEuZGVmYXVsdC5jcmVhdGVBcHAoJyNzaWRlYmFyLW1lbnUnLCB7XG4gICAgbWV0aG9kczoge1xuICAgICAgICAvKipcbiAgICAgICAgICogQGRlc2NyaXB0aW9uIHdpbGwgbG9hZCBwYWdlIGNvbnRlbnRcbiAgICAgICAgICovXG4gICAgICAgIGxvYWRQYWdlQ29udGVudDogZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICB2YXIgdXJsID0gZXZlbnQuY3VycmVudFRhcmdldC5kYXRhc2V0LmFqYXhIcmVmO1xuICAgICAgICAgICAgYXhpb3NfMS5kZWZhdWx0LmRlZmF1bHRzLmhlYWRlcnMuY29tbW9uWydYLVJlcXVlc3RlZC1XaXRoJ10gPSAnWE1MSHR0cFJlcXVlc3QnOyAvLyB0aGlzIG1ha2VzIHN5bWZvbnkgdGhpbmsgdGhhdCB0aGlzIGlzIGFqYXggcmVxdWVzdFxuICAgICAgICAgICAgYXhpb3NfMS5kZWZhdWx0LmdldCh1cmwpLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgdmFyIGFqYXhSZXNwb25zZUR0byA9IEFqYXhSZXNwb25zZUR0b18xLmRlZmF1bHQuZnJvbUF4aW9zUmVzcG9uc2UocmVzcG9uc2UuZGF0YSk7XG4gICAgICAgICAgICAgICAgQWpheENvbnRlbnRMb2FkXzEuZGVmYXVsdC5sb2FkQ29udGVudEludG9NYWluV3JhcHBlcihhamF4UmVzcG9uc2VEdG8udGVtcGxhdGUpO1xuICAgICAgICAgICAgICAgIEFqYXhDb250ZW50TG9hZF8xLmRlZmF1bHQuYXBwZW5kQW5kRXhlY3V0ZVNjcmlwdHNJbnRvTWFpbldyYXBwZXIoYWpheFJlc3BvbnNlRHRvLnNjcmlwdHNTb3VyY2VzKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfSxcbn0pO1xuZXhwb3J0cy5kZWZhdWx0ID0ge307XG4iLCJpbXBvcnQgc2NyaXB0IGZyb20gXCIuL3NpZGViYXIudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPXRzXCJcbmV4cG9ydCAqIGZyb20gXCIuL3NpZGViYXIudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPXRzXCJcbi8qIGhvdCByZWxvYWQgKi9cbmlmIChtb2R1bGUuaG90KSB7XG4gIHNjcmlwdC5fX2htcklkID0gXCIxYmYxNDEwYVwiXG4gIGNvbnN0IGFwaSA9IF9fVlVFX0hNUl9SVU5USU1FX19cbiAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICBpZiAoIWFwaS5jcmVhdGVSZWNvcmQoJzFiZjE0MTBhJywgc2NyaXB0KSkge1xuICAgIGFwaS5yZWxvYWQoJzFiZjE0MTBhJywgc2NyaXB0KVxuICB9XG4gIFxufVxuXG5zY3JpcHQuX19maWxlID0gXCJhc3NldHMvdnVlL3BhZ2UtZWxlbWVudHMvc2lkZWJhci52dWVcIlxuXG5leHBvcnQgZGVmYXVsdCBzY3JpcHQiLCJleHBvcnQgeyBkZWZhdWx0IH0gZnJvbSBcIi0hLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2JhYmVsLWxvYWRlci9saWIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzBdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy90cy1sb2FkZXIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzFdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2Rpc3QvaW5kZXguanM/P3J1bGVTZXRbMF0udXNlWzBdIS4vc2lkZWJhci52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9dHNcIjsgZXhwb3J0ICogZnJvbSBcIi0hLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2JhYmVsLWxvYWRlci9saWIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzBdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy90cy1sb2FkZXIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzFdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2Rpc3QvaW5kZXguanM/P3J1bGVTZXRbMF0udXNlWzBdIS4vc2lkZWJhci52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9dHNcIiJdLCJzb3VyY2VSb290IjoiIn0=