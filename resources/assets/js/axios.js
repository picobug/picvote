// Copyright (c) 2017 Julian Prasetyo <picobug.jp@gmail.com>
//
// This software is released under the MIT License.
// https://opensource.org/licenses/MIT
import axios from "axios";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}
export default axios;
