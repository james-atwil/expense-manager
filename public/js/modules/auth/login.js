"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/modules/auth/login"],{

/***/ "./resources/js/modules/auth/login.js":
/*!********************************************!*\
  !*** ./resources/js/modules/auth/login.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var yup__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! yup */ "./node_modules/yup/es/index.js");



var LoginComponent = {
  components: {
    VForm: vee_validate__WEBPACK_IMPORTED_MODULE_2__.Form,
    VField: vee_validate__WEBPACK_IMPORTED_MODULE_2__.Field,
    ErrorMessage: vee_validate__WEBPACK_IMPORTED_MODULE_2__.ErrorMessage
  },
  data: function data() {
    var schema = yup__WEBPACK_IMPORTED_MODULE_1__.object({
      username: yup__WEBPACK_IMPORTED_MODULE_1__.string().required(),
      password: yup__WEBPACK_IMPORTED_MODULE_1__.string().required()
    });
    return {
      url: {
        path: '/login'
      },
      success: false,
      invalid: false,
      schema: schema,
      login: {
        username: '',
        password: '',
        redirect: '',
        remember: 0
      }
    };
  },
  methods: {
    dismiss: function dismiss() {
      var _this = this;

      setTimeout(function () {
        _this.invalid = false;
      }, 3000);
    },
    submit: function submit() {
      var that = this;
      axios({
        method: 'POST',
        url: that.url.path,
        data: that.login
      }).then(function (response) {
        if (response.data.result) {
          that.success = true;
          window.location = response.data.redirect;
        } else {
          that.invalid = true;
          that.dismiss();
        }
      });
    }
  }
};
var app = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createApp)(LoginComponent);
app.mount('#module');

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/js/modules/auth/login.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);