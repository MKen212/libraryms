"use strict";
/* global */
/* eslint-disable no-unused-vars */

/**
 * Register Check
 * @fileoverview Checks Registration credentials have been submitted correctly
 * @return True if Function success
 */
function registerCheck() {
  let form = document.registrationForm;
  let emailformat = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (form.lmsUsername.value == "") {
    alert("Enter a User Name.");
    return false;
  } else if (form.lmsPassword.value == "") {
    alert("Enter a Password.");
    return false;
  } else if(form.lmsPassword.value.length < 5) {
    alert("Password must be 5 characters or more in length.");
    return false;
  } else if (form.lmsFirstName.value == "") {
    alert("Enter a First Name.");
    return false;
  } else if (form.lmsLastName.value == "") {
    alert("Enter a Last Name.");
    return false;
  } else if (form.lmsEmail.value == "") {
    alert("Enter an Email Address.");
    return false;
  } else if (!form.lmsEmail.value.match(emailformat)) {
    alert("Email Address format is invalid.");
  } else if (form.lmsContactNo.value == "") {
    alert("Enter a Contact Number.");
    return false;
  } else {
    return true;
  }
}