/*! grapesjs-pd-base - 0.0.508 */
!function(n,s){"object"==typeof exports&&"object"==typeof module?module.exports=s():"function"==typeof define&&define.amd?define([],s):"object"==typeof exports?exports["grapesjs-pd-base"]=s():n["grapesjs-pd-base"]=s()}(window,function(){return function(n){var s={};function e(o){if(s[o])return s[o].exports;var t=s[o]={i:o,l:!1,exports:{}};return n[o].call(t.exports,t,t.exports,e),t.l=!0,t.exports}return e.m=n,e.c=s,e.d=function(n,s,o){e.o(n,s)||Object.defineProperty(n,s,{enumerable:!0,get:o})},e.r=function(n){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},e.t=function(n,s){if(1&s&&(n=e(n)),8&s)return n;if(4&s&&"object"==typeof n&&n&&n.__esModule)return n;var o=Object.create(null);if(e.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:n}),2&s&&"string"!=typeof n)for(var t in n)e.d(o,t,function(s){return n[s]}.bind(null,t));return o},e.n=function(n){var s=n&&n.__esModule?function(){return n.default}:function(){return n};return e.d(s,"a",s),s},e.o=function(n,s){return Object.prototype.hasOwnProperty.call(n,s)},e.p="",e(e.s=3)}([function(n,s,e){"use strict";n.exports=function(n){var s=[];return s.toString=function(){return this.map(function(s){var e=function(n,s){var e=n[1]||"",o=n[3];if(!o)return e;if(s&&"function"==typeof btoa){var t=function(n){return"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(n))))+" */"}(o),r=o.sources.map(function(n){return"/*# sourceURL="+o.sourceRoot+n+" */"});return[e].concat(r).concat([t]).join("\n")}return[e].join("\n")}(s,n);return s[2]?"@media "+s[2]+"{"+e+"}":e}).join("")},s.i=function(n,e){"string"==typeof n&&(n=[[null,n,""]]);for(var o={},t=0;t<this.length;t++){var r=this[t][0];null!=r&&(o[r]=!0)}for(t=0;t<n.length;t++){var i=n[t];null!=i[0]&&o[i[0]]||(e&&!i[2]?i[2]=e:e&&(i[2]="("+i[2]+") and ("+e+")"),s.push(i))}},s}},function(n,s,e){var o={},t=function(n){var s;return function(){return void 0===s&&(s=n.apply(this,arguments)),s}}(function(){return window&&document&&document.all&&!window.atob}),r=function(n){var s={};return function(n,e){if("function"==typeof n)return n();if(void 0===s[n]){var o=function(n,s){return s?s.querySelector(n):document.querySelector(n)}.call(this,n,e);if(window.HTMLIFrameElement&&o instanceof window.HTMLIFrameElement)try{o=o.contentDocument.head}catch(n){o=null}s[n]=o}return s[n]}}(),i=null,g=0,a=[],l=e(7);function c(n,s){for(var e=0;e<n.length;e++){var t=n[e],r=o[t.id];if(r){r.refs++;for(var i=0;i<r.parts.length;i++)r.parts[i](t.parts[i]);for(;i<t.parts.length;i++)r.parts.push(f(t.parts[i],s))}else{var g=[];for(i=0;i<t.parts.length;i++)g.push(f(t.parts[i],s));o[t.id]={id:t.id,refs:1,parts:g}}}}function p(n,s){for(var e=[],o={},t=0;t<n.length;t++){var r=n[t],i=s.base?r[0]+s.base:r[0],g={css:r[1],media:r[2],sourceMap:r[3]};o[i]?o[i].parts.push(g):e.push(o[i]={id:i,parts:[g]})}return e}function d(n,s){var e=r(n.insertInto);if(!e)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var o=a[a.length-1];if("top"===n.insertAt)o?o.nextSibling?e.insertBefore(s,o.nextSibling):e.appendChild(s):e.insertBefore(s,e.firstChild),a.push(s);else if("bottom"===n.insertAt)e.appendChild(s);else{if("object"!=typeof n.insertAt||!n.insertAt.before)throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var t=r(n.insertAt.before,e);e.insertBefore(s,t)}}function m(n){if(null===n.parentNode)return!1;n.parentNode.removeChild(n);var s=a.indexOf(n);s>=0&&a.splice(s,1)}function j(n){var s=document.createElement("style");if(void 0===n.attrs.type&&(n.attrs.type="text/css"),void 0===n.attrs.nonce){var o=function(){0;return e.nc}();o&&(n.attrs.nonce=o)}return b(s,n.attrs),d(n,s),s}function b(n,s){Object.keys(s).forEach(function(e){n.setAttribute(e,s[e])})}function f(n,s){var e,o,t,r;if(s.transform&&n.css){if(!(r="function"==typeof s.transform?s.transform(n.css):s.transform.default(n.css)))return function(){};n.css=r}if(s.singleton){var a=g++;e=i||(i=j(s)),o=u.bind(null,e,a,!1),t=u.bind(null,e,a,!0)}else n.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(e=function(n){var s=document.createElement("link");return void 0===n.attrs.type&&(n.attrs.type="text/css"),n.attrs.rel="stylesheet",b(s,n.attrs),d(n,s),s}(s),o=function(n,s,e){var o=e.css,t=e.sourceMap,r=void 0===s.convertToAbsoluteUrls&&t;(s.convertToAbsoluteUrls||r)&&(o=l(o));t&&(o+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(t))))+" */");var i=new Blob([o],{type:"text/css"}),g=n.href;n.href=URL.createObjectURL(i),g&&URL.revokeObjectURL(g)}.bind(null,e,s),t=function(){m(e),e.href&&URL.revokeObjectURL(e.href)}):(e=j(s),o=function(n,s){var e=s.css,o=s.media;o&&n.setAttribute("media",o);if(n.styleSheet)n.styleSheet.cssText=e;else{for(;n.firstChild;)n.removeChild(n.firstChild);n.appendChild(document.createTextNode(e))}}.bind(null,e),t=function(){m(e)});return o(n),function(s){if(s){if(s.css===n.css&&s.media===n.media&&s.sourceMap===n.sourceMap)return;o(n=s)}else t()}}n.exports=function(n,s){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");(s=s||{}).attrs="object"==typeof s.attrs?s.attrs:{},s.singleton||"boolean"==typeof s.singleton||(s.singleton=t()),s.insertInto||(s.insertInto="head"),s.insertAt||(s.insertAt="bottom");var e=p(n,s);return c(e,s),function(n){for(var t=[],r=0;r<e.length;r++){var i=e[r];(g=o[i.id]).refs--,t.push(g)}n&&c(p(n,s),s);for(r=0;r<t.length;r++){var g;if(0===(g=t[r]).refs){for(var a=0;a<g.parts.length;a++)g.parts[a]();delete o[g.id]}}}};var A=function(){var n=[];return function(s,e){return n[s]=e,n.filter(Boolean).join("\n")}}();function u(n,s,e,o){var t=e?"":o.css;if(n.styleSheet)n.styleSheet.cssText=A(s,t);else{var r=document.createTextNode(t),i=n.childNodes;i[s]&&n.removeChild(i[s]),i.length?n.insertBefore(r,i[s]):n.appendChild(r)}}},function(n,s,e){var o=e(4);n.exports=function(n){for(var s=1;s<arguments.length;s++){var e=null!=arguments[s]?arguments[s]:{},t=Object.keys(e);"function"==typeof Object.getOwnPropertySymbols&&(t=t.concat(Object.getOwnPropertySymbols(e).filter(function(n){return Object.getOwnPropertyDescriptor(e,n).enumerable}))),t.forEach(function(s){o(n,s,e[s])})}return n}},function(n,s,e){"use strict";e.r(s);var o=e(2),t=e.n(o);e(5),e(8);s.default=function(n){var s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},e=t()({},{},s);jQuery(document).trigger("pagedesigner-before-init",[n,e]),jQuery(document).trigger("pagedesigner-init-default-trait",[n,e]),jQuery(document).trigger("pagedesigner-init-traits",[n,e]),jQuery(document).trigger("pagedesigner-init-base-components",[n,e]),jQuery(document).trigger("pagedesigner-init-components",[n,e]),jQuery(document).trigger("pagedesigner-init-base-blocks",[n,e]),jQuery(document).trigger("pagedesigner-init-blocks",[n,e]),jQuery(document).trigger("pagedesigner-init-base-commands",[n,e]),jQuery(document).trigger("pagedesigner-init-commands",[n,e]),jQuery(document).trigger("pagedesigner-init-base-panels",[n,e]),jQuery(document).trigger("pagedesigner-init-panels",[n,e]),jQuery(document).trigger("pagedesigner-init-events",[n,e])}},function(n,s){n.exports=function(n,s,e){return s in n?Object.defineProperty(n,s,{value:e,enumerable:!0,configurable:!0,writable:!0}):n[s]=e,n}},function(n,s,e){var o=e(6);"string"==typeof o&&(o=[[n.i,o,""]]);var t={hmr:!0,transform:void 0,insertInto:void 0};e(1)(o,t);o.locals&&(n.exports=o.locals)},function(n,s,e){(n.exports=e(0)(!1)).push(
    [n.i,"",""])},function(n,s){n.exports=function(n){var s="undefined"!=typeof window&&window.location;if(!s)throw new Error("fixUrls requires window.location");if(!n||"string"!=typeof n)return n;var e=s.protocol+"//"+s.host,o=e+s.pathname.replace(/\/[^\/]*$/,"/");return n.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,function(n,s){var t,r=s.trim().replace(/^"(.*)"$/,function(n,s){return s}).replace(/^'(.*)'$/,function(n,s){return s});return/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(r)?n:(t=0===r.indexOf("//")?r:0===r.indexOf("/")?e+r:o+r.replace(/^\.\//,""),"url("+JSON.stringify(t)+")")})}},function(n,s,e){var o=e(9);"string"==typeof o&&(o=[[n.i,o,""]]);var t={hmr:!0,transform:void 0,insertInto:void 0};e(1)(o,t);o.locals&&(n.exports=o.locals)},function(n,s,e){(n.exports=e(0)(!1)).push([n.i,'',""])}])});
//# sourceMappingURL=grapesjs-pd-base.min.js.map
