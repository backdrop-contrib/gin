!function(t){function e(n){if(o[n])return o[n].exports;var a=o[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var o={};e.m=t,e.c=o,e.d=function(t,o,n){e.o(t,o)||Object.defineProperty(t,o,{enumerable:!0,get:n})},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},e.t=function(t,o){if(1&o&&(t=e(t)),8&o)return t;if(4&o&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(e.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&o&&"string"!=typeof t)for(var a in t)e.d(n,a,function(e){return t[e]}.bind(null,a));return n},e.n=function(t){var o=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(o,"a",o),o},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=19)}({19:function(t,e,o){o(20),t.exports=o(21)},20:function(){var t,e;t=jQuery,e=Drupal,drupalSettings,e.behaviors.ginToolbarActiveItem={attach:function(e,o){var n=o.path.currentPath;-1<n.indexOf("admin/content")||-1<n.indexOf("/edit")?t(".toolbar-icon-system-admin-content").addClass("is-active"):-1<n.indexOf("admin/structure")?t(".toolbar-icon-system-admin-structure").addClass("is-active"):-1<n.indexOf("admin/appearance")||-1<n.indexOf("admin/theme")?t(".toolbar-icon-system-themes-page").addClass("is-active"):-1<n.indexOf("admin/modules")?t(".toolbar-icon-system-modules-list").addClass("is-active"):-1<n.indexOf("admin/config")?t(".toolbar-icon-system-admin-config").addClass("is-active"):-1<n.indexOf("admin/people")?t(".toolbar-icon-entity-user-collection").addClass("is-active"):-1<n.indexOf("admin/reports")?t(".toolbar-icon-system-admin-reports").addClass("is-active"):-1<n.indexOf("admin/help")&&t(".toolbar-icon-help-main").addClass("is-active")}},e.behaviors.ginToolbarToggle={attach:function(e){t("#toolbar-bar .toolbar-item",e).on("click",(function(){t("body").attr("data-toolbar-tray",t(this).data("toolbar-tray")),t(document).ready((function(){t(".sticky-header").each((function(){t(this).width(t(".sticky-table").width())}))}))})),t(".toolbar-menu__trigger",e).on("click",(function(e){e.preventDefault(),t(this).toggleClass("is-active"),t(this).hasClass("is-active")?t("body").attr("data-toolbar-menu","open"):t("body").attr("data-toolbar-menu","")}))}},e.behaviors.ginScroll={attach:function(){var e=t(window).scrollTop(),o="-has-scrolled";e>40?t("body").addClass(o):t("body").removeClass(o),t(window).scroll((function(){t(window).scrollTop()>40?t("body").addClass(o):t("body").removeClass(o)}))}}},21:function(){}});