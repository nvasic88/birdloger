(window.webpackJsonp=window.webpackJsonp||[]).push([[25],{mk2N:function(t,e,i){"use strict";var n=i("5YJQ"),o=i.n(n),s=i("JZM8"),r=i.n(s),a=i("mwIZ"),c=i.n(a),l=i("Y+p1"),u=i.n(l);function m(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),i.push.apply(i,n)}return i}function h(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}e.a={name:"nzFieldObservationForm",props:{action:{type:String,required:!0},method:{type:String,default:"POST"},redirectUrl:String,cancelUrl:String,submitMore:Boolean,shouldConfirmSubmit:Boolean,confirmSubmitMessage:{type:String,default:function(){return this.trans("You are about to submit")}},shouldAskReason:Boolean,shouldConfirmCancel:Boolean,submitOnlyDirty:Boolean,submitOnlyDirtyMessage:{type:String,default:function(){return this.trans("There are no changes, the data will not be saved.")}}},data:function(){return{form:this.newForm(),keepAfterSubmit:[],submittingWithRedirect:!1,submittingWithoutRedirect:!1,confirmingSubmit:!1,confirmingCancel:!1,locale:window.App.locale}},created:function(){document.addEventListener("keyup",this.registerKeyListener)},beforeDestroy:function(){document.removeEventListener("keyup",this.registerKeyListener)},methods:{newForm:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return new o.a(t,{resetOnSuccess:!1})},registerKeyListener:function(t){var e=13===(t.which||t.keyCode);t.ctrlKey&&t.shiftKey&&e?this.submitMore&&this.submitWithoutRedirect():t.ctrlKey&&e&&this.submitWithRedirect()},confirmSubmit:function(t){var e=this;if(!this.confirmingSubmit){this.confirmingSubmit=!0;var i={message:this.confirmSubmitMessage,confirmText:this.trans("buttons.save"),cancelText:this.trans("buttons.cancel"),onConfirm:t,onCancel:function(){e.confirmingSubmit=!1}};return this.shouldAskReason?this.promptForReason(i):this.$buefy.dialog.confirm(i)}},promptForReason:function(t){var e=this,i=this.$buefy.dialog.prompt(function(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?m(i,!0).forEach(function(e){h(t,e,i[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):m(i).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))})}return t}({},t,{inputAttrs:{placeholder:this.trans("Reason"),required:!0,maxlength:255}}));return i.$nextTick(function(){i.$refs.input.addEventListener("invalid",function(t){t.target.setCustomValidity(""),t.target.validity.valid||t.target.setCustomValidity(e.trans("This field is required and can contain max 255 chars."))}),i.$refs.input.addEventListener("input",function(t){i.validationMessage=null})}),i},notifyNoChanges:function(){this.$buefy.toast.open({message:this.submitOnlyDirtyMessage,type:"is-info"})},notifyNoChangesAndRedirect:function(){var t=this;this.notifyNoChanges(),setTimeout(function(){t.redirectUrl&&(window.location.href=t.redirectUrl)},500)},submitWithRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChangesAndRedirect():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithRedirect):void this.performSubmitWithRedirect()},performSubmitWithRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithRedirect:function(){var t=this;this.form.processing=!0,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"}),setTimeout(function(){t.form.processing=!1,t.submittingWithRedirect=!1,t.hookAfterSubmitWithRedirect(),t.redirectUrl&&(window.location.href=t.redirectUrl)},500)},hookAfterSubmitWithRedirect:function(){},submitWithoutRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChanges():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithoutRedirect):void this.performSubmitWithoutRedirect()},performSubmitWithoutRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithoutRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithoutRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithoutRedirect:function(){this.submittingWithoutRedirect=!1,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"});var t=r()(this.form.data(),this.keepAfterSubmit);this.form.reset(),this.form.populate(t),this.hookAfterSubmitWithoutRedirect()},hookAfterSubmitWithoutRedirect:function(){},onFailedSubmit:function(t){this.submittingWithRedirect=!1,this.submittingWithoutRedirect=!1,this.$buefy.toast.open({duration:2500,message:c()(t,"response.data.message",t.message),type:"is-danger"})},isDirty:function(){return!u()(this.form.data(),this.form.initial)},confirmCancel:function(){var t=this;this.confirmingCancel||(this.confirmingCancel=!0,this.$buefy.dialog.confirm({message:this.trans("If you leave this page changes will not be saved."),onConfirm:function(){t.confirmingCancel=!1,window.location.href=t.cancelUrl},onCancel:function(){t.confirmingCancel=!1},cancelText:this.trans("buttons.stay_on_page"),confirmText:this.trans("buttons.leave_page")}))},onCancel:function(t){this.shouldConfirmCancel&&this.isDirty()&&(t.preventDefault(),this.confirmCancel())}}}},nWYc:function(t,e,i){"use strict";var n=i("+9FD"),o=i.n(n),s=i("dfMu"),r=i.n(s),a=i("T5TR");function c(t){return(c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function l(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}function u(t,e){return!e||"object"!==c(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function m(t){return(m=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function h(t,e){return(h=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}var d=function(t){function e(){return function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),u(this,m(e).apply(this,arguments))}var i,n,o;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&h(t,e)}(e,r.a),i=e,(n=[{key:"setBoxToRealPosition",value:function(t){var e=this.imageEl.naturalWidth,i=this.imageEl.naturalHeight,n=e/this.imageEl.offsetWidth,o=i/this.imageEl.offsetHeight;this.box=new a.a(Math.round(t.x/n),Math.round(t.y/o),Math.round((t.x+t.width)/n),Math.round((t.y+t.height)/o)),this.redraw()}}])&&l(i.prototype,n),o&&l(i,o),e}(),p={name:"nzImageCropModal",mixins:[i("aa4y").a],props:{canCancel:{type:[Array,Boolean],default:function(){return["escape","x"]}},imageUrl:String,crop:Object},data:function(){return{croppr:null,newCrop:this.crop,preserveRatio:!1}},mounted:function(){document.addEventListener("keydown",this.ctrlIsPressed),document.addEventListener("keyup",this.ctrlIsNotPressed)},beforeDestroy:function(){document.removeEventListener("keydown",this.ctrlIsPressed),document.removeEventListener("keyup",this.ctrlIsNotPressed)},watch:{isActive:function(t){var e=this;this.handleScroll(),this.croppr=null,t&&this.$nextTick(function(){e.croppr=new d(e.$refs.cropModalImage,{onCropEnd:function(t){e.newCrop=t},onInitialize:function(t){e.newCrop&&t.setBoxToRealPosition(e.newCrop)}})})}},methods:{handleScroll:function(){"undefined"!=typeof window&&(this.savedScrollTop=this.savedScrollTop?this.savedScrollTop:document.documentElement.scrollTop,document.body.classList.toggle("is-noscroll",this.isActive),this.isActive?document.body.style.top="-".concat(this.savedScrollTop,"px"):(document.documentElement.scrollTop=this.savedScrollTop,document.body.style.top=null,this.savedScrollTop=null))},cropImage:function(){this.$emit("update:crop",this.newCrop),this.close()},ctrlIsPressed:function(t){17==t.which&&this.croppr&&(this.croppr.options.aspectRatio=this.croppr.box.height()/this.croppr.box.width())},ctrlIsNotPressed:function(t){17==t.which&&this.croppr&&(this.croppr.options.aspectRatio=null)}}},f=i("KHd+"),g={name:"nzPhotoUpload",components:{NzImageCropModal:Object(f.a)(p,function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("transition",{attrs:{name:t.animation}},[t.isActive?i("div",{staticClass:"modal is-active"},[i("div",{staticClass:"modal-background"}),t._v(" "),i("div",{staticClass:"animation-content modal-content",style:{maxWidth:t.newWidth}},[i("img",{ref:"cropModalImage",staticClass:"image",attrs:{src:t.imageUrl,alt:"Cropped image"}})]),t._v(" "),i("button",{staticClass:"modal-close is-large",attrs:{type:"button"},on:{click:function(e){return t.cancel("x")}}}),t._v(" "),i("button",{staticClass:"modal-action",attrs:{type:"button"},on:{click:t.cropImage}},[i("b-icon",{attrs:{icon:"check"}})],1)]):t._e()])},[],!1,null,null,null).exports,NzImageModal:i("slQF").a},props:{imageUrl:{type:String,default:null},imagePath:{type:String,default:null},imageLicense:{type:[Number,String],default:null},licenses:{type:Object,required:!0},text:String,withLicense:{type:Boolean,default:!0},withCrop:{type:Boolean,default:!0}},data:function(){return{image:{url:this.imageUrl,path:this.imagePath,crop:null,license:this.imageLicense},croppedImageUrl:null,reader:null,uploading:!1,progress:0,hasExisting:!!this.imageUrl,error:null,showCropModal:!1,showModal:!1}},watch:{"image.crop":function(t){this.$emit("cropped",this.image),t?this.cropThumbnail(t):this.croppedImageUrl=null}},computed:{haveImage:function(){return!!this.image.url},thumbnailUrl:function(){return this.croppedImageUrl||this.image.url}},methods:{selectImage:function(){this.$refs.input.click()},onInput:function(t){this.error=null,t&&this.upload(t)},upload:function(t){var e=this;return this.uploading=!0,axios.post(route("api.photo-uploads.store"),this.makeForm(t),{headers:{"Content-Type":"multipart/form-data",Accept:"application/json"},onUploadProgress:function(t){e.progress=Math.floor(100*t.loaded/t.total)}}).then(function(i){e.image.path=i.data.file,e.image.exif=i.data.exif,e.image.license=null,e.uploading=!1,e.progress=0,e.$emit("uploaded",e.image),o()(t,function(t){e.image.url=t.toDataURL()},{orientation:!0})}).catch(this.handleError)},makeForm:function(t){var e=new FormData;return e.append("file",t),e},remove:function(){var t=this;if(this.hasExisting)return this.hasExisting=!1,this.clearPhoto();axios.delete(route("api.photo-uploads.destroy",this.image.path)).then(function(){t.clearPhoto()})},clearPhoto:function(){this.$emit("removed",this.image),this.image.path=null,this.image.url=null,this.image.crop=null,this.image.license=null,this.croppedImageUrl=null},handleError:function(t){if(this.uploading=!1,this.progress=0,this.image.url=null,this.$el.querySelector('input[type="file"]').value="",!t.response)return this.$buefy.toast.open({duration:5e3,message:t.message,position:"is-top",type:"is-danger"});this.error=t.response.data.errors.file[0]||this.trans("Error")},openCropModal:function(){this.showCropModal=!0},closeCropModal:function(){this.showCropModal=!1},cropThumbnail:function(t){var e=document.createElement("img");e.src=this.image.url;var i=document.createElement("canvas");i.setAttribute("width",t.width),i.setAttribute("height",t.height),i.getContext("2d").drawImage(e,-t.x,-t.y),this.croppedImageUrl=i.toDataURL()},handleLicenseChanged:function(t){this.image.license=t,this.$emit("license-changed",t)}}},b=Object(f.a)(g,function(){var t=this,e=t.$createElement,i=t._self._c||e;return t.haveImage?i("div",{staticClass:"card"},[i("div",{staticClass:"card-image"},[i("figure",{staticClass:"has-magnifier has-text-centered",on:{click:function(e){t.showModal=!0}}},[i("img",{staticClass:"max-h-36",attrs:{src:t.thumbnailUrl,alt:"Uploaded photo"}}),t._v(" "),i("div",{staticClass:"image-magnifier"},[i("b-icon",{attrs:{icon:"expand",size:"is-medium"}})],1)])]),t._v(" "),t.haveImage?i("footer",{staticClass:"card-footer"},[i("div",{staticClass:"card-footer-item flex-col"},[i("div",{staticClass:"mb-4 w-full flex justify-between"},[t.withCrop?i("button",{staticClass:"button is-outlined is-small mr-2",attrs:{type:"button"},on:{click:t.openCropModal,close:t.closeCropModal}},[i("b-icon",{attrs:{icon:"crop"}})],1):t._e(),t._v(" "),t.image.path||t.hasExisting?i("button",{staticClass:"delete is-danger is-medium",attrs:{type:"button"},on:{click:t.remove}}):t._e()]),t._v(" "),t.withLicense?i("div",{staticClass:"w-full"},[i("b-select",{attrs:{value:t.image.license,expanded:""},on:{input:t.handleLicenseChanged}},[i("option",{domProps:{value:null}},[t._v(t._s(t.trans("labels.field_observations.default")))]),t._v(" "),t._l(t.licenses,function(e,n){return i("option",{domProps:{value:n,textContent:t._s(e)}})})],2)],1):t._e()])]):t._e(),t._v(" "),t.haveImage?i("nz-image-crop-modal",{attrs:{active:t.showCropModal,crop:t.image.crop,"image-url":t.image.url},on:{"update:active":function(e){t.showCropModal=e},"update:crop":function(e){return t.$set(t.image,"crop",e)}}}):t._e(),t._v(" "),t.showModal?i("nz-image-modal",{attrs:{items:[t.thumbnailUrl]},on:{close:function(e){t.showModal=!1}}}):t._e()],1):i("b-field",{attrs:{message:t.error||null,type:t.error?"is-danger":null,expanded:""}},[i("b-upload",{attrs:{"drag-drop":"",type:"is-fullwidth"},on:{input:t.onInput}},[i("section",{staticClass:"section"},[i("div",{staticClass:"has-text-centered"},[i("div",[i("b-icon",{attrs:{icon:"upload",size:"is-medium"}})],1),t._v(" "),t.uploading?i("progress",{staticClass:"progress is-primary is-small",attrs:{max:"100"},domProps:{value:t.progress}},[t._v(t._s(t.progress)+"%")]):i("div",[t._v(t._s(t.text))])])])])],1)},[],!1,null,null,null);e.a=b.exports},slQF:function(t,e,i){"use strict";var n={name:"nzImageModal",props:{items:{type:Array,default:function(){return[]}},value:{type:Number,default:0}},data:function(){return{newValue:this.value,active:!0}},computed:{openImage:function(){return this.items[this.newValue]}},watch:{newValue:function(){this.$emit("input",this.newValue)},openImage:{immediate:!0,handler:function(t){this.active=Boolean(t)}}},created:function(){document.addEventListener("keyup",this.registerKeyListener)},beforeDestroy:function(){document.removeEventListener("keyup",this.registerKeyListener)},methods:{next:function(){var t=this.newValue+1;t>=this.items.length&&(t=0),this.newValue=t},prev:function(){var t=this.newValue-1;t<0&&(t=this.items.length-1),this.newValue=t},registerKeyListener:function(t){var e=t.which||t.keyCode;37===e?this.prev():39===e&&this.next()},onClose:function(t){this.active=!1,document.documentElement.classList.remove("is-clipped"),document.body.classList.remove("is-noscroll"),this.$emit("close",t)}}},o=i("KHd+"),s=Object(o.a)(n,function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("b-modal",{attrs:{active:t.active,"can-cancel":["escape","x"]},on:{"update:active":function(e){t.active=e},close:t.onClose}},[i("div",{staticClass:"image-modal"},[i("img",{attrs:{src:t.openImage}}),t._v(" "),t.items.length>1?i("div",{staticClass:"image-modal-navigation"},[i("div",{staticClass:"image-modal-previous",on:{click:t.prev}},[i("i",{staticClass:"fa fa-chevron-left",attrs:{"aria-hidden":"true"}})]),t._v(" "),i("div",{staticClass:"image-modal-next",on:{click:t.next}},[i("i",{staticClass:"fa fa-chevron-right",attrs:{"aria-hidden":"true"}})])]):t._e()])])},[],!1,null,null,null);e.a=s.exports},tP6Z:function(t,e,i){"use strict";i.r(e);var n=i("5YJQ"),o=i.n(n),s=i("7GkX"),r=i.n(s),a=i("J2m7"),c=i.n(a),l=i("mwIZ"),u=i.n(l),m=i("sEfC"),h=i.n(m),d=i("mk2N"),p=i("nWYc");function f(){var t={};return r()(window.App.supportedLocales).forEach(function(e){t[e]=null}),t}var g={name:"nzViewGroupForm",mixins:[d.a],components:{NzPhotoUpload:p.a},props:{group:{type:Object,default:function(){return{parent_id:null,only_observed_taxa:!1,taxa:[]}}},rootGroups:Array,names:{type:Object,default:function(){return f()}},descriptions:{type:Object,default:function(){return f()}}},data:function(){return{form:this.newForm(),taxa:this.group.taxa,filteredTaxa:[]}},computed:{supportedLocales:function(){return window.App.supportedLocales},parent:{get:function(){return c()(this.rootGroups,{id:this.form.parent_id})},set:function(t){this.form.parent_id=u()(t,"id")}},isRoot:function(){return!this.form.parent_id}},watch:{taxa:function(t){this.form.taxa_ids=t.map(function(t){return t.id})}},methods:{newForm:function(){return new o.a({parent_id:this.group.parent_id,name:this.names,description:this.descriptions,image_url:this.group.image_url,image_path:this.group.image_path,only_observed_taxa:this.group.only_observed_taxa,taxa_ids:this.group.taxa.map(function(t){return t.id})},{resetOnSuccess:!1})},focusOnTranslation:function(t,e){var i=this,n=r()(this.supportedLocales),o="#".concat(e,"-").concat(n[t]);setTimeout(function(){i.$el.querySelector(o).focus()},500)},fetchTaxa:function(t){var e=this;axios.get(route("api.taxa.index"),{params:{name:t,page:1,per_page:10,except:this.taxa.map(function(t){return t.id})}}).then(function(t){var i=t.data;e.filteredTaxa=i.data})},onTaxonNameInput:h()(function(t){return this.fetchTaxa(t)},500),onImageUploaded:function(t){this.form.image_path=t.path},onImageRemoved:function(){this.form.image_url=null,this.form.image_path=null}}},b=i("KHd+"),v=Object(b.a)(g,function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("form",{attrs:{action:t.action,method:"POST"},on:{submit:function(e){return e.preventDefault(),t.submitWithRedirect(e)}}},[i("b-field",{attrs:{label:t.trans("labels.view_groups.parent")}},[i("b-select",{model:{value:t.parent,callback:function(e){t.parent=e},expression:"parent"}},[i("option"),t._v(" "),t._l(t.rootGroups,function(e){return i("option",{domProps:{value:e}},[t._v(t._s(e.name))])})],2)],1),t._v(" "),i("b-field",{attrs:{label:t.trans("labels.view_groups.name")}},[i("b-tabs",{staticClass:"block",attrs:{size:"is-small"},on:{change:function(e){return t.focusOnTranslation(e,"name")}}},t._l(t.supportedLocales,function(e,n){return i("b-tab-item",{key:n,attrs:{label:t.trans("languages."+e.name)}},[i("b-input",{attrs:{id:"name-"+n},model:{value:t.form.name[n],callback:function(e){t.$set(t.form.name,n,e)},expression:"form.name[locale]"}})],1)}),1)],1),t._v(" "),i("b-field",{attrs:{label:t.trans("labels.view_groups.description")}},[i("b-tabs",{staticClass:"block",attrs:{size:"is-small"},on:{change:function(e){return t.focusOnTranslation(e,"description")}}},t._l(t.supportedLocales,function(e,n){return i("b-tab-item",{key:n,attrs:{label:t.trans("languages."+e.name)}},[i("b-input",{attrs:{type:"textarea",id:"description-"+n},model:{value:t.form.description[n],callback:function(e){t.$set(t.form.description,n,e)},expression:"form.description[locale]"}})],1)}),1)],1),t._v(" "),t.isRoot?t._e():[i("b-field",{attrs:{label:t.trans("labels.view_groups.taxa")}},[i("b-taginput",{attrs:{data:t.filteredTaxa,autocomplete:"",field:"name"},on:{typing:t.onTaxonNameInput},scopedSlots:t._u([{key:"default",fn:function(e){return[i("span",[t._v(t._s(e.option.name))])]}}],null,!1,1538493864),model:{value:t.taxa,callback:function(e){t.taxa=e},expression:"taxa"}})],1),t._v(" "),i("b-field",[i("b-checkbox",{model:{value:t.form.only_observed_taxa,callback:function(e){t.$set(t.form,"only_observed_taxa",e)},expression:"form.only_observed_taxa"}},[t._v(t._s(t.trans("labels.view_groups.only_observed_taxa")))])],1)],t._v(" "),i("b-field",{attrs:{label:t.trans("labels.view_groups.image")}},[i("nz-photo-upload",{attrs:{"image-url":t.form.image_url,"image-path":t.form.image_path,licenses:{},"with-license":!1,"with-crop":!1},on:{uploaded:t.onImageUploaded,removed:t.onImageRemoved}})],1),t._v(" "),i("hr"),t._v(" "),i("button",{staticClass:"button is-primary",class:{"is-loading":t.form.processing},attrs:{type:"submit"},on:{click:t.submitWithRedirect}},[t._v("\n    "+t._s(t.trans("buttons.save"))+"\n  ")]),t._v(" "),i("a",{staticClass:"button is-text",attrs:{href:t.cancelUrl},on:{click:t.onCancel}},[t._v(t._s(t.trans("buttons.cancel")))])],2)},[],!1,null,null,null);e.default=v.exports}}]);
//# sourceMappingURL=25.js.map?id=5ed1e1f50e267ccb3b83