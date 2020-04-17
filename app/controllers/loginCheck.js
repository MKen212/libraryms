"use strict";
/* global */
/* eslint-disable no-unused-vars */

/**
 * Login Check
 * @fileoverview Checks Login credentials have been submitted correctly
 * @return True if Function success
 */
function loginCheck() {
  let form = document.loginForm;
  if (form.lmsUsername.value == "") {
    alert("Enter a User Name.");
    return false;
  } else if (form.lmsPassword.value == "") {
    alert("Enter a Password.");
    return false;
  } else {
    return true;
  }
}