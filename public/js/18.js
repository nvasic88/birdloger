(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{BiGR:function(t,e,n){var i=n("nmnc"),s=n("03A+"),r=n("Z0cm"),a=i?i.isConcatSpreadable:void 0;t.exports=function(t){return r(t)||s(t)||!!(a&&t&&t[a])}},FZoo:function(t,e,n){var i=n("MrPd"),s=n("4uTw"),r=n("wJg7"),a=n("GoyQ"),o=n("9Nap");t.exports=function(t,e,n,l){if(!a(t))return t;for(var u=-1,c=(e=s(e,t)).length,d=c-1,m=t;null!=m&&++u<c;){var f=o(e[u]),b=n;if("__proto__"===f||"constructor"===f||"prototype"===f)return t;if(u!=d){var h=m[f];void 0===(b=l?l(h,f,m):void 0)&&(b=a(h)?h:r(e[u+1])?[]:{})}i(m,f,b),m=m[f]}return t}},FfPP:function(t,e,n){var i=n("idmN"),s=n("hgQt");t.exports=function(t,e){return i(t,e,(function(e,n){return s(t,n)}))}},JZM8:function(t,e,n){var i=n("FfPP"),s=n("xs/l")((function(t,e){return null==t?{}:i(t,e)}));t.exports=s},QIyF:function(t,e,n){var i=n("Kz5y");t.exports=function(){return i.Date.now()}},TYy9:function(t,e,n){var i=n("XGnz");t.exports=function(t){return(null==t?0:t.length)?i(t,1):[]}},XGnz:function(t,e,n){var i=n("CH3K"),s=n("BiGR");t.exports=function t(e,n,r,a,o){var l=-1,u=e.length;for(r||(r=s),o||(o=[]);++l<u;){var c=e[l];n>0&&r(c)?n>1?t(c,n-1,r,a,o):i(o,c):a||(o[o.length]=c)}return o}},idmN:function(t,e,n){var i=n("ZWtO"),s=n("FZoo"),r=n("4uTw");t.exports=function(t,e,n){for(var a=-1,o=e.length,l={};++a<o;){var u=e[a],c=i(t,u);n(c,u)&&s(l,r(u,t),c)}return l}},mk2N:function(t,e,n){"use strict";var i=n("5YJQ"),s=n.n(i),r=n("JZM8"),a=n.n(r),o=n("mwIZ"),l=n.n(o),u=n("Y+p1"),c=n.n(u);function d(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,i)}return n}function m(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?d(Object(n),!0).forEach((function(e){f(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):d(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function f(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}e.a={name:"nzFieldObservationForm",props:{action:{type:String,required:!0},method:{type:String,default:"POST"},redirectUrl:String,cancelUrl:String,submitMore:Boolean,shouldConfirmSubmit:Boolean,confirmSubmitMessage:{type:String,default:function(){return this.trans("You are about to submit")}},shouldAskReason:Boolean,shouldConfirmCancel:Boolean,submitOnlyDirty:Boolean,submitOnlyDirtyMessage:{type:String,default:function(){return this.trans("There are no changes, the data will not be saved.")}}},data:function(){return{form:this.newForm(),keepAfterSubmit:[],submittingWithRedirect:!1,submittingWithoutRedirect:!1,confirmingSubmit:!1,confirmingCancel:!1,locale:window.App.locale}},created:function(){document.addEventListener("keyup",this.registerKeyListener)},beforeDestroy:function(){document.removeEventListener("keyup",this.registerKeyListener)},methods:{newForm:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return new s.a(t,{resetOnSuccess:!1})},registerKeyListener:function(t){var e=13===(t.which||t.keyCode);t.ctrlKey&&t.shiftKey&&e?this.submitMore&&this.submitWithoutRedirect():t.ctrlKey&&e&&this.submitWithRedirect()},confirmSubmit:function(t){var e=this;if(!this.confirmingSubmit){this.confirmingSubmit=!0;var n={message:this.confirmSubmitMessage,confirmText:this.trans("buttons.save"),cancelText:this.trans("buttons.cancel"),onConfirm:t,onCancel:function(){e.confirmingSubmit=!1}};return this.shouldAskReason?this.promptForReason(n):this.$buefy.dialog.confirm(n)}},promptForReason:function(t){var e=this,n=this.$buefy.dialog.prompt(m(m({},t),{},{inputAttrs:{placeholder:this.trans("Reason"),required:!0,maxlength:255}}));return n.$nextTick((function(){n.$refs.input.addEventListener("invalid",(function(t){t.target.setCustomValidity(""),t.target.validity.valid||t.target.setCustomValidity(e.trans("This field is required and can contain max 255 chars."))})),n.$refs.input.addEventListener("input",(function(t){n.validationMessage=null}))})),n},notifyNoChanges:function(){this.$buefy.toast.open({message:this.submitOnlyDirtyMessage,type:"is-info"})},notifyNoChangesAndRedirect:function(){var t=this;this.notifyNoChanges(),setTimeout((function(){t.redirectUrl&&(window.location.href=t.redirectUrl)}),500)},submitWithRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChangesAndRedirect():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithRedirect):void this.performSubmitWithRedirect()},performSubmitWithRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithRedirect:function(){var t=this;this.form.processing=!0,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"}),setTimeout((function(){t.form.processing=!1,t.submittingWithRedirect=!1,t.hookAfterSubmitWithRedirect(),t.redirectUrl&&(window.location.href=t.redirectUrl)}),500)},hookAfterSubmitWithRedirect:function(){},submitWithoutRedirect:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChanges():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithoutRedirect):void this.performSubmitWithoutRedirect()},performSubmitWithoutRedirect:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithoutRedirect=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithoutRedirect).catch(this.onFailedSubmit)},onSuccessfulSubmitWithoutRedirect:function(){this.submittingWithoutRedirect=!1,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"});var t=a()(this.form.data(),this.keepAfterSubmit);this.form.reset(),this.form.populate(t),this.hookAfterSubmitWithoutRedirect()},hookAfterSubmitWithoutRedirect:function(){},onFailedSubmit:function(t){this.submittingWithRedirect=!1,this.submittingWithoutRedirect=!1,this.$buefy.toast.open({duration:2500,message:l()(t,"response.data.message",t.message),type:"is-danger"})},isDirty:function(){return!c()(this.form.data(),this.form.initial)},confirmCancel:function(){var t=this;this.confirmingCancel||(this.confirmingCancel=!0,this.$buefy.dialog.confirm({message:this.trans("If you leave this page changes will not be saved."),onConfirm:function(){t.confirmingCancel=!1,window.location.href=t.cancelUrl},onCancel:function(){t.confirmingCancel=!1},cancelText:this.trans("buttons.stay_on_page"),confirmText:this.trans("buttons.leave_page")}))},onCancel:function(t){this.shouldConfirmCancel&&this.isDirty()&&(t.preventDefault(),this.confirmCancel())}}}},nvJa:function(t,e,n){"use strict";n.r(e);var i=n("5YJQ"),s=n.n(i),r=n("7GkX"),a=n.n(r),o=n("J2m7"),l=n.n(o),u=n("afOK"),c=n.n(u),d=n("mwIZ"),m=n.n(d),f=n("mk2N"),b=n("xWf0"),h=n("uuKk");function p(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,i)}return n}function v(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?p(Object(n),!0).forEach((function(e){_(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):p(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function _(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function y(){var t={};return a()(window.App.supportedLocales).forEach((function(e){t[e]=null})),t}var g={name:"nzTaxonForm",mixins:[f.a],components:{NzWysiwyg:b.a,NzTaxonAutocomplete:h.a},props:{taxon:{type:Object,default:function(){return{name:null,parent_id:null,rank:"species",rank_level:10,author:null,fe_id:null,conservation_legislations:[],conservation_documents:[],red_lists:[],stages:[],synonyms:[],annexes:[],uses_atlas_codes:!0,restricted:!1,allochthonous:!1,invasive:!1,refer:!1,prior:!1,strictly_protected:!1,protected:!1,strictly_note:null,protected_note:null,spid:null,birdlife_seq:null,birdlife_id:null,ebba_code:null,euring_code:null,euring_sci_name:null,eunis_n2000code:null,eunis_sci_name:null,bioras_sci_name:null,gn_status:null,type:"RS",iucn_cat:null,sp:null,full_sci_name:null,family_id:null}}},ranks:Array,conservationLegislations:Array,conservationDocuments:Array,redListCategories:Array,redLists:{type:Array,default:function(){return[]}},stages:Array,annexes:Array,nativeNames:{type:Object,default:function(){return y()}},descriptions:{type:Object,default:function(){return y()}},synonymNames:{type:Array,default:function(){return[]}}},data:function(){return{form:this.newForm(),parentName:m()(this.taxon,"parent.name"),selectedParent:null,chosenRedList:null,synonym_name:null,synonyms:this.taxon.synonyms}},computed:{rankOptions:function(){var t=this;return this.selectedParent?this.ranks.filter((function(e){return e.level<t.selectedParent.rank_level})):this.ranks},supportedLocales:function(){return window.App.supportedLocales}},watch:{selectedParent:function(t){this.shouldResetRank(t)&&(this.form.rank=null)}},methods:{newForm:function(){return new s.a(v(v({},this.taxon),{},{stages_ids:this.taxon.stages.map((function(t){return t.id})),annexes_ids:this.taxon.annexes.map((function(t){return t.id})),conservation_legislations_ids:this.taxon.conservation_legislations.map((function(t){return t.id})),conservation_documents_ids:this.taxon.conservation_documents.map((function(t){return t.id})),red_lists_data:this.taxon.red_lists.map((function(t){return{red_list_id:t.id,category:t.pivot.category}})),synonyms:this.taxon.synonyms,native_name:this.nativeNames,description:this.descriptions,reason:null,uses_atlas_codes:this.taxon.uses_atlas_codes,spid:this.taxon.spid,birdlife_seq:this.taxon.birdlife_seq,birdlife_id:this.taxon.birdlife_id,ebba_code:this.taxon.ebba_code,euring_code:this.taxon.euring_code,euring_sci_name:this.taxon.euring_sci_name,eunis_n2000code:this.taxon.eunis_n2000code,eunis_sci_name:this.taxon.eunis_sci_name,bioras_sci_name:this.taxon.bioras_sci_name,prior:this.taxon.prior,gn_status:this.taxon.gn_status,type:this.taxon.type,family_name:this.taxon.family_id?this.taxon.family.name:"",order_name:this.taxon.family_id?this.taxon.family.order.name:"",strictly_note:this.taxon.strictly_note,protected_note:this.taxon.protected_note,iucn_cat:this.taxon.iucn_cat,sp:this.taxon.sp,full_sci_name:this.taxon.full_sci_name,family_id:this.taxon.family_id?this.taxon.family_id:0,synonym_names:this.synonymNames}),{resetOnSuccess:!1})},loadAsyncData:function(){var t=this;return this.loading=!0,axios.get(route(this.listRoute).withQuery({sort_by:"".concat(this.sortField,".").concat(this.sortOrder),page:this.page,per_page:this.perPage})).then((function(e){var n=e.data;t.data=[],t.total=n.meta.total,n.data.forEach((function(e){return t.data.push(e)})),t.loading=!1}),(function(e){t.data=[],t.total=0,t.loading=!1}))},removeSynonym:function(t){axios.delete(route("api.synonyms.destroy",this.synonyms[t])),this.$delete(this.synonyms,t)},removeSynonymName:function(t){this.$delete(this.synonymNames,t)},addSynonym:function(){this.synonym_name&&(this.synonymNames.push(this.synonym_name),this.synonym_name=null)},addRedList:function(){this.chosenRedList&&(this.form.red_lists_data.push({red_list_id:this.chosenRedList.id,category:c()(this.redListCategories)}),this.chosenRedList=null)},onTaxonSelect:function(t){this.selectedParent=t,this.form.parent_id=t?t.id:null,t&&t.stages.length&&(this.form.stages_ids=t.stages.map((function(t){return t.id})))},shouldResetRank:function(t){return t&&this.getRankLevel(this.form.rank)>=t.rank_level},getRankLevel:function(t){return m()(l()(this.ranks,{value:t}),"level")},focusOnTranslation:function(t,e){var n=this,i=a()(this.supportedLocales),s="".concat(e,"-").concat(i[t]);setTimeout((function(){c()(n.$refs[s]).focus()}),500)}},loadSynonyms:function(){if(!this.taxon.synonyms)return[];var t=[];return this.taxon.synonyms.forEach((function(e){return t.push(e.name)})),t}},x=n("KHd+"),C=Object(x.a)(g,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("form",{attrs:{action:t.action,method:"POST"},on:{submit:function(e){return e.preventDefault(),t.submitWithRedirect(e)}}},[n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-6"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.taxa.name"),type:t.form.errors.has("name")?"is-danger":"",message:t.form.errors.has("name")?t.form.errors.first("name"):""}},[n("b-input",{model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1)],1),t._v(" "),n("div",{staticClass:"column is-3"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("taxonomy.order"),type:t.form.errors.has("order")?"is-danger":"",message:t.form.errors.has("order")?t.form.errors.first("order"):""}},[n("b-input",{model:{value:t.form.order_name,callback:function(e){t.$set(t.form,"order_name",e)},expression:"form.order_name"}})],1)],1),t._v(" "),n("div",{staticClass:"column is-3"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("taxonomy.family"),type:t.form.errors.has("family")?"is-danger":"",message:t.form.errors.has("family")?t.form.errors.first("family"):""}},[n("b-input",{model:{value:t.form.family_name,callback:function(e){t.$set(t.form,"family_name",e)},expression:"form.family_name"}},[t._v("A")])],1)],1)]),t._v(" "),n("b-field",{attrs:{label:t.trans("labels.taxa.author"),type:t.form.errors.has("author")?"is-danger":"",message:t.form.errors.has("author")?t.form.errors.first("author"):""}},[n("b-input",{model:{value:t.form.author,callback:function(e){t.$set(t.form,"author",e)},expression:"form.author"}})],1),t._v(" "),n("hr"),t._v(" "),n("b-field",{attrs:{label:t.trans("labels.taxa.native_name")}},[n("b-tabs",{staticClass:"block",attrs:{size:"is-small"},on:{change:function(e){return t.focusOnTranslation(e,"native_name")}}},t._l(t.supportedLocales,(function(e,i){return n("b-tab-item",{key:i,attrs:{label:t.trans("languages."+e.name)}},[n("b-input",{ref:"native_name-"+i,refInFor:!0,model:{value:t.form.native_name[i],callback:function(e){t.$set(t.form.native_name,i,e)},expression:"form.native_name[locale]"}})],1)})),1)],1),t._v(" "),t._e(),t._v(" "),n("hr"),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.refer")}},[n("b-switch",{model:{value:t.form.refer,callback:function(e){t.$set(t.form,"refer",e)},expression:"form.refer"}},[t._v("\n          "+t._s(t.form.refer?t.trans("Yes"):t.trans("No"))+"\n        ")])],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.prior")}},[n("b-switch",{model:{value:t.form.prior,callback:function(e){t.$set(t.form,"prior",e)},expression:"form.prior"}},[t._v("\n          "+t._s(t.form.prior?t.trans("Yes"):t.trans("No"))+"\n        ")])],1)],1),t._v(" "),n("div",{staticClass:"column"},[t._e()],1),t._v(" "),n("div",{staticClass:"column"},[t._e()],1),t._v(" "),n("div",{staticClass:"column"},[t._e()],1)]),t._v(" "),n("div",[n("b-field",{attrs:{label:t.trans("labels.taxa.annex")}},[n("div",{staticClass:"block"},t._l(t.annexes,(function(e){return n("b-checkbox",{key:e.id,attrs:{"native-value":e.id},model:{value:t.form.annexes_ids,callback:function(e){t.$set(t.form,"annexes_ids",e)},expression:"form.annexes_ids"}},[t._v("\n          "+t._s(e.name)+"\n        ")])})),1)])],1),t._v(" "),n("hr"),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.taxa.spid"),type:t.form.errors.has("spid")?"is-danger":"",message:t.form.errors.has("spid")?t.form.errors.first("spid"):""}},[n("b-input",{attrs:{maxlength:"10"},model:{value:t.form.spid,callback:function(e){t.$set(t.form,"spid",e)},expression:"form.spid"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.taxa.birdlife_seq"),type:t.form.errors.has("birdlife_seq")?"is-danger":"",message:t.form.errors.has("birdlife_seq")?t.form.errors.first("birdlife_seq"):""}},[n("b-input",{attrs:{type:"number"},model:{value:t.form.birdlife_seq,callback:function(e){t.$set(t.form,"birdlife_seq",e)},expression:"form.birdlife_seq"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.taxa.birdlife_id"),type:t.form.errors.has("birdlife_id")?"is-danger":"",message:t.form.errors.has("birdlife_id")?t.form.errors.first("birdlife_id"):""}},[n("b-input",{attrs:{type:"number"},model:{value:t.form.birdlife_id,callback:function(e){t.$set(t.form,"birdlife_id",e)},expression:"form.birdlife_id"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.ebba_code"),type:t.form.errors.has("ebba_code")?"is-danger":"",message:t.form.errors.has("ebba_code")?t.form.errors.first("ebba_code"):""}},[n("b-input",{attrs:{type:"number"},model:{value:t.form.ebba_code,callback:function(e){t.$set(t.form,"ebba_code",e)},expression:"form.ebba_code"}})],1)],1)]),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.euring_code"),type:t.form.errors.has("euring_code")?"is-danger":"",message:t.form.errors.has("euring_code")?t.form.errors.first("euring_code"):""}},[n("b-input",{attrs:{type:"number"},model:{value:t.form.euring_code,callback:function(e){t.$set(t.form,"euring_code",e)},expression:"form.euring_code"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.euring_sci_name"),type:t.form.errors.has("euring_sci_name")?"is-danger":"",message:t.form.errors.has("euring_sci_name")?t.form.errors.first("euring_sci_name"):""}},[n("b-input",{attrs:{maxlength:"100"},model:{value:t.form.euring_sci_name,callback:function(e){t.$set(t.form,"euring_sci_name",e)},expression:"form.euring_sci_name"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.eunis_n2000code")}},[n("b-input",{attrs:{maxlength:"10"},model:{value:t.form.eunis_n2000code,callback:function(e){t.$set(t.form,"eunis_n2000code",e)},expression:"form.eunis_n2000code"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.eunis_sci_name")}},[n("b-input",{attrs:{maxlength:"100"},model:{value:t.form.eunis_sci_name,callback:function(e){t.$set(t.form,"eunis_sci_name",e)},expression:"form.eunis_sci_name"}})],1)],1)]),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.bioras_sci_name")}},[n("b-input",{attrs:{maxlength:"200"},model:{value:t.form.bioras_sci_name,callback:function(e){t.$set(t.form,"bioras_sci_name",e)},expression:"form.bioras_sci_name"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.full_sci_name")}},[n("b-input",{attrs:{maxlength:"200"},model:{value:t.form.full_sci_name,callback:function(e){t.$set(t.form,"full_sci_name",e)},expression:"form.full_sci_name"}})],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.gn_status"),"label-for":"gn_status",type:t.form.errors.has("gn_status")?"is-danger":null,message:t.form.errors.has("gn_status")?t.form.errors.first("gn_status"):null}},[n("b-select",{attrs:{expanded:""},model:{value:t.form.gn_status,callback:function(e){t.$set(t.form,"gn_status",e)},expression:"form.gn_status"}},[n("option",{domProps:{value:null}},[t._v(t._s(t.trans("labels.field_observations.choose_a_value")))]),t._v(" "),n("option",{attrs:{value:"I"}},[t._v("Negnezdarica - iščezla vrsta")]),t._v(" "),n("option",{attrs:{value:"IG"}},[t._v("Negnezdarica - iščezla gnezdeća populacija")]),t._v(" "),n("option",{attrs:{value:"NG"}},[t._v("Negnezdarica")]),t._v(" "),n("option",{attrs:{value:"G0"}},[t._v("Gnezdarica - bez gnezdećih datuma")]),t._v(" "),n("option",{attrs:{value:"G"}},[t._v("Gnezdarica")]),t._v(" "),n("option",{attrs:{value:"G*"}},[t._v("Gnezdarica - sa uslovnim gnezdećim datumima")])])],1)],1),t._v(" "),n("div",{staticClass:"column"},[n("b-field",{attrs:{label:t.trans("labels.taxa.iucn_cat"),"label-for":"iucn_cat",type:t.form.errors.has("iucn_cat")?"is-danger":null,message:t.form.errors.has("iucn_cat")?t.form.errors.first("iucn_cat"):null}},[n("b-select",{attrs:{expanded:""},model:{value:t.form.iucn_cat,callback:function(e){t.$set(t.form,"iucn_cat",e)},expression:"form.iucn_cat"}},[n("option",{domProps:{value:null}},[t._v(t._s(t.trans("labels.field_observations.choose_a_value")))]),t._v(" "),n("option",{attrs:{value:"EX"}},[t._v(t._s(t.trans("labels.iucn.EX")))]),t._v(" "),n("option",{attrs:{value:"EW"}},[t._v(t._s(t.trans("labels.iucn.EW")))]),t._v(" "),n("option",{attrs:{value:"CR"}},[t._v(t._s(t.trans("labels.iucn.CR")))]),t._v(" "),n("option",{attrs:{value:"EN"}},[t._v(t._s(t.trans("labels.iucn.EN")))]),t._v(" "),n("option",{attrs:{value:"VU"}},[t._v(t._s(t.trans("labels.iucn.VU")))]),t._v(" "),n("option",{attrs:{value:"NT"}},[t._v(t._s(t.trans("labels.iucn.NT")))]),t._v(" "),n("option",{attrs:{value:"LC"}},[t._v(t._s(t.trans("labels.iucn.LC")))]),t._v(" "),n("option",{attrs:{value:"DD"}},[t._v(t._s(t.trans("labels.iucn.DD")))]),t._v(" "),n("option",{attrs:{value:"NE"}},[t._v(t._s(t.trans("labels.iucn.NE")))]),t._v(" "),n("option",{attrs:{value:"NR"}},[t._v(t._s(t.trans("labels.iucn.NR")))])])],1)],1)]),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-field",{staticClass:"is-required",attrs:{label:t.trans("labels.taxa.type"),type:t.form.errors.has("type")?"is-danger":"",message:t.form.errors.has("type")?t.form.errors.first("type"):""}},[n("b-select",{attrs:{expanded:""},model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},[n("option",{attrs:{value:"RS",selected:""}},[t._v("RS")]),t._v(" "),n("option",{attrs:{value:"WP"}},[t._v("WP")])])],1)],1)]),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-half"},[n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-half"},[n("b-field",{attrs:{label:t.trans("labels.taxa.strictly_protected")}},[n("b-switch",{model:{value:t.form.strictly_protected,callback:function(e){t.$set(t.form,"strictly_protected",e)},expression:"form.strictly_protected"}},[t._v("\n              "+t._s(t.form.strictly_protected?t.trans("Yes"):t.trans("No"))+"\n            ")])],1)],1),t._v(" "),n("div",{staticClass:"column is-half"},[n("b-field",{attrs:{label:t.trans("labels.taxa.strictly_note")}},[n("b-input",{attrs:{disabled:!1===t.form.strictly_protected,maxlength:"100"},model:{value:t.form.strictly_note,callback:function(e){t.$set(t.form,"strictly_note",e)},expression:"form.strictly_note"}})],1)],1)])]),t._v(" "),n("div",{staticClass:"column is-half"},[n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-half"},[n("b-field",{attrs:{label:t.trans("labels.taxa.protected")}},[n("b-switch",{model:{value:t.form.protected,callback:function(e){t.$set(t.form,"protected",e)},expression:"form.protected"}},[t._v("\n              "+t._s(t.form.protected?t.trans("Yes"):t.trans("No"))+"\n            ")])],1)],1),t._v(" "),n("div",{staticClass:"column is-half"},[n("b-field",{attrs:{label:t.trans("labels.taxa.protected_note")}},[n("b-input",{attrs:{disabled:!1===t.form.protected,maxlength:"100"},model:{value:t.form.protected_note,callback:function(e){t.$set(t.form,"protected_note",e)},expression:"form.protected_note"}})],1)],1)])])]),t._v(" "),n("hr"),t._v(" "),n("label",{staticClass:"label"},[t._v(t._s(t.trans("labels.taxa.synonyms")))]),t._v(" "),null!=t.taxon.id?n("div",[t.synonyms.length>0?n("div",t._l(t.synonyms,(function(e,i){return n("b-field",{key:i},[n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-half"},[n("p",[t._v(t._s(e.name))])]),t._v(" "),n("div",{staticClass:"column"},[n("button",{directives:[{name:"tooltip",rawName:"v-tooltip",value:"Remove",expression:'"Remove"'}],staticClass:"delete",on:{click:function(e){return t.removeSynonym(i)}}})])])])})),1):t._e()]):t._e(),t._v(" "),t._l(t.synonymNames,(function(e,i){return n("b-field",{key:i},[n("div",{staticClass:"columns"},[n("div",{staticClass:"column is-half"},[n("p",[t._v(t._s(e))])]),t._v(" "),n("div",{staticClass:"column"},[n("button",{directives:[{name:"tooltip",rawName:"v-tooltip",value:"Remove",expression:'"Remove"'}],staticClass:"delete",on:{click:function(e){return t.removeSynonymName(i)}}})])])])})),t._v(" "),n("div",{staticClass:"columns"},[n("div",{staticClass:"column"},[n("b-input",{attrs:{maxlength:"100"},nativeOn:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:(e.preventDefault(),t.addSynonym(e))}},model:{value:t.synonym_name,callback:function(e){t.synonym_name=e},expression:"synonym_name"}})],1),t._v(" "),n("div",{staticClass:"column"},[n("button",{staticClass:"button is-primary",attrs:{type:"button"},on:{click:t.addSynonym}},[t._v("\n        "+t._s(t.trans("labels.taxa.addSynonym"))+"\n      ")])])]),t._v(" "),n("hr"),t._v(" "),n("button",{staticClass:"button is-primary",class:{"is-loading":t.form.processing},attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.submitWithRedirect(e)}}},[t._v("\n    "+t._s(t.trans("buttons.save"))+"\n  ")]),t._v(" "),n("button",{staticClass:"button is-primary",class:{"is-loading":t.form.processing},attrs:{type:"submit"},on:{click:t.submitWithoutRedirect}},[t._v("\n    "+t._s(t.trans("buttons.save_edit"))+"\n  ")]),t._v(" "),n("a",{staticClass:"button is-text",attrs:{href:t.cancelUrl},on:{click:t.onCancel}},[t._v(t._s(t.trans("buttons.cancel")))])],2)}),[],!1,null,null,null);e.default=C.exports},sEfC:function(t,e,n){var i=n("GoyQ"),s=n("QIyF"),r=n("tLB3"),a=Math.max,o=Math.min;t.exports=function(t,e,n){var l,u,c,d,m,f,b=0,h=!1,p=!1,v=!0;if("function"!=typeof t)throw new TypeError("Expected a function");function _(e){var n=l,i=u;return l=u=void 0,b=e,d=t.apply(i,n)}function y(t){return b=t,m=setTimeout(x,e),h?_(t):d}function g(t){var n=t-f;return void 0===f||n>=e||n<0||p&&t-b>=c}function x(){var t=s();if(g(t))return C(t);m=setTimeout(x,function(t){var n=e-(t-f);return p?o(n,c-(t-b)):n}(t))}function C(t){return m=void 0,v&&l?_(t):(l=u=void 0,d)}function k(){var t=s(),n=g(t);if(l=arguments,u=this,f=t,n){if(void 0===m)return y(f);if(p)return clearTimeout(m),m=setTimeout(x,e),_(f)}return void 0===m&&(m=setTimeout(x,e)),d}return e=r(e)||0,i(n)&&(h=!!n.leading,c=(p="maxWait"in n)?a(r(n.maxWait)||0,e):c,v="trailing"in n?!!n.trailing:v),k.cancel=function(){void 0!==m&&clearTimeout(m),b=0,l=f=u=m=void 0},k.flush=function(){return void 0===m?d:C(s())},k}},uuKk:function(t,e,n){"use strict";var i=n("vDqi"),s=n.n(i),r=n("sEfC"),a=n.n(r),o=n("mwIZ"),l=n.n(o);function u(t){return(u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var c={name:"nzTaxonAutocomplete",props:{label:{type:String,default:"Taxon"},placeholder:{type:String,default:"Search for taxon..."},taxon:{type:Object,default:null},url:{type:String,default:function(){return route("api.taxa.index")}},value:{type:String,default:""},error:Boolean,message:{type:String,default:null},except:{},autofocus:Boolean},data:function(){return{data:[],selected:this.taxon||null,loading:!1}},computed:{haveThumbnail:function(){return this.selected&&this.selected.thumbnail_url},icon:function(){return this.selected?"check":"search"}},watch:{taxon:function(t){this.selected=t}},methods:{fetchData:a()((function(){var t=this;if(this.value){this.data=[],this.loading=!0;var e={name:this.value,limit:20};this.except&&(e.except=this.except),s.a.get(this.url,{params:e}).then((function(e){e.data.data.forEach((function(e){return t.data.push(e)})),t.loading=!1}),(function(e){t.loading=!1}))}}),500),onSelect:function(t){this.selected=t,this.$emit("select",t)},onInput:function(t){var e=this.getValue(this.selected);e&&e!==t&&this.onSelect(null),this.$emit("input",t),this.fetchData()},focusOnInput:function(){this.$el.querySelector("input").focus()},getValue:function(t){if(t)return"object"===u(t)?l()(t,"name"):t},enterPressed:function(){this.$refs.autocomplete.isActive||this.$emit("enter")}}},d=n("KHd+"),m=Object(d.a)(c,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-field",{staticClass:"nz-taxon-autocomplete",attrs:{label:t.label,type:t.error?"is-danger":null,message:t.message}},[n("b-field",{attrs:{grouped:""}},[t.haveThumbnail?n("img",{attrs:{width:"32",src:this.selected.thumbnail_url}}):t._e(),t._v(" "),n("b-autocomplete",{ref:"autocomplete",attrs:{value:t.value,data:t.data,field:"name",loading:t.loading,icon:t.icon,placeholder:t.placeholder,expanded:"",autofocus:t.autofocus},on:{input:t.onInput,select:t.onSelect},nativeOn:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.enterPressed(e)}},scopedSlots:t._u([{key:"default",fn:function(e){return[n("div",{staticClass:"media"},[n("div",{staticClass:"media-left"},[e.option.thumbnail_url?n("img",{attrs:{width:"32",src:e.option.thumbnail_url}}):t._e()]),t._v(" "),n("div",{staticClass:"media-content"},[t._v("\n            "+t._s(e.option.name)+t._s(e.option.native_name?" ("+e.option.native_name+")":"")+"\n          ")])])]}}])})],1)],1)}),[],!1,null,null,null);e.a=m.exports},xWf0:function(t,e,n){"use strict";var i=n("XuX8"),s=n.n(i),r=n("rX62"),a=n.n(r);s.a.config.ignoredElements=["trix-editor"];var o=a.a.config.lang;function l(){for(var t="",e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",n=0;n<5;n++)t+=e.charAt(Math.floor(Math.random()*e.length));return t}a.a.config.toolbar={getDefaultHTML:function(){return'\n    <div class="trix-button-row">\n      <span class="trix-button-group trix-button-group--text-tools" data-trix-button-group="text-tools">\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-bold" data-trix-attribute="bold" data-trix-key="b" title="'.concat(o.bold,'" tabindex="-1">').concat(o.bold,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-italic" data-trix-attribute="italic" data-trix-key="i" title="').concat(o.italic,'" tabindex="-1">').concat(o.italic,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-strike" data-trix-attribute="strike" title="#{lang.strike}" tabindex="-1">').concat(o.strike,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-link" data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="').concat(o.link,'" tabindex="-1">').concat(o.link,'</button>\n      </span>\n      <span class="trix-button-group trix-button-group--history-tools" data-trix-button-group="history-tools">\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-undo" data-trix-action="undo" data-trix-key="z" title="').concat(o.undo,'" tabindex="-1">').concat(o.undo,'</button>\n        <button type="button" class="trix-button trix-button--icon trix-button--icon-redo" data-trix-action="redo" data-trix-key="shift+z" title="').concat(o.redo,'" tabindex="-1">').concat(o.redo,'</button>\n      </span>\n    </div>\n    <div class="trix-dialogs" data-trix-dialogs>\n      <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">\n        <div class="trix-dialog__link-fields">\n          <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="').concat(o.urlPlaceholder,'" required data-trix-input>\n          <div class="trix-button-group">\n            <input type="button" class="trix-button trix-button--dialog" value="').concat(o.link,'" data-trix-method="setAttribute">\n            <input type="button" class="trix-button trix-button--dialog" value="').concat(o.unlink,'" data-trix-method="removeAttribute">\n          </div>\n        </div>\n      </div>\n    </div>\n  ')}};var u={name:"nzWysiwyg",props:{name:String,value:String},data:function(){return{inputId:l()}},mounted:function(){this.$refs.trix.addEventListener("trix-change",this.onInput)},beforeDestroy:function(){this.$refs.trix.removeEventListener("trix-change",this.onInput)},methods:{onInput:function(t){this.$emit("input",t.target.innerHTML)},focus:function(){this.$refs.trix.focus()}}},c=n("KHd+"),d=Object(c.a)(u,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"wysiwyg"},[e("input",{ref:"input",attrs:{id:this.inputId,type:"hidden",name:this.name},domProps:{value:this.value}}),this._v(" "),e("trix-editor",{ref:"trix",attrs:{input:this.inputId}})],1)}),[],!1,null,null,null);e.a=d.exports},"xs/l":function(t,e,n){var i=n("TYy9"),s=n("Ioao"),r=n("wclG");t.exports=function(t){return r(s(t,void 0,i),t+"")}}}]);
//# sourceMappingURL=18.js.map?id=f3eaad42b089bfd6e50d