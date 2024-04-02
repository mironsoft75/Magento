// first second way  use of js
// define(["jquery", "domReady!","custom_script"], function($,dom,custom_script){

//     alert("Add Custom Js");
// })


// this is third way of use js

// require(
//     [
//         "jquery",
//     ],
//     function($){
//     alert("Add Custom Js");
// })


// this fourth way  use of js

define([
    'jquery',
    'domReady',
], function ($,dom) {
    'use strict';
    return function(config) {
       console.log(config);
       console.log(config.slidername);
       console.log(config.slideritems);
    }
});