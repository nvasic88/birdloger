(window.webpackJsonp=window.webpackJsonp||[]).push([[20],{"0JjW":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.guardAgainstReservedFieldName=function(t){if(-1!==r.indexOf(t))throw new Error("Field name "+t+" isn't allowed to be used in a Form or Errors instance.")};var r=e.reservedFieldNames=["__http","__options","__validateRequestType","clear","data","delete","errors","getError","getErrors","hasError","initial","onFail","only","onSuccess","patch","populate","post","processing","successful","put","reset","submit","withData","withErrors","withOptions"]},"44Ds":function(t,e,n){var r=n("e4Nc"),i="Expected a function";function o(t,e){if("function"!=typeof t||null!=e&&"function"!=typeof e)throw new TypeError(i);var n=function(){var r=arguments,i=e?e.apply(this,r):r[0],o=n.cache;if(o.has(i))return o.get(i);var s=t.apply(this,r);return n.cache=o.set(i,s)||o,s};return n.cache=new(o.Cache||r),n}o.Cache=r,t.exports=o},"4uTw":function(t,e,n){var r=n("Z0cm"),i=n("9ggG"),o=n("GNiM"),s=n("dt0z");t.exports=function(t,e){return r(t)?t:i(t,e)?[t]:o(s(t))}},"5YJQ":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("eXgj");Object.defineProperty(e,"default",{enumerable:!0,get:function(){return o(r).default}}),Object.defineProperty(e,"Form",{enumerable:!0,get:function(){return o(r).default}});var i=n("ukZA");function o(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"Errors",{enumerable:!0,get:function(){return o(i).default}})},"9Nap":function(t,e,n){var r=n("/9aa"),i=1/0;t.exports=function(t){if("string"==typeof t||r(t))return t;var e=t+"";return"0"==e&&1/t==-i?"-0":e}},"9ggG":function(t,e,n){var r=n("Z0cm"),i=n("/9aa"),o=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,s=/^\w*$/;t.exports=function(t,e){if(r(t))return!1;var n=typeof t;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=t&&!i(t))||(s.test(t)||!o.test(t)||null!=e&&t in Object(e))}},GNiM:function(t,e,n){var r=n("I01J"),i=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,o=/\\(\\)?/g,s=r(function(t){var e=[];return 46===t.charCodeAt(0)&&e.push(""),t.replace(i,function(t,n,r,i){e.push(r?i.replace(o,"$1"):n||t)}),e});t.exports=s},I01J:function(t,e,n){var r=n("44Ds"),i=500;t.exports=function(t){var e=r(t,function(t){return n.size===i&&n.clear(),t}),n=e.cache;return e}},WfdN:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};function i(t){return t instanceof File||t instanceof FileList}function o(t){if(null===t)return null;if(i(t))return t;if(Array.isArray(t)){var e=[];for(var n in t)t.hasOwnProperty(n)&&(e[n]=o(t[n]));return e}if("object"===(void 0===t?"undefined":r(t))){var s={};for(var a in t)t.hasOwnProperty(a)&&(s[a]=o(t[a]));return s}return t}e.isArray=function(t){return"[object Array]"===Object.prototype.toString.call(t)},e.isFile=i,e.merge=function(t,e){for(var n in e)t[n]=o(e[n])},e.cloneDeep=o},XIG7:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};function i(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:new FormData,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;if(null===t||"undefined"===t||0===t.length)return e.append(n,t);for(var r in t)t.hasOwnProperty(r)&&s(e,o(n,r),t[r]);return e}function o(t,e){return t?t+"["+e+"]":e}function s(t,e,n){return n instanceof Date?t.append(e,n.toISOString()):n instanceof File?t.append(e,n,n.name):"boolean"==typeof n?t.append(e,n?"1":"0"):"object"!==(void 0===n?"undefined":r(n))?t.append(e,n):void i(n,t,e)}e.objectToFormData=i},ZWtO:function(t,e,n){var r=n("4uTw"),i=n("9Nap");t.exports=function(t,e){for(var n=0,o=(e=r(e,t)).length;null!=t&&n<o;)t=t[i(e[n++])];return n&&n==o?t:void 0}},c9nb:function(t,e,n){"use strict";n.r(e);var r=n("5YJQ"),i=n.n(r),o=n("7GkX"),s=n.n(o),a=n("mwIZ"),u=n.n(a),c=n("afOK"),l=n.n(c);function f(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,r)}return n}function p(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function d(){var t={};return s()(window.App.supportedLocales).forEach(function(e){t[e]=null}),t}var h={name:"nzAnnouncementForm",components:{NzWysiwyg:n("xWf0").a},props:{action:String,method:{type:String,default:"post"},types:{type:Array,default:function(){return[]}},announcement:{type:Object,default:function(){return{private:!1}}},title:{type:Object,default:function(){return d()}},message:{type:Object,default:function(){return d()}},redirectUrl:String,cancelUrl:String},data:function(){return{form:this.newForm()}},computed:{supportedLocales:function(){return window.App.supportedLocales},isEdit:function(){return"put"===this.method.toLowerCase()}},methods:{submit:function(){this.form.processing||this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmit).catch(this.onFailedSubmit)},onSuccessfulSubmit:function(){var t=this;this.form.processing=!0,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"}),setTimeout(function(){t.form.processing=!1,window.location.href=t.redirectUrl},500)},onFailedSubmit:function(t){this.$buefy.toast.open({duration:2500,message:u()(t,"response.data.message",t.message),type:"is-danger"})},newForm:function(){return new i.a(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?f(n,!0).forEach(function(e){p(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):f(n).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}({},this.announcement,{title:this.title,message:this.message}),{resetOnSuccess:!1})},focusOnTranslation:function(t,e){var n=this,r=s()(this.supportedLocales),i="".concat(e,"-").concat(r[t]);setTimeout(function(){l()(n.$refs[i]).focus()},500)}}},b=n("KHd+"),y=Object(b.a)(h,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("form",{staticClass:"announcement-form",on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.announcements.title"),type:t.form.errors.has("title")?"is-danger":"",message:t.form.errors.has("title")?t.form.errors.first("title"):""}},[n("b-tabs",{staticClass:"block",attrs:{size:"is-small"},on:{change:function(e){return t.focusOnTranslation(e,"title")}}},t._l(t.supportedLocales,function(e,r){return n("b-tab-item",{key:r,attrs:{label:t.trans("languages."+e.name)}},[n("b-input",{ref:"title-"+r,refInFor:!0,attrs:{autofocus:""},model:{value:t.form.title[r],callback:function(e){t.$set(t.form.title,r,e)},expression:"form.title[locale]"}})],1)}),1)],1),t._v(" "),n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.announcements.message"),type:t.form.errors.has("message")?"is-danger":"",message:t.form.errors.has("message")?t.form.errors.first("message"):""}},[n("b-tabs",{staticClass:"block",attrs:{size:"is-small"},on:{change:function(e){return t.focusOnTranslation(e,"message")}}},t._l(t.supportedLocales,function(e,r){return n("b-tab-item",{key:r,attrs:{label:t.trans("languages."+e.name)}},[n("nz-wysiwyg",{ref:"message-"+r,refInFor:!0,model:{value:t.form.message[r],callback:function(e){t.$set(t.form.message,r,e)},expression:"form.message[locale]"}})],1)}),1)],1),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.announcements.private")}},[n("b-switch",{model:{value:t.form.private,callback:function(e){t.$set(t.form,"private",e)},expression:"form.private"}},[t._v("\n            "+t._s(t.form.private?t.trans("Yes"):t.trans("No"))+"\n        ")])],1)],1)]),t._v(" "),n("hr"),t._v(" "),n("button",{staticClass:"button is-primary",attrs:{type:"submit"}},[t._v(t._s(t.isEdit?t.trans("buttons.save"):t.trans("labels.announcements.publish")))]),t._v(" "),n("a",{staticClass:"button",attrs:{href:t.cancelUrl}},[t._v(t._s(t.trans("buttons.cancel")))])],1)},[],!1,null,null,null);e.default=y.exports},eXgj:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r,i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=function(){function t(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}return function(e,n,r){return n&&t(e.prototype,n),r&&t(e,r),e}}(),s=n("ukZA"),a=(r=s)&&r.__esModule?r:{default:r},u=n("f7hI");var c=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.processing=!1,this.successful=!1,this.withData(e).withOptions(n).withErrors({})}return o(t,[{key:"withData",value:function(t){for(var e in(0,u.isArray)(t)&&(t=t.reduce(function(t,e){return t[e]="",t},{})),this.setInitialValues(t),this.errors=new a.default,this.processing=!1,this.successful=!1,t)(0,u.guardAgainstReservedFieldName)(e),this[e]=t[e];return this}},{key:"withErrors",value:function(t){return this.errors=new a.default(t),this}},{key:"withOptions",value:function(t){this.__options={resetOnSuccess:!0},t.hasOwnProperty("resetOnSuccess")&&(this.__options.resetOnSuccess=t.resetOnSuccess),t.hasOwnProperty("onSuccess")&&(this.onSuccess=t.onSuccess),t.hasOwnProperty("onFail")&&(this.onFail=t.onFail);var e="undefined"!=typeof window&&window.axios;if(this.__http=t.http||e||n("vDqi"),!this.__http)throw new Error("No http library provided. Either pass an http option, or install axios.");return this}},{key:"data",value:function(){var t={};for(var e in this.initial)t[e]=this[e];return t}},{key:"only",value:function(t){var e=this;return t.reduce(function(t,n){return t[n]=e[n],t},{})}},{key:"reset",value:function(){(0,u.merge)(this,this.initial),this.errors.clear()}},{key:"setInitialValues",value:function(t){this.initial={},(0,u.merge)(this.initial,t)}},{key:"populate",value:function(t){var e=this;return Object.keys(t).forEach(function(n){(0,u.guardAgainstReservedFieldName)(n),e.hasOwnProperty(n)&&(0,u.merge)(e,function(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}({},n,t[n]))}),this}},{key:"clear",value:function(){for(var t in this.initial)this[t]="";this.errors.clear()}},{key:"post",value:function(t){return this.submit("post",t)}},{key:"put",value:function(t){return this.submit("put",t)}},{key:"patch",value:function(t){return this.submit("patch",t)}},{key:"delete",value:function(t){return this.submit("delete",t)}},{key:"submit",value:function(t,e){var n=this;return this.__validateRequestType(t),this.errors.clear(),this.processing=!0,this.successful=!1,new Promise(function(r,i){n.__http[t](e,n.hasFiles()?(0,u.objectToFormData)(n.data()):n.data()).then(function(t){n.processing=!1,n.onSuccess(t.data),r(t.data)}).catch(function(t){n.processing=!1,n.onFail(t),i(t)})})}},{key:"hasFiles",value:function(){for(var t in this.initial)if(this.hasFilesDeep(this[t]))return!0;return!1}},{key:"hasFilesDeep",value:function(t){if(null===t)return!1;if("object"===(void 0===t?"undefined":i(t)))for(var e in t)if(t.hasOwnProperty(e)&&(0,u.isFile)(t[e]))return!0;if(Array.isArray(t))for(var n in t)if(t.hasOwnProperty(n))return this.hasFilesDeep(t[n]);return(0,u.isFile)(t)}},{key:"onSuccess",value:function(t){this.successful=!0,this.__options.resetOnSuccess&&this.reset()}},{key:"onFail",value:function(t){this.successful=!1,t.response&&t.response.data.errors&&this.errors.record(t.response.data.errors)}},{key:"hasError",value:function(t){return this.errors.has(t)}},{key:"getError",value:function(t){return this.errors.first(t)}},{key:"getErrors",value:function(t){return this.errors.get(t)}},{key:"__validateRequestType",value:function(t){var e=["get","delete","head","post","put","patch"];if(-1===e.indexOf(t))throw new Error("`"+t+"` is not a valid request type, must be one of: `"+e.join("`, `")+"`.")}}],[{key:"create",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return(new t).withData(e)}}]),t}();e.default=c},f7hI:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("WfdN");Object.keys(r).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return r[t]}})});var i=n("XIG7");Object.keys(i).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return i[t]}})});var o=n("0JjW");Object.keys(o).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return o[t]}})})},mwIZ:function(t,e,n){var r=n("ZWtO");t.exports=function(t,e,n){var i=null==t?void 0:r(t,e);return void 0===i?n:i}},ukZA:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}return function(e,n,r){return n&&t(e.prototype,n),r&&t(e,r),e}}();var i=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.record(e)}return r(t,[{key:"all",value:function(){return this.errors}},{key:"has",value:function(t){var e=this.errors.hasOwnProperty(t);e||(e=Object.keys(this.errors).filter(function(e){return e.startsWith(t+".")||e.startsWith(t+"[")}).length>0);return e}},{key:"first",value:function(t){return this.get(t)[0]}},{key:"get",value:function(t){return this.errors[t]||[]}},{key:"any",value:function(){return Object.keys(this.errors).length>0}},{key:"record",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.errors=t}},{key:"clear",value:function(t){if(t){var e=Object.assign({},this.errors);Object.keys(e).filter(function(e){return e===t||e.startsWith(t+".")||e.startsWith(t+"[")}).forEach(function(t){return delete e[t]}),this.errors=e}else this.errors={}}}]),t}();e.default=i},xWf0:function(t,e,n){"use strict";var r=n("XuX8"),i=n.n(r),o=n("rX62"),s=n.n(o);i.a.config.ignoredElements=["trix-editor"];var a=s.a.config.lang;function u(){for(var t="",e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",n=0;n<5;n++)t+=e.charAt(Math.floor(Math.random()*e.length));return t}s.a.config.toolbar={getDefaultHTML:function(){return'\n    <div class="trix-button-row">\n      <span class="trix-button-group trix-button-group--text-tools" data-trix-button-group="text-tools">\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-bold" data-trix-attribute="bold" data-trix-key="b" title="'.concat(a.bold,'" tabindex="-1">').concat(a.bold,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-italic" data-trix-attribute="italic" data-trix-key="i" title="').concat(a.italic,'" tabindex="-1">').concat(a.italic,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-strike" data-trix-attribute="strike" title="#{lang.strike}" tabindex="-1">').concat(a.strike,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-link" data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="').concat(a.link,'" tabindex="-1">').concat(a.link,'</button>\n      </span>\n      <span class="trix-button-group trix-button-group--history-tools" data-trix-button-group="history-tools">\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-undo" data-trix-action="undo" data-trix-key="z" title="').concat(a.undo,'" tabindex="-1">').concat(a.undo,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-redo" data-trix-action="redo" data-trix-key="shift+z" title="').concat(a.redo,'" tabindex="-1">').concat(a.redo,'</button>\n      </span>\n    </div>\n    <div class="trix-dialogs" data-trix-dialogs>\n      <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">\n        <div class="trix-dialog__link-fields">\n          <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="').concat(a.urlPlaceholder,'" required data-trix-input>\n          <div class="trix-button-group">\n            <input type="button" class="trix-button trix-button--dialog" value="').concat(a.link,'" data-trix-method="setAttribute">\n            <input type="button" class="trix-button trix-button--dialog" value="').concat(a.unlink,'" data-trix-method="removeAttribute">\n          </div>\n        </div>\n      </div>\n    </div>\n  ')}};var c={name:"nzWysiwyg",props:{name:String,value:String},data:function(){return{inputId:u()}},mounted:function(){this.$refs.trix.addEventListener("trix-change",this.onInput)},beforeDestroy:function(){this.$refs.trix.removeEventListener("trix-change",this.onInput)},methods:{onInput:function(t){this.$emit("input",t.target.innerHTML)},focus:function(){this.$refs.trix.focus()}}},l=n("KHd+"),f=Object(l.a)(c,function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"wysiwyg"},[e("input",{ref:"input",attrs:{id:this.inputId,type:"hidden",name:this.name},domProps:{value:this.value}}),this._v(" "),e("trix-editor",{ref:"trix",attrs:{input:this.inputId}})],1)},[],!1,null,null,null);e.a=f.exports}}]);
//# sourceMappingURL=20.js.map?id=63122c9652116f9676ea