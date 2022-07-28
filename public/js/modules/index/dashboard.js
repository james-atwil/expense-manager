"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/modules/index/dashboard"],{

/***/ "./resources/js/modules/index/dashboard.js":
/*!*************************************************!*\
  !*** ./resources/js/modules/index/dashboard.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var vue3_apexcharts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue3-apexcharts */ "./node_modules/vue3-apexcharts/dist/vue3-apexcharts.common.js");
/* harmony import */ var vue3_apexcharts__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue3_apexcharts__WEBPACK_IMPORTED_MODULE_1__);


var DashboardComponent = {
  components: {
    apexchart: (vue3_apexcharts__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      loading: true,
      tabularData: [],
      series: [],
      chartOptions: {
        chart: {
          type: 'pie'
        },
        labels: [],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      }
    };
  },
  methods: {},
  mounted: function mounted() {
    var that = this;
    var config = {
      method: 'GET',
      url: '/rest/dashboard'
    };
    var result = axios(config);
    result.then(function (data) {
      that.series = data.data.chart01.series;
      that.chartOptions = {
        labels: data.data.chart01.labels
      };
      that.tabularData = data.data.table01;
      that.loading = false;
    });
  }
};
var app = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createApp)(DashboardComponent);
app.mount('#content');

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/js/modules/index/dashboard.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);