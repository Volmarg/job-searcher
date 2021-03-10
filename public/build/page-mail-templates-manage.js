(self["webpackChunkjob_searcher"] = self["webpackChunkjob_searcher"] || []).push([["page-mail-templates-manage"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts":
/*!*******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts ***!
  \*******************************************************************************************************************************************************************************************************************************************************************/
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

var PreconfiguredVue_1 = __importDefault(__webpack_require__(/*! ../../../PreconfiguredVue */ "./assets/vue/PreconfiguredVue.ts"));

PreconfiguredVue_1["default"].createApp('#mail-template-manage', {
  data: function data() {},
  methods: {
    testLog: function testLog() {
      console.log("test");
    }
  },
  mounted: function mounted() {
    console.log(this.$refs.saveTemplateButton);
  }
});
exports.default = {};

/***/ }),

/***/ "./assets/vue/pages/mail/template/manage.vue":
/*!***************************************************!*\
  !*** ./assets/vue/pages/mail/template/manage.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./manage.vue?vue&type=script&lang=ts */ "./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts");
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);


/* hot reload */
if (false) {}

_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__.default.__file = "assets/vue/pages/mail/template/manage.vue"

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__.default);

/***/ }),

/***/ "./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts":
/*!***************************************************************************!*\
  !*** ./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport default from dynamic */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0___default.a)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!../../../../../node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./manage.vue?vue&type=script&lang=ts */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-14.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-14.use[1]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./assets/vue/pages/mail/template/manage.vue?vue&type=script&lang=ts");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _node_modules_babel_loader_lib_index_js_clonedRuleSet_14_use_0_node_modules_ts_loader_index_js_clonedRuleSet_14_use_1_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_manage_vue_vue_type_script_lang_ts__WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
 

/***/ })

},
0,[["./assets/vue/pages/mail/template/manage.vue","runtime","vendors"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9qb2Itc2VhcmNoZXIvLi9hc3NldHMvdnVlL1ByZWNvbmZpZ3VyZWRWdWUudHMiLCJ3ZWJwYWNrOi8vam9iLXNlYXJjaGVyLy4vYXNzZXRzL3Z1ZS9wYWdlcy9tYWlsL3RlbXBsYXRlL21hbmFnZS52dWUiLCJ3ZWJwYWNrOi8vam9iLXNlYXJjaGVyLy4vYXNzZXRzL3Z1ZS9wYWdlcy9tYWlsL3RlbXBsYXRlL21hbmFnZS52dWU/YmMxMyIsIndlYnBhY2s6Ly9qb2Itc2VhcmNoZXIvLi9hc3NldHMvdnVlL3BhZ2VzL21haWwvdGVtcGxhdGUvbWFuYWdlLnZ1ZT9kMmIzIl0sIm5hbWVzIjpbIl9fY3JlYXRlQmluZGluZyIsIk9iamVjdCIsImNyZWF0ZSIsIm8iLCJtIiwiayIsImsyIiwidW5kZWZpbmVkIiwiZGVmaW5lUHJvcGVydHkiLCJlbnVtZXJhYmxlIiwiZ2V0IiwiX19zZXRNb2R1bGVEZWZhdWx0IiwidiIsInZhbHVlIiwiX19pbXBvcnRTdGFyIiwibW9kIiwiX19lc01vZHVsZSIsInJlc3VsdCIsInByb3RvdHlwZSIsImhhc093blByb3BlcnR5IiwiY2FsbCIsInZ1ZSIsInJlcXVpcmUiLCJQcmVjb25maWd1cmVkVnVlIiwiY3JlYXRlQXBwIiwiZG9tRWxlbWVudFNlbGVjdG9yIiwib3B0aW9ucyIsImRlbGltaXRlcnMiLCJWVUVfREVGQVVMVF9ERUxJTUlURVJTIiwibW91bnQiLCJleHBvcnRzIiwiX19pbXBvcnREZWZhdWx0IiwiUHJlY29uZmlndXJlZFZ1ZV8xIiwiZGF0YSIsIm1ldGhvZHMiLCJ0ZXN0TG9nIiwiY29uc29sZSIsImxvZyIsIm1vdW50ZWQiLCIkcmVmcyIsInNhdmVUZW1wbGF0ZUJ1dHRvbiJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQWE7Ozs7OztBQUNiLElBQUlBLGVBQWUsR0FBSSxRQUFRLEtBQUtBLGVBQWQsS0FBbUNDLE1BQU0sQ0FBQ0MsTUFBUCxHQUFpQixVQUFTQyxDQUFULEVBQVlDLENBQVosRUFB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VUFBWixHQUEwQkQsR0FBMUIsR0FBZ0M7QUFBRSxlQUFXQTtBQUFiLEdBQXZDO0FBQ0gsQ0FGRDs7QUFHQWQsOENBQTZDO0FBQUVZLE9BQUssRUFBRTtBQUFULENBQTdDOztBQUNBLElBQUltQixrQkFBa0IsR0FBR0QsZUFBZSxDQUFDVCxtQkFBTyxDQUFDLG1FQUFELENBQVIsQ0FBeEM7O0FBQ0FVLGtCQUFrQixXQUFsQixDQUEyQlIsU0FBM0IsQ0FBcUMsdUJBQXJDLEVBQThEO0FBQzFEUyxNQUFJLEVBQUUsZ0JBQVksQ0FDakIsQ0FGeUQ7QUFHMURDLFNBQU8sRUFBRTtBQUNMQyxXQUFPLEVBQUUsbUJBQVk7QUFDakJDLGFBQU8sQ0FBQ0MsR0FBUixDQUFZLE1BQVo7QUFDSDtBQUhJLEdBSGlEO0FBUTFEQyxTQUFPLEVBQUUsbUJBQVk7QUFDakJGLFdBQU8sQ0FBQ0MsR0FBUixDQUFZLEtBQUtFLEtBQUwsQ0FBV0Msa0JBQXZCO0FBQ0g7QUFWeUQsQ0FBOUQ7QUFZQVYsZUFBQSxHQUFrQixFQUFsQixDOzs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEJ5RDtBQUNMO0FBQ3BEO0FBQ0EsSUFBSSxLQUFVLEVBQUUsRUFRZjs7QUFFRCwrRUFBYTs7QUFFYixpRUFBZSx3RTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNmaVIsQyIsImZpbGUiOiJwYWdlLW1haWwtdGVtcGxhdGVzLW1hbmFnZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9fY3JlYXRlQmluZGluZyA9ICh0aGlzICYmIHRoaXMuX19jcmVhdGVCaW5kaW5nKSB8fCAoT2JqZWN0LmNyZWF0ZSA/IChmdW5jdGlvbihvLCBtLCBrLCBrMikge1xuICAgIGlmIChrMiA9PT0gdW5kZWZpbmVkKSBrMiA9IGs7XG4gICAgT2JqZWN0LmRlZmluZVByb3BlcnR5KG8sIGsyLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZnVuY3Rpb24oKSB7IHJldHVybiBtW2tdOyB9IH0pO1xufSkgOiAoZnVuY3Rpb24obywgbSwgaywgazIpIHtcbiAgICBpZiAoazIgPT09IHVuZGVmaW5lZCkgazIgPSBrO1xuICAgIG9bazJdID0gbVtrXTtcbn0pKTtcbnZhciBfX3NldE1vZHVsZURlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9fc2V0TW9kdWxlRGVmYXVsdCkgfHwgKE9iamVjdC5jcmVhdGUgPyAoZnVuY3Rpb24obywgdikge1xuICAgIE9iamVjdC5kZWZpbmVQcm9wZXJ0eShvLCBcImRlZmF1bHRcIiwgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdiB9KTtcbn0pIDogZnVuY3Rpb24obywgdikge1xuICAgIG9bXCJkZWZhdWx0XCJdID0gdjtcbn0pO1xudmFyIF9faW1wb3J0U3RhciA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnRTdGFyKSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgaWYgKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgcmV0dXJuIG1vZDtcbiAgICB2YXIgcmVzdWx0ID0ge307XG4gICAgaWYgKG1vZCAhPSBudWxsKSBmb3IgKHZhciBrIGluIG1vZCkgaWYgKGsgIT09IFwiZGVmYXVsdFwiICYmIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChtb2QsIGspKSBfX2NyZWF0ZUJpbmRpbmcocmVzdWx0LCBtb2QsIGspO1xuICAgIF9fc2V0TW9kdWxlRGVmYXVsdChyZXN1bHQsIG1vZCk7XG4gICAgcmV0dXJuIHJlc3VsdDtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIgdnVlID0gX19pbXBvcnRTdGFyKHJlcXVpcmUoXCJ2dWVcIikpO1xudmFyIFByZWNvbmZpZ3VyZWRWdWUgPSAvKiogQGNsYXNzICovIChmdW5jdGlvbiAoKSB7XG4gICAgZnVuY3Rpb24gUHJlY29uZmlndXJlZFZ1ZSgpIHtcbiAgICB9XG4gICAgLyoqXG4gICAgICogQGRlc2NyaXB0aW9uIGNyZWF0ZXMgdnVlIGluc3RhbmNlIGZvciBkb20gZWxlbWVudCBidXQgdXNlcyBwcmVjb25maWd1cmVkIHZ1ZSB3aXRoIGNvbW1vbiByZXVzYWJsZSBsb2dpYyxcbiAgICAgKiAgICAgICAgICAgICAgdGhpcyBwcm92aWRlcyB0aGUgc2FtZSBvdXRwdXQgYXMgY3JlYXRpbmcgU1BBIHdpdGggdnVlIGluIHJvb3Qgc3VjaCBhcyBib2R5XG4gICAgICpcbiAgICAgKiBAcGFyYW0gZG9tRWxlbWVudFNlbGVjdG9yXG4gICAgICogQHBhcmFtIG9wdGlvbnNcbiAgICAgKi9cbiAgICBQcmVjb25maWd1cmVkVnVlLmNyZWF0ZUFwcCA9IGZ1bmN0aW9uIChkb21FbGVtZW50U2VsZWN0b3IsIG9wdGlvbnMpIHtcbiAgICAgICAgLy9AdHMtaWdub3JlXG4gICAgICAgIG9wdGlvbnMuZGVsaW1pdGVycyA9IFByZWNvbmZpZ3VyZWRWdWUuVlVFX0RFRkFVTFRfREVMSU1JVEVSUztcbiAgICAgICAgdnVlLmNyZWF0ZUFwcChvcHRpb25zKS5tb3VudChkb21FbGVtZW50U2VsZWN0b3IpO1xuICAgIH07XG4gICAgLyoqXG4gICAgICogQGRlc2NyaXB0aW9uIGRlbGltaXRlcnMgdXNlZCB0byB0cmFuc2xhdGUgdnVlIGxvZ2ljLCByZXF1aXJlZCBzaW5jZSB0d2lnIHV0aWxpemVzIHRoZSBge3sgfX1gXG4gICAgICovXG4gICAgUHJlY29uZmlndXJlZFZ1ZS5WVUVfREVGQVVMVF9ERUxJTUlURVJTID0gW1wiW1tcIiwgXCJdXVwiXTtcbiAgICByZXR1cm4gUHJlY29uZmlndXJlZFZ1ZTtcbn0oKSk7XG5leHBvcnRzLmRlZmF1bHQgPSBQcmVjb25maWd1cmVkVnVlO1xuIiwiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIgUHJlY29uZmlndXJlZFZ1ZV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCIuLi8uLi8uLi9QcmVjb25maWd1cmVkVnVlXCIpKTtcblByZWNvbmZpZ3VyZWRWdWVfMS5kZWZhdWx0LmNyZWF0ZUFwcCgnI21haWwtdGVtcGxhdGUtbWFuYWdlJywge1xuICAgIGRhdGE6IGZ1bmN0aW9uICgpIHtcbiAgICB9LFxuICAgIG1ldGhvZHM6IHtcbiAgICAgICAgdGVzdExvZzogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coXCJ0ZXN0XCIpO1xuICAgICAgICB9XG4gICAgfSxcbiAgICBtb3VudGVkOiBmdW5jdGlvbiAoKSB7XG4gICAgICAgIGNvbnNvbGUubG9nKHRoaXMuJHJlZnMuc2F2ZVRlbXBsYXRlQnV0dG9uKTtcbiAgICB9XG59KTtcbmV4cG9ydHMuZGVmYXVsdCA9IHt9O1xuIiwiaW1wb3J0IHNjcmlwdCBmcm9tIFwiLi9tYW5hZ2UudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPXRzXCJcbmV4cG9ydCAqIGZyb20gXCIuL21hbmFnZS52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9dHNcIlxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHtcbiAgc2NyaXB0Ll9faG1ySWQgPSBcIjY1YzczMzc4XCJcbiAgY29uc3QgYXBpID0gX19WVUVfSE1SX1JVTlRJTUVfX1xuICBtb2R1bGUuaG90LmFjY2VwdCgpXG4gIGlmICghYXBpLmNyZWF0ZVJlY29yZCgnNjVjNzMzNzgnLCBzY3JpcHQpKSB7XG4gICAgYXBpLnJlbG9hZCgnNjVjNzMzNzgnLCBzY3JpcHQpXG4gIH1cbiAgXG59XG5cbnNjcmlwdC5fX2ZpbGUgPSBcImFzc2V0cy92dWUvcGFnZXMvbWFpbC90ZW1wbGF0ZS9tYW5hZ2UudnVlXCJcblxuZXhwb3J0IGRlZmF1bHQgc2NyaXB0IiwiZXhwb3J0IHsgZGVmYXVsdCB9IGZyb20gXCItIS4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy9iYWJlbC1sb2FkZXIvbGliL2luZGV4LmpzPz9jbG9uZWRSdWxlU2V0LTE0LnVzZVswXSEuLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdHMtbG9hZGVyL2luZGV4LmpzPz9jbG9uZWRSdWxlU2V0LTE0LnVzZVsxXSEuLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9kaXN0L2luZGV4LmpzPz9ydWxlU2V0WzBdLnVzZVswXSEuL21hbmFnZS52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9dHNcIjsgZXhwb3J0ICogZnJvbSBcIi0hLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2JhYmVsLWxvYWRlci9saWIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzBdIS4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy90cy1sb2FkZXIvaW5kZXguanM/P2Nsb25lZFJ1bGVTZXQtMTQudXNlWzFdIS4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2Rpc3QvaW5kZXguanM/P3J1bGVTZXRbMF0udXNlWzBdIS4vbWFuYWdlLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz10c1wiIl0sInNvdXJjZVJvb3QiOiIifQ==