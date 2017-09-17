// Copyright (c) 2017 Julian Prasetyo <picobug.jp@gmail.com>
//
// This software is released under the MIT License.
// https://opensource.org/licenses/MIT
window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("vote", require("./components/Vote.vue"));

const app = new Vue({
  el: "#app"
});
