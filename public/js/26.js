(window.webpackJsonp=window.webpackJsonp||[]).push([[26],{WYMz:function(t,e,n){"use strict";var a=n("vDqi"),s=n.n(a),o=n("sEfC"),i=n.n(o),l=n("mwIZ"),r=n.n(l);function c(t){return(c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var u={name:"nzUserAutocomplete",props:{label:{type:String,default:"User"},placeholder:{type:String,default:"Search for user..."},user:{type:Object,default:null},route:{type:String,default:"api.autocomplete.users.index"},value:{type:String,default:""},error:Boolean,message:{type:String,default:null},except:{},autofocus:Boolean,disabled:Boolean},data:function(){return{data:[],selected:this.user||null,loading:!1}},computed:{icon:function(){return this.selected?"check":null}},watch:{user:function(t){this.selected=t}},methods:{fetchData:i()(function(){var t=this;if(this.value){this.data=[],this.loading=!0;var e={name:this.value};this.except&&(e.except=this.except),s.a.get(route(this.route),{params:e}).then(function(e){e.data.data.forEach(function(e){return t.data.push(e)}),t.loading=!1},function(e){t.loading=!1})}},500),onSelect:function(t){this.selected=t,this.$emit("select",t)},onInput:function(t){var e=this.getValue(this.selected);e&&e!==t&&this.onSelect(null),this.$emit("input",t),this.fetchData()},focusOnInput:function(){this.$el.querySelector("input").focus()},getValue:function(t){if(t)return"object"===c(t)?r()(t,"full_name"):t}}},d=n("KHd+"),p=Object(d.a)(u,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-field",{staticClass:"nz-user-autocomplete",attrs:{label:t.label,type:t.error?"is-danger":null,message:t.message}},[n("b-field",{attrs:{grouped:""}},[n("b-autocomplete",{attrs:{value:t.value,data:t.data,field:"full_name",loading:t.loading,icon:t.icon,placeholder:t.placeholder,expanded:"",autofocus:t.autofocus,disabled:t.disabled},on:{input:t.onInput,select:t.onSelect},scopedSlots:t._u([{key:"default",fn:function(e){return[n("div",{staticClass:"media"},[n("div",{staticClass:"media-content"},[t._v("\n            "+t._s(e.option.full_name)+" "),n("small",[t._v("<"+t._s(e.option.email)+">")])])])]}}])})],1)],1)},[],!1,null,null,null);e.a=p.exports},slQF:function(t,e,n){"use strict";var a={name:"nzImageModal",props:{items:{type:Array,default:function(){return[]}},value:{type:Number,default:0}},data:function(){return{newValue:this.value,active:!0}},computed:{openImage:function(){return this.items[this.newValue]}},watch:{newValue:function(){this.$emit("input",this.newValue)},openImage:{immediate:!0,handler:function(t){this.active=Boolean(t)}}},created:function(){document.addEventListener("keyup",this.registerKeyListener)},beforeDestroy:function(){document.removeEventListener("keyup",this.registerKeyListener)},methods:{next:function(){var t=this.newValue+1;t>=this.items.length&&(t=0),this.newValue=t},prev:function(){var t=this.newValue-1;t<0&&(t=this.items.length-1),this.newValue=t},registerKeyListener:function(t){var e=t.which||t.keyCode;37===e?this.prev():39===e&&this.next()},onClose:function(t){this.active=!1,document.documentElement.classList.remove("is-clipped"),document.body.classList.remove("is-noscroll"),this.$emit("close",t)}}},s=n("KHd+"),o=Object(s.a)(a,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-modal",{attrs:{active:t.active,"can-cancel":["escape","x"]},on:{"update:active":function(e){t.active=e},close:t.onClose}},[n("div",{staticClass:"image-modal"},[n("img",{attrs:{src:t.openImage}}),t._v(" "),t.items.length>1?n("div",{staticClass:"image-modal-navigation"},[n("div",{staticClass:"image-modal-previous",on:{click:t.prev}},[n("i",{staticClass:"fa fa-chevron-left",attrs:{"aria-hidden":"true"}})]),t._v(" "),n("div",{staticClass:"image-modal-next",on:{click:t.next}},[n("i",{staticClass:"fa fa-chevron-right",attrs:{"aria-hidden":"true"}})])]):t._e()])])},[],!1,null,null,null);e.a=o.exports},uY5l:function(t,e,n){"use strict";n.r(e);var a=n("JkKK"),s=n("WjpJ"),o=n.n(s),i=n("3wZJ"),l=n("9KKN"),r=n("2qhe"),c=n("slQF"),u=n("uuKk"),d=n("WYMz"),p=n("luGL"),f=n("DgLj");function h(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,a)}return n}function v(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function b(t,e){if(null==t)return{};var n,a,s=function(t,e){if(null==t)return{};var n,a,s={},o=Object.keys(t);for(a=0;a<o.length;a++)n=o[a],e.indexOf(n)>=0||(s[n]=t[n]);return s}(t,e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);for(a=0;a<o.length;a++)n=o[a],e.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(t,n)&&(s[n]=t[n])}return s}var m={name:"nzFieldObservationsTable",mixins:[i.a,l.a],components:{NzImageModal:c.a,NzTaxonAutocomplete:u.a,NzUserAutocomplete:d.a,NzTable:p.a,NzExportModal:f.a},props:{perPageOptions:{type:Array,default:function(){return[15,30,50,100]},validator:function(t){return t.length}},listRoute:String,viewRoute:String,editRoute:String,deleteRoute:String,approveRoute:String,markAsUnidentifiableRoute:String,moveToPendingRoute:String,empty:{type:String,default:"Nothing here."},approvable:Boolean,markableAsUnidentifiable:Boolean,movableToPending:Boolean,showStatus:Boolean,showActivityLog:Boolean,showObserver:Boolean,exportUrl:String,exportColumns:{type:Array,default:function(){return[]}}},data:function(){return{data:[],total:0,loading:!1,sortField:"id",sortOrder:"desc",page:1,perPage:this.perPageOptions[0],isImageModalActive:!1,modalImages:[],modalImageIndex:0,checkedRows:[],approving:!1,markingAsUnidentifiable:!1,movingToPending:!1,activityLog:[],showExportModal:!1}},computed:{months:function(){return a.a.months()},days:function(){return o()(1,31)},hasActions:function(){return this.approvable||this.markableAsUnidentifiable||this.movableToPending||this.exportable},actionRunning:function(){return this.approving||this.movingToPending||this.markingAsUnidentifiable},checkedIds:function(){return this.checkedRows.map(function(t){return t.id})},exportable:function(){return!(!this.exportUrl||!this.exportColumns.length)},sortBy:function(){return"".concat(this.sortField,".").concat(this.sortOrder)}},created:function(){var t=this;this.restoreState(),this.loadAsyncData(),this.$on("filter",function(){t.saveState(),t.loadAsyncData()})},methods:{loadAsyncData:function(){var t=this;this.loading=!0;var e=this.filter,n=(e.selectedTaxon,b(e,["selectedTaxon"]));return axios.get(route(this.listRoute).withQuery(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?h(n,!0).forEach(function(e){v(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):h(n).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}({},n,{sort_by:this.sortBy,page:this.page,per_page:this.perPage}))).then(function(e){var n=e.data;t.data=n.data,t.total=n.meta.total,t.loading=!1},function(){t.data=[],t.total=0,t.loading=!1})},getPersistantKeys:function(){return["sortField","sortOrder","perPage","page","newFilter","filter","filterIsActive"]},onPageChange:function(t){this.page=t,this.saveState(),this.loadAsyncData()},onSort:function(t,e){this.sortField=t,this.sortOrder=e,this.saveState(),this.loadAsyncData()},onPerPageChange:function(t){t!==this.perPage&&(this.perPage=t,this.saveState(),this.loadAsyncData())},confirmRemove:function(t){var e=this;this.$buefy.dialog.confirm({message:this.trans("Are you sure you want to delete this record?"),confirmText:this.trans("buttons.delete"),cancelText:this.trans("buttons.cancel"),type:"is-danger",onConfirm:function(){e.remove(t)}})},remove:function(t){var e=this;return axios.delete(route(this.deleteRoute,t.id)).then(function(t){e.$buefy.toast.open({message:e.trans("Record deleted"),type:"is-success"}),e.loadAsyncData()}).catch(function(t){console.error(t)})},editLink:function(t){return route(this.editRoute,t.id)},viewLink:function(t){return this.viewRoute?route(this.viewRoute,t.id):null},observationHasPhotos:function(t){return t.photos.filter(function(t){return t.url}).length>0},openImageModal:function(t,e){this.modalImageIndex=e,this.modalImages=t.map(function(t){return t.url})},onCarouselClose:function(){this.modalImages=[],this.modalImagesIndex=0},confirmApprove:function(){this.$buefy.dialog.confirm({message:this.trans("You are about to approve checked observations.<br/>Those of them that cannot be approved, will not be approved."),confirmText:this.trans("buttons.approve"),cancelText:this.trans("buttons.cancel"),type:"is-primary",onConfirm:this.approve.bind(this)})},approve:function(){this.approving=!0,axios.post(route(this.approveRoute),{field_observation_ids:this.checkedRows.map(function(t){return t.id})}).then(this.successfullyApproved).catch(this.failedToApprove)},successfullyApproved:function(){this.checkedRows=[],this.approving=!1,this.$buefy.toast.open({message:this.trans("Observations have been approved"),type:"is-success"}),this.loadAsyncData()},failedToApprove:function(t){this.approving=!1,this.$buefy.toast.open({message:this.trans("Observations cannot be approved"),type:"is-danger",duration:5e3})},confirmMarkingAsUnidentifiable:function(){var t=this,e=this.$buefy.dialog.prompt({message:this.trans("You are about to mark checked observations as unidentifiable. What's the reason?"),confirmText:this.trans("buttons.mark_unidentifiable"),cancelText:this.trans("buttons.cancel"),type:"is-warning",inputAttrs:{placeholder:this.trans("Reason"),required:!0,maxlength:255},onConfirm:this.markAsUnidentifiable.bind(this)});e.$nextTick(function(){t.validateReason(e)})},markAsUnidentifiable:function(t){this.markingAsUnidentifiable=!0,axios.post(route(this.markAsUnidentifiableRoute),{field_observation_ids:this.checkedRows.map(function(t){return t.id}),reason:t}).then(this.successfullyMarkedAsUnidentifiable).catch(this.failedToMarkAsUnidentifiable)},successfullyMarkedAsUnidentifiable:function(){this.checkedRows=[],this.markingAsUnidentifiable=!1,this.$buefy.toast.open({message:this.trans("Observations have been marked as unidentifiable"),type:"is-success"}),this.loadAsyncData()},failedToMarkAsUnidentifiable:function(t){this.markingAsUnidentifiable=!1,this.$buefy.toast.open({message:this.trans("Some of the observations cannot be marked as unidentifiable"),type:"is-danger",duration:5e3})},determineStatusIcon:function(t){return"unidentifiable"===t?"times":"approved"===t?"check":"question"},determineStatusClass:function(t){return"unidentifiable"===t?"has-text-danger":"approved"===t?"has-text-success":"has-text-info"},openActivityLogModal:function(t){this.activityLog=t.activity},validateReason:function(t){var e=this;t.$refs.input.addEventListener("invalid",function(t){t.target.setCustomValidity(""),t.target.validity.valid||t.target.setCustomValidity(e.trans("This field is required and can contain max 255 chars."))}),t.$refs.input.addEventListener("input",function(e){t.validationMessage=null})},confirmMoveToPending:function(){var t=this,e=this.$buefy.dialog.prompt({message:this.trans("You are about to move checked observations to pending. What's the reason?"),confirmText:this.trans("buttons.move_to_pending"),cancelText:this.trans("buttons.cancel"),type:"is-warning",inputAttrs:{placeholder:this.trans("Reason"),required:!0,maxlength:255},onConfirm:this.moveToPending.bind(this)});e.$nextTick(function(){t.validateReason(e)})},moveToPending:function(t){this.movingToPending=!0,axios.post(route(this.moveToPendingRoute),{field_observation_ids:this.checkedRows.map(function(t){return t.id}),reason:t}).then(this.successfullyMovedToPending).catch(this.failedToMoveToPending)},successfullyMovedToPending:function(){this.checkedRows=[],this.movingToPending=!1,this.$buefy.toast.open({message:this.trans("Observations have been moved to pending"),type:"is-success"}),this.loadAsyncData()},failedToMoveToPending:function(t){this.movingToPending=!1,this.$buefy.toast.open({message:this.trans("Whoops, looks like something went wrong."),type:"is-danger",duration:5e3}),this.loadAsyncData()},filterDefaults:function(){return{status:null,taxon:null,taxonId:null,year:null,month:null,day:null,photos:null,observer:null,includeChildTaxa:!1,selectedTaxon:null,project:null,id:null}},openExportModal:function(){this.showExportModal=!0},onExportDone:function(t){this.showExportModal=!1,t.url?this.$buefy.modal.open({parent:this,component:r.a,canCancel:[],hasModalCard:!0,props:{url:t.url}}):this.$buefy.toast.open({duration:0,message:"Something's not good, also I'm on bottom",type:"is-danger"})},onTaxonSelect:function(t){this.newFilter.taxonId=t?t.id:null,this.newFilter.selectedTaxon=t}},filters:{truncate:function(t,e){return t.length>e?t.substr(0,e)+"...":t}}},g=n("KHd+"),_=Object(g.a)(m,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"field-observations-table"},[n("div",{staticClass:"level"},[n("div",{staticClass:"level-left"},[n("div",{staticClass:"level-item"},[n("button",{staticClass:"button is-touch-full",attrs:{type:"button"},on:{click:function(e){t.showFilter=!t.showFilter}}},[n("b-icon",{class:[t.filterIsActive?"has-text-primary":"has-text-grey"],attrs:{icon:"filter",size:t.filterIsActive?null:"is-small"}}),t._v(" "),n("span",[t._v(t._s(t.trans("buttons.filters")))])],1)])]),t._v(" "),t.hasActions?n("div",{staticClass:"level-right"},[n("div",{staticClass:"level-item"},[n("b-dropdown",{attrs:{position:"is-bottom-left"}},[n("button",{staticClass:"button is-touch-full",class:{"is-loading":t.actionRunning},attrs:{slot:"trigger"},slot:"trigger"},[n("span",[t._v(t._s(t.trans("labels.actions")))]),t._v(" "),n("span",{staticClass:"icon has-text-grey"},[n("i",{staticClass:"fa fa-angle-down"})])]),t._v(" "),t.approvable?n("b-dropdown-item",{attrs:{disabled:!t.checkedRows.length},on:{click:t.confirmApprove}},[n("b-icon",{staticClass:"has-text-success",attrs:{icon:"check"}}),t._v(" "),n("span",[t._v(t._s(t.trans("buttons.approve")))])],1):t._e(),t._v(" "),t.markableAsUnidentifiable?n("b-dropdown-item",{attrs:{disabled:!t.checkedRows.length},on:{click:t.confirmMarkingAsUnidentifiable}},[n("b-icon",{staticClass:"has-text-danger",attrs:{icon:"times"}}),t._v(" "),n("span",[t._v(t._s(t.trans("buttons.unidentifiable")))])],1):t._e(),t._v(" "),t.movableToPending?n("b-dropdown-item",{attrs:{disabled:!t.checkedRows.length},on:{click:t.confirmMoveToPending}},[n("b-icon",{staticClass:"has-text-warning",attrs:{icon:"question"}}),t._v(" "),n("span",[t._v(t._s(t.trans("buttons.move_to_pending")))])],1):t._e(),t._v(" "),t.exportable?n("b-dropdown-item",{on:{click:t.openExportModal}},[n("b-icon",{staticClass:"has-text-grey",attrs:{icon:"download"}}),t._v(" "),n("span",[t._v(t._s(t.trans("buttons.export")))])],1):t._e()],1)],1)]):t._e()]),t._v(" "),n("b-collapse",{staticClass:"mt-4",attrs:{open:t.showFilter}},[n("form",{on:{submit:function(e){return e.preventDefault(),t.applyFilter(e)}}},[n("div",{staticClass:"columns is-multiline"},[n("div",{staticClass:"column is half"},[n("nz-taxon-autocomplete",{attrs:{taxon:t.newFilter.selectedTaxon,label:t.trans("labels.field_observations.taxon"),placeholder:t.trans("labels.field_observations.search_for_taxon")},on:{select:t.onTaxonSelect},model:{value:t.newFilter.taxon,callback:function(e){t.$set(t.newFilter,"taxon",e)},expression:"newFilter.taxon"}}),t._v(" "),n("b-checkbox",{model:{value:t.newFilter.includeChildTaxa,callback:function(e){t.$set(t.newFilter,"includeChildTaxa",e)},expression:"newFilter.includeChildTaxa"}},[t._v(t._s(t.trans("labels.field_observations.include_lower_taxa")))])],1),t._v(" "),n("b-field",{staticClass:"column is-half",attrs:{label:t.trans("labels.field_observations.date")}},[n("b-field",{attrs:{expanded:"",grouped:""}},[n("b-field",{attrs:{expanded:""}},[n("b-input",{attrs:{placeholder:t.trans("labels.field_observations.year")},model:{value:t.newFilter.year,callback:function(e){t.$set(t.newFilter,"year",e)},expression:"newFilter.year"}})],1),t._v(" "),n("b-field",{attrs:{expanded:""}},[n("b-select",{attrs:{placeholder:t.trans("labels.field_observations.month"),expanded:""},model:{value:t.newFilter.month,callback:function(e){t.$set(t.newFilter,"month",e)},expression:"newFilter.month"}},[n("option",{domProps:{value:null}}),t._v(" "),t._l(t.months,function(e,a){return n("option",{key:a,domProps:{value:a+1,textContent:t._s(e)}})})],2)],1),t._v(" "),n("b-field",{attrs:{expanded:""}},[n("b-select",{attrs:{placeholder:t.trans("labels.field_observations.day"),expanded:""},model:{value:t.newFilter.day,callback:function(e){t.$set(t.newFilter,"day",e)},expression:"newFilter.day"}},[n("option",{domProps:{value:null}}),t._v(" "),t._l(t.days,function(e){return n("option",{key:e,domProps:{value:e,textContent:t._s(e)}})})],2)],1)],1)],1),t._v(" "),t.showObserver?n("nz-user-autocomplete",{staticClass:"column is-half",attrs:{label:t.trans("labels.field_observations.observer"),placeholder:""},model:{value:t.newFilter.observer,callback:function(e){t.$set(t.newFilter,"observer",e)},expression:"newFilter.observer"}}):t._e(),t._v(" "),n("b-field",{staticClass:"column is-half",attrs:{label:t.trans("labels.field_observations.project")}},[n("b-input",{attrs:{expanded:""},model:{value:t.newFilter.project,callback:function(e){t.$set(t.newFilter,"project",e)},expression:"newFilter.project"}})],1),t._v(" "),n("b-field",{staticClass:"column is-one-third",attrs:{label:t.trans("labels.id")}},[n("b-input",{attrs:{expanded:""},model:{value:t.newFilter.id,callback:function(e){t.$set(t.newFilter,"id",e)},expression:"newFilter.id"}})],1),t._v(" "),t.showStatus?n("b-field",{staticClass:"column is-one-third",attrs:{label:t.trans("labels.field_observations.status")}},[n("b-select",{attrs:{expanded:""},model:{value:t.newFilter.status,callback:function(e){t.$set(t.newFilter,"status",e)},expression:"newFilter.status"}},[n("option",{domProps:{value:null}}),t._v(" "),t._l(["approved","unidentifiable","pending"],function(e,a){return n("option",{key:a,domProps:{value:e,textContent:t._s(t.trans("labels.field_observations.statuses."+e))}})})],2)],1):t._e(),t._v(" "),n("b-field",{staticClass:"column is-one-third",attrs:{label:t.trans("labels.field_observations.photos")}},[n("b-select",{attrs:{expanded:""},model:{value:t.newFilter.photos,callback:function(e){t.$set(t.newFilter,"photos",e)},expression:"newFilter.photos"}},[n("option",{domProps:{value:null}}),t._v(" "),n("option",{attrs:{value:"yes"}},[t._v(t._s(t.trans("Yes")))]),t._v(" "),n("option",{attrs:{value:"no"}},[t._v(t._s(t.trans("No")))])])],1)],1),t._v(" "),n("button",{staticClass:"button is-primary is-outlined",attrs:{type:"submit"}},[t._v(t._s(t.trans("buttons.apply")))]),t._v(" "),n("button",{staticClass:"button",attrs:{type:"button"},on:{click:t.clearFilter}},[t._v(t._s(t.trans("buttons.clear")))])])]),t._v(" "),n("hr"),t._v(" "),n("nz-table",{attrs:{data:t.data,loading:t.loading,paginated:"","backend-pagination":"",total:t.total,"per-page":t.perPage,"current-page":t.page,"per-page-options":t.perPageOptions,"pagination-on-top":"","backend-sorting":"","default-sort-direction":"asc","default-sort":[t.sortField,t.sortOrder],detailed:"","mobile-cards":!0,checkable:t.hasActions,"checked-rows":t.checkedRows},on:{"page-change":t.onPageChange,"per-page-change":t.onPerPageChange,sort:t.onSort,"update:checkedRows":function(e){t.checkedRows=e},"update:checked-rows":function(e){t.checkedRows=e}},scopedSlots:t._u([{key:"default",fn:function(e){var a=e.row;return[n("b-table-column",{attrs:{field:"id",label:t.trans("labels.id"),width:"40",numeric:"",sortable:""}},[t._v("\n        "+t._s(a.id)+"\n      ")]),t._v(" "),n("b-table-column",{attrs:{field:"taxon_name",label:t.trans("labels.field_observations.taxon"),sortable:""}},[t._v("\n        "+t._s(a.taxon?a.taxon.name:"")+"\n      ")]),t._v(" "),n("b-table-column",{attrs:{field:"year",label:t.trans("labels.field_observations.year"),numeric:"",sortable:""}},[t._v("\n        "+t._s(a.year)+"\n      ")]),t._v(" "),n("b-table-column",{attrs:{field:"month",label:t.trans("labels.field_observations.month"),numeric:"",sortable:""}},[t._v("\n        "+t._s(a.month)+"\n      ")]),t._v(" "),n("b-table-column",{attrs:{field:"day",label:t.trans("labels.field_observations.day"),numeric:"",sortable:""}},[t._v("\n        "+t._s(a.day)+"\n      ")]),t._v(" "),t.showObserver?n("b-table-column",{attrs:{field:"observer",label:t.trans("labels.field_observations.observer"),sortable:""}},[t._v("\n        "+t._s(a.observer)+"\n      ")]):t._e(),t._v(" "),t.showStatus?n("b-table-column",{attrs:{field:"status",label:t.trans("labels.field_observations.status")}},[n("span",{class:t.determineStatusClass(a.status),attrs:{title:t.trans("labels.field_observations.statuses."+a.status)}},[n("b-icon",{attrs:{icon:t.determineStatusIcon(a.status)}})],1)]):t._e(),t._v(" "),n("b-table-column",{attrs:{width:"150",numeric:""}},[t.observationHasPhotos(a)?n("a",{on:{click:function(e){return t.openImageModal(a.photos)}}},[n("b-icon",{attrs:{icon:"photo"}})],1):t._e(),t._v(" "),t.showActivityLog?n("a",{attrs:{title:t.trans("Activity Log")},on:{click:function(e){return t.openActivityLogModal(a)}}},[n("b-icon",{attrs:{icon:"history"}})],1):t._e(),t._v(" "),t.viewRoute?n("a",{attrs:{href:t.viewLink(a),title:t.trans("buttons.view")}},[n("b-icon",{attrs:{icon:"eye"}})],1):t._e(),t._v(" "),t.editRoute?n("a",{attrs:{href:t.editLink(a),title:t.trans("buttons.edit")}},[n("b-icon",{attrs:{icon:"edit"}})],1):t._e(),t._v(" "),t.deleteRoute?n("a",{attrs:{title:t.trans("buttons.delete")},on:{click:function(e){return t.confirmRemove(a)}}},[n("b-icon",{attrs:{icon:"trash"}})],1):t._e()])]}},{key:"detail",fn:function(e){var a=e.row;return[n("article",{staticClass:"media"},[n("figure",{staticClass:"media-left"},t._l(a.photos,function(e,s){return n("p",{key:e.id,staticClass:"image is-64x64"},[n("img",{staticClass:"is-clickable",attrs:{src:e.url},on:{click:function(e){return t.openImageModal(a.photos,s)}}})])}),0),t._v(" "),n("div",{staticClass:"media-content"},[n("div",{staticClass:"content"},[a.location?[n("strong",[t._v(t._s(a.location))]),n("br")]:t._e(),t._v(" "),a.latitude&&a.longitude?[n("small",[t._v(t._s(a.latitude)+", "+t._s(a.longitude))]),n("br")]:t._e(),t._v(" "),n("small",[t._v(t._s(a.mgrs10k.replace(/^[0-9]+[a-zA-Z]/,"$& ")))]),n("br"),t._v(" "),n("small",[t._v(t._s(t.trans("labels.field_observations.elevation"))+": "+t._s(a.elevation)+"m")]),n("br"),t._v(" "),a.accuracy?n("small",[t._v(t._s(t.trans("labels.field_observations.accuracy"))+": "+t._s(a.accuracy)+"m")]):t._e()],2)])])]}}])},[t._v(" "),n("template",{slot:"empty"},[n("section",{staticClass:"section"},[n("div",{staticClass:"content has-text-grey has-text-centered"},[n("p",[t._v(t._s(t.empty))])])])])],2),t._v(" "),n("nz-image-modal",{attrs:{items:t.modalImages},on:{close:t.onCarouselClose},model:{value:t.modalImageIndex,callback:function(e){t.modalImageIndex=e},expression:"modalImageIndex"}}),t._v(" "),n("b-modal",{attrs:{active:t.activityLog.length>0},on:{close:function(e){t.activityLog=[]}}},[n("div",{staticClass:"modal-card"},[n("div",{staticClass:"modal-card-head"},[n("b-icon",{attrs:{icon:"history"}}),t._v(" "),n("p",{staticClass:"modal-card-title"},[t._v(t._s(t.trans("Activity Log")))])],1),t._v(" "),n("div",{staticClass:"modal-card-body"},[n("nz-field-observation-activity-log",{attrs:{activities:t.activityLog}})],1)])]),t._v(" "),n("b-modal",{attrs:{active:t.showExportModal,"has-modal-card":"","can-cancel":[]},on:{close:function(e){t.showExportModal=!1}}},[n("nz-export-modal",{attrs:{checked:t.checkedIds,filter:t.filter,columns:t.exportColumns,url:t.exportUrl,sort:t.sortBy},on:{cancel:function(e){t.showExportModal=!1},done:t.onExportDone}})],1)],1)},[],!1,null,null,null);e.default=_.exports},uuKk:function(t,e,n){"use strict";var a=n("vDqi"),s=n.n(a),o=n("sEfC"),i=n.n(o),l=n("mwIZ"),r=n.n(l);function c(t){return(c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var u={name:"nzTaxonAutocomplete",props:{label:{type:String,default:"Taxon"},placeholder:{type:String,default:"Search for taxon..."},taxon:{type:Object,default:null},url:{type:String,default:function(){return route("api.taxa.index")}},value:{type:String,default:""},error:Boolean,message:{type:String,default:null},except:{},autofocus:Boolean},data:function(){return{data:[],selected:this.taxon||null,loading:!1}},computed:{haveThumbnail:function(){return this.selected&&this.selected.thumbnail_url},icon:function(){return this.selected?"check":"search"}},watch:{taxon:function(t){this.selected=t}},methods:{fetchData:i()(function(){var t=this;if(this.value){this.data=[],this.loading=!0;var e={name:this.value,limit:20};this.except&&(e.except=this.except),s.a.get(this.url,{params:e}).then(function(e){e.data.data.forEach(function(e){return t.data.push(e)}),t.loading=!1},function(e){t.loading=!1})}},500),onSelect:function(t){this.selected=t,this.$emit("select",t)},onInput:function(t){var e=this.getValue(this.selected);e&&e!==t&&this.onSelect(null),this.$emit("input",t),this.fetchData()},focusOnInput:function(){this.$el.querySelector("input").focus()},getValue:function(t){if(t)return"object"===c(t)?r()(t,"name"):t},enterPressed:function(){this.$refs.autocomplete.isActive||this.$emit("enter")}}},d=n("KHd+"),p=Object(d.a)(u,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-field",{staticClass:"nz-taxon-autocomplete",attrs:{label:t.label,type:t.error?"is-danger":null,message:t.message}},[n("b-field",{attrs:{grouped:""}},[t.haveThumbnail?n("img",{attrs:{width:"32",src:this.selected.thumbnail_url}}):t._e(),t._v(" "),n("b-autocomplete",{ref:"autocomplete",attrs:{value:t.value,data:t.data,field:"name",loading:t.loading,icon:t.icon,placeholder:t.placeholder,expanded:"",autofocus:t.autofocus},on:{input:t.onInput,select:t.onSelect},nativeOn:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.enterPressed(e)}},scopedSlots:t._u([{key:"default",fn:function(e){return[n("div",{staticClass:"media"},[n("div",{staticClass:"media-left"},[e.option.thumbnail_url?n("img",{attrs:{width:"32",src:e.option.thumbnail_url}}):t._e()]),t._v(" "),n("div",{staticClass:"media-content"},[t._v("\n            "+t._s(e.option.name)+t._s(e.option.native_name?" ("+e.option.native_name+")":"")+"\n          ")])])]}}])})],1)],1)},[],!1,null,null,null);e.a=p.exports}}]);
//# sourceMappingURL=26.js.map?id=bbc06add7a758a2f200a