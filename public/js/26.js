(window.webpackJsonp=window.webpackJsonp||[]).push([[26],{Xfb0:function(t,e,r){"use strict";r.r(e);var s=r("5YJQ"),i=r.n(s),n=r("J2m7"),a=r.n(n),o=r("mk2N"),l={name:"nzPublicationAttachmentUpload",props:{attachmentName:String},data:function(){return{attachmentFileName:this.attachmentName,reader:null,uploading:!1,progress:0,error:null}},computed:{hasAttachment:function(){return!!this.attachmentFileName}},methods:{onInput:function(t){this.error=null,t?this.upload(t):this.remove()},openUpload:function(){this.$refs.upload.$refs.input.click()},upload:function(t){var e=this;return this.uploading=!0,axios.post(route("api.publication-attachments.store"),this.makeForm(t),{headers:{"Content-Type":"multipart/form-data",Accept:"application/json"},onUploadProgress:function(t){e.progress=Math.floor(100*t.loaded/t.total)}}).then(function(t){var r=t.data.data;e.attachmentFileName=r.original_name,e.uploading=!1,e.progress=0,e.$emit("uploaded",r)}).catch(this.handleError)},makeForm:function(t){var e=new FormData;return e.append("attachment",t),e},remove:function(){this.$emit("removed",this.attachment),this.attachmentFileName=null},handleError:function(t){if(this.uploading=!1,this.progress=0,this.$el.querySelector('input[type="file"]').value="",!t.response)return this.$buefy.toast.open({duration:5e3,message:t.message,position:"is-top",type:"is-danger"});this.error=t.response.data.errors.attachment[0]||this.trans("Error")}}},u=r("KHd+"),c=Object(u.a)(l,function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("b-field",{attrs:{message:t.error||null,type:t.error?"is-danger":null,expanded:""}},[r("b-field",{staticClass:"file"},[t.uploading?r("progress",{staticClass:"progress is-primary is-small",attrs:{max:"100"},domProps:{value:t.progress}},[t._v(t._s(t.progress)+"%")]):t._e(),t._v(" "),t.hasAttachment?r("div",{staticClass:"flex items-center justify-between w-full"},[r("div",{staticClass:"mr-4"},[t._v("\n        "+t._s(t.attachmentFileName)+"\n      ")]),t._v(" "),r("button",{staticClass:"button is-danger is-outlined",attrs:{type:"button"},on:{click:t.remove}},[r("b-icon",{attrs:{icon:"times"}})],1)]):r("b-upload",{directives:[{name:"show",rawName:"v-show",value:!t.uploading,expression:"!uploading"}],ref:"upload",attrs:{accept:".pdf,.odt,.doc,.docx"},on:{input:t.onInput}},[r("button",{staticClass:"button is-secondary",attrs:{type:"button"},on:{click:t.openUpload}},[r("b-icon",{attrs:{icon:"upload"}}),t._v(" "),r("span",[t._v("Upload Document")])],1)])],1)],1)},[],!1,null,null,null).exports;function m(t){return function(t){if(Array.isArray(t)){for(var e=0,r=new Array(t.length);e<t.length;e++)r[e]=t[e];return r}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}function f(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),r.push.apply(r,s)}return r}function h(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?f(r,!0).forEach(function(e){p(t,e,r[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):f(r).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))})}return t}function p(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var d={name:"nzPublicationForm",components:p({},c.name,c),mixins:[o.a],props:{publication:{type:Object,default:function(){return{type:null,year:null,name:null,title:null,publisher:null,issue:null,place:null,page_count:null,page_range:null,doi:null,citation:null,authors:[],editors:[],link:null,attachment:null,attachment_id:null}}},publicationTypes:{type:Array,default:function(){return[]}}},data:function(){return{form:new i.a(h({},this.publication),{resetOnSuccess:!1})}},computed:{chosenType:function(){return a()(this.publicationTypes,{value:this.form.type})},typeHasName:function(){return!!this.chosenType&&this.chosenType.has_name},typeHasEditors:function(){return!!this.chosenType&&this.chosenType.has_editors},typeRequiresEditors:function(){return!!this.chosenType&&this.chosenType.requires_editors},typeHasPublisher:function(){return!!this.chosenType&&this.chosenType.has_publisher},typeRequiresPublisher:function(){return!!this.chosenType&&this.chosenType.requires_publisher},typeHasIssue:function(){return!!this.chosenType&&this.chosenType.has_issue},typeRequiresIssue:function(){return!!this.chosenType&&this.chosenType.requires_issue},typeHasPlace:function(){return!!this.chosenType&&this.chosenType.has_place},typeRequiresPlace:function(){return!!this.chosenType&&this.chosenType.requires_place},typeHasPageRange:function(){return!!this.chosenType&&this.chosenType.has_page_range},nameLabel:function(){var t=this.form.type;return this.trans("labels.publications.".concat(t,"_name"),{},this.trans("labels.publications.name"))},titleLabel:function(){var t=this.form.type;return this.trans("labels.publications.".concat(t,"_title"),{},this.trans("labels.publications.title"))}},methods:{addAuthor:function(){this.form.authors.push({first_name:"",last_name:""})},addEditor:function(){this.form.editors.push({first_name:"",last_name:""})},removeAuthor:function(t){this.removeItemFromField("authors",t)},removeEditor:function(t){this.removeItemFromField("editors",t)},removeItemFromField:function(t,e){this.form[t]=[].concat(m(this.form[t].slice(0,e)),m(this.form[t].slice(e+1))),this.removeErrorForItem(t,e)},removeErrorForItem:function(t,e){var r=this.form.errors.all(),s={};Object.keys(r).forEach(function(i){var n=i.match(new RegExp("^".concat(t,".(\\d+)$")));n&&n[1]>e?s["".concat(t,".").concat(n[1]-1)]=r[i]:n||(s[i]=r[i])}),this.form.errors.record(s)},handleAttachmentUploaded:function(t){this.form.attachment=t,this.form.attachment_id=t.id},handleRemovedAttachment:function(){this.form.attachment=null,this.form.attachment_id=null},authorHasError:function(t){return this.form.errors.has("authors.".concat(t))||this.form.errors.has("authors.".concat(t,".first_name"))||this.form.errors.has("authors.".concat(t,".last_name"))},getAuthorError:function(t){return this.form.errors.first("authors.".concat(t))||this.form.errors.first("authors.".concat(t,".first_name"))||this.form.errors.first("authors.".concat(t,".last_name"))},editorHasError:function(t){return this.form.errors.has("editors.".concat(t))||this.form.errors.has("editors.".concat(t,".first_name"))||this.form.errors.has("editors.".concat(t,".last_name"))},getEditorError:function(t){return this.form.errors.first("editors.".concat(t))||this.form.errors.first("editors.".concat(t,".first_name"))||this.form.errors.first("editors.".concat(t,".last_name"))}}},b=Object(u.a)(d,function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("form",{staticClass:"publication-form",attrs:{action:t.action,method:t.method,lang:t.locale},on:{submit:function(e){return e.preventDefault(),t.submitWithRedirect(e)}}},[r("div",{staticClass:"columns"},[r("div",{staticClass:"column"},[r("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.publications.type"),"label-for":"type",type:t.form.errors.has("type")?"is-danger":null,message:t.form.errors.has("type")?t.form.errors.first("type"):null}},[r("b-select",{attrs:{id:"type",name:"type",expanded:""},model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},t._l(t.publicationTypes,function(e){return r("option",{key:e.value,domProps:{value:e.value}},[t._v("\n            "+t._s(e.label)+"\n          ")])}),0)],1),t._v(" "),r("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.publications.year"),"label-for":"year",type:t.form.errors.has("year")?"is-danger":null,message:t.form.errors.has("year")?t.form.errors.first("year"):null}},[r("b-input",{attrs:{id:"year",name:"year",type:"number",expanded:""},model:{value:t.form.year,callback:function(e){t.$set(t.form,"year",e)},expression:"form.year"}})],1),t._v(" "),t.typeHasName?r("b-field",{staticClass:"is-required",attrs:{label:t.nameLabel,"label-for":"name",type:t.form.errors.has("name")?"is-danger":null,message:t.form.errors.has("name")?t.form.errors.first("name"):null}},[r("b-input",{attrs:{id:"name",name:"name",expanded:""},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1):t._e(),t._v(" "),r("b-field",{staticClass:"is-required",attrs:{label:t.titleLabel,"label-for":"title",type:t.form.errors.has("title")?"is-danger":null,message:t.form.errors.has("title")?t.form.errors.first("title"):null}},[r("b-input",{attrs:{id:"title",name:"title",expanded:""},model:{value:t.form.title,callback:function(e){t.$set(t.form,"title",e)},expression:"form.title"}})],1),t._v(" "),t.typeHasPublisher?r("b-field",{class:{"is-required":t.typeRequiresPublisher},attrs:{label:t.trans("labels.publications.publisher"),"label-for":"publisher",type:t.form.errors.has("publisher")?"is-danger":null,message:t.form.errors.has("publisher")?t.form.errors.first("publisher"):null}},[r("b-input",{attrs:{id:"publisher",name:"publisher",expanded:""},model:{value:t.form.publisher,callback:function(e){t.$set(t.form,"publisher",e)},expression:"form.publisher"}})],1):t._e(),t._v(" "),t.typeHasIssue?r("b-field",{class:{"is-required":t.typeRequiresIssue},attrs:{label:t.trans("labels.publications.issue"),"label-for":"issue",type:t.form.errors.has("issue")?"is-danger":null,message:t.form.errors.has("issue")?t.form.errors.first("issue"):null}},[r("b-input",{attrs:{id:"issue",name:"issue",expanded:""},model:{value:t.form.issue,callback:function(e){t.$set(t.form,"issue",e)},expression:"form.issue"}})],1):t._e(),t._v(" "),t.typeHasPlace?r("b-field",{class:{"is-required":t.typeRequiresPlace},attrs:{label:t.trans("labels.publications.place"),"label-for":"place",type:t.form.errors.has("place")?"is-danger":null,message:t.form.errors.has("place")?t.form.errors.first("place"):null}},[r("b-input",{attrs:{id:"place",name:"place",expanded:""},model:{value:t.form.place,callback:function(e){t.$set(t.form,"place",e)},expression:"form.place"}})],1):t._e(),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.publications.page_count"),"label-for":"page_count",type:t.form.errors.has("page_count")?"is-danger":null,message:t.form.errors.has("page_count")?t.form.errors.first("page_count"):null}},[r("b-input",{attrs:{id:"page_count",name:"page_count",expanded:""},model:{value:t.form.page_count,callback:function(e){t.$set(t.form,"page_count",e)},expression:"form.page_count"}})],1),t._v(" "),t.typeHasPageRange?r("b-field",{attrs:{label:t.trans("labels.publications.page_range"),"label-for":"page_range",type:t.form.errors.has("page_range")?"is-danger":null,message:t.form.errors.has("page_range")?t.form.errors.first("page_range"):null}},[r("b-input",{attrs:{id:"page_range",name:"page_range",expanded:""},model:{value:t.form.page_range,callback:function(e){t.$set(t.form,"page_range",e)},expression:"form.page_range"}})],1):t._e(),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.publications.doi"),"label-for":"doi",type:t.form.errors.has("doi")?"is-danger":null,message:t.form.errors.has("doi")?t.form.errors.first("doi"):null}},[r("b-input",{attrs:{id:"doi",name:"doi",expanded:""},model:{value:t.form.doi,callback:function(e){t.$set(t.form,"doi",e)},expression:"form.doi"}})],1),t._v(" "),r("b-field",{attrs:{"label-for":"citation",type:t.form.errors.has("citation")?"is-danger":null,message:t.form.errors.has("citation")?t.form.errors.first("citation"):null}},[r("label",{staticClass:"label",attrs:{slot:"label",for:"citation"},slot:"label"},[r("span",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:t.trans("labels.publications.citation_tooltip")},expression:"{content: trans('labels.publications.citation_tooltip')}"}],staticClass:"is-dashed"},[t._v("\n            "+t._s(t.trans("labels.publications.citation"))+"\n          ")])]),t._v(" "),r("b-input",{attrs:{id:"citation",type:"textarea",name:"citation",expanded:""},model:{value:t.form.citation,callback:function(e){t.$set(t.form,"citation",e)},expression:"form.citation"}})],1)],1),t._v(" "),r("div",{staticClass:"column"},[r("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.publications.authors"),type:t.form.errors.has("authors")?"is-danger":null,message:t.form.errors.has("authors")?t.form.errors.first("authors"):null,addons:!1}},[t._l(t.form.authors,function(e,s){return r("b-field",{key:s,attrs:{type:t.authorHasError(s)?"is-danger":null,message:t.authorHasError(s)?t.getAuthorError(s):null,expanded:"",addons:!1}},[r("b-field",{attrs:{type:t.authorHasError(s)?"is-danger":null,expanded:""}},[r("b-input",{attrs:{name:"authors["+s+"][first_name]",placeholder:t.trans("labels.publications.first_name"),expanded:""},model:{value:t.form.authors[s].first_name,callback:function(e){t.$set(t.form.authors[s],"first_name",e)},expression:"form.authors[i].first_name"}}),t._v(" "),r("b-input",{attrs:{name:"authors["+s+"][last_name]",placeholder:t.trans("labels.publications.last_name"),expanded:""},model:{value:t.form.authors[s].last_name,callback:function(e){t.$set(t.form.authors[s],"last_name",e)},expression:"form.authors[i].last_name"}}),t._v(" "),r("p",{staticClass:"control"},[r("button",{staticClass:"button is-danger is-outlined",attrs:{type:"button"},on:{click:function(e){return t.removeAuthor(s)}}},[r("b-icon",{attrs:{icon:"times",size:"is-small"}})],1)])],1)],1)}),t._v(" "),r("button",{staticClass:"button is-secondary is-outlined",attrs:{type:"button"},on:{click:t.addAuthor}},[t._v("\n          "+t._s(t.trans("labels.publications.add_author"))+"\n        ")])],2),t._v(" "),t.typeHasEditors?r("b-field",{class:{"is-required":t.typeRequiresEditors},attrs:{label:t.trans("labels.publications.editors"),type:t.form.errors.has("editors")?"is-danger":null,message:t.form.errors.has("editors")?t.form.errors.first("editors"):null,addons:!1}},[t._l(t.form.editors,function(e,s){return r("b-field",{key:s,attrs:{type:t.editorHasError(s)?"is-danger":null,message:t.editorHasError(s)?t.getEditorError(s):null,expanded:"",addons:!1}},[r("b-field",{attrs:{type:t.editorHasError(s)?"is-danger":null,expanded:""}},[r("b-input",{attrs:{name:"editors["+s+"][first_name]",placeholder:t.trans("labels.publications.first_name"),expanded:""},model:{value:t.form.editors[s].first_name,callback:function(e){t.$set(t.form.editors[s],"first_name",e)},expression:"form.editors[i].first_name"}}),t._v(" "),r("b-input",{attrs:{name:"editors["+s+"][last_name]",placeholder:t.trans("labels.publications.last_name"),expanded:""},model:{value:t.form.editors[s].last_name,callback:function(e){t.$set(t.form.editors[s],"last_name",e)},expression:"form.editors[i].last_name"}}),t._v(" "),r("p",{staticClass:"control"},[r("button",{staticClass:"button is-danger is-outlined",attrs:{type:"button"},on:{click:function(e){return t.removeEditor(s)}}},[r("b-icon",{attrs:{icon:"times",size:"is-small"}})],1)])],1)],1)}),t._v(" "),r("button",{staticClass:"button is-secondary is-outlined",attrs:{type:"button"},on:{click:t.addEditor}},[t._v("\n          "+t._s(t.trans("labels.publications.add_editor"))+"\n        ")])],2):t._e(),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.publications.link"),type:t.form.errors.has("link")?"is-danger":null,message:t.form.errors.has("link")?t.form.errors.first("link"):null}},[r("b-input",{attrs:{name:"link",expanded:""},model:{value:t.form.link,callback:function(e){t.$set(t.form,"link",e)},expression:"form.link"}})],1),t._v(" "),r("b-field",{attrs:{label:t.trans("labels.publications.attachment")}},[r("nz-publication-attachment-upload",{attrs:{"attachment-name":t.form.attachment?t.form.attachment.original_name:null},on:{uploaded:t.handleAttachmentUploaded,removed:t.handleRemovedAttachment}})],1)],1)]),t._v(" "),r("hr"),t._v(" "),r("button",{staticClass:"button is-primary",attrs:{type:"submit"}},[t._v(t._s(t.trans("buttons.save")))]),t._v(" "),r("a",{staticClass:"button",attrs:{href:t.cancelUrl}},[t._v(t._s(t.trans("buttons.cancel")))])])},[],!1,null,null,null);e.default=b.exports},mk2N:function(t,e,r){"use strict";var s=r("5YJQ"),i=r.n(s),n=r("JZM8"),a=r.n(n),o=r("mwIZ"),l=r.n(o),u=r("Y+p1"),c=r.n(u);function m(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),r.push.apply(r,s)}return r}function f(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}e.a={name:"nzFieldObservationForm",props:{action:{type:String,required:!0},method:{type:String,default:"POST"},redirectUrl:String,cancelUrl:String,submitMore:Boolean,shouldConfirmSubmit:Boolean,confirmSubmitMessage:{type:String,default:function(){return this.trans("You are about to submit")}},shouldAskReason:Boolean,shouldConfirmCancel:Boolean,submitOnlyDirty:Boolean,submitOnlyDirtyMessage:{type:String,default:function(){return this.trans("There are no changes, the data will not be saved.")}}},data:function(){return{form:this.newForm(),keepAfterSubmit:[],submittingWithRedirect:!1,submittingWithoutRedirect:!1,confirmingSubmit:!1,confirmingCancel:!1,locale:window.App.locale}},created:function(){document.addEventListener("keyup",this.registerKeyListener)},beforeDestroy:function(){document.removeEventListener("keyup",this.registerKeyListener)},methods:{newForm:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return new i.a(t,{resetOnSuccess:!1})},registerKeyListener:function(t){var e=13===(t.which||t.keyCode);t.ctrlKey&&t.shiftKey&&e?this.submitMore&&this.submitWithoutRedirect():t.ctrlKey&&e&&this.submitWithRedirect()},confirmSubmit:function(t){var e=this;if(!this.confirmingSubmit){this.confirmingSubmit=!0;var r={message:this.confirmSubmitMessage,confirmText:this.trans("buttons.save"),cancelText:this.trans("buttons.cancel"),onConfirm:t,onCancel:function(){e.confirmingSubmit=!1}};return this.shouldAskReason?this.promptForReason(r):this.$buefy.dialog.confirm(r)}},promptForReason:function(t){var e=this,r=this.$buefy.dialog.prompt(function(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?m(r,!0).forEach(function(e){f(t,e,r[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):m(r).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))})}return t}({},t,{inputAttrs:{placeholder:this.trans("Reason"),required:!0,maxlength:255}}));return r.$nextTick(function(){r.$refs.input.addEventListener("invalid",function(t){t.target.setCustomValidity(""),t.target.validity.valid||t.target.setCustomValidity(e.trans("This field is required and can contain max 255 chars."))}),r.$refs.input.addEventListener("input",function(t){r.validationMessage=null})}),r},notifyNoChanges:function(){this.$buefy.toast.open({message:this.submitOnlyDirtyMessage,type:"is-info"})},notifyNoChangesAndRedirect:function(){var t=this;this.notifyNoChanges(),setTimeout(function(){t.redirectUrl&&(window.location.href=t.redirectUrl)},500)},submitWithRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChangesAndRedirect():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithRedirect):void this.performSubmitWithRedirect()},performSubmitWithRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithRedirect:function(){var t=this;this.form.processing=!0,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"}),setTimeout(function(){t.form.processing=!1,t.submittingWithRedirect=!1,t.hookAfterSubmitWithRedirect(),t.redirectUrl&&(window.location.href=t.redirectUrl)},500)},hookAfterSubmitWithRedirect:function(){},submitWithoutRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChanges():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithoutRedirect):void this.performSubmitWithoutRedirect()},performSubmitWithoutRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithoutRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithoutRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithoutRedirect:function(){this.submittingWithoutRedirect=!1,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"});var t=a()(this.form.data(),this.keepAfterSubmit);this.form.reset(),this.form.populate(t),this.hookAfterSubmitWithoutRedirect()},hookAfterSubmitWithoutRedirect:function(){},onFailedSubmit:function(t){this.submittingWithRedirect=!1,this.submittingWithoutRedirect=!1,this.$buefy.toast.open({duration:2500,message:l()(t,"response.data.message",t.message),type:"is-danger"})},isDirty:function(){return!c()(this.form.data(),this.form.initial)},confirmCancel:function(){var t=this;this.confirmingCancel||(this.confirmingCancel=!0,this.$buefy.dialog.confirm({message:this.trans("If you leave this page changes will not be saved."),onConfirm:function(){t.confirmingCancel=!1,window.location.href=t.cancelUrl},onCancel:function(){t.confirmingCancel=!1},cancelText:this.trans("buttons.stay_on_page"),confirmText:this.trans("buttons.leave_page")}))},onCancel:function(t){this.shouldConfirmCancel&&this.isDirty()&&(t.preventDefault(),this.confirmCancel())}}}}}]);
//# sourceMappingURL=26.js.map?id=a8c5a1f2acc17738e2f3