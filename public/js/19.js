(window.webpackJsonp=window.webpackJsonp||[]).push([[19],{BiGR:function(e,t,r){var a=r("nmnc"),i=r("03A+"),o=r("Z0cm"),n=a?a.isConcatSpreadable:void 0;e.exports=function(e){return o(e)||i(e)||!!(n&&e&&e[n])}},FZoo:function(e,t,r){var a=r("MrPd"),i=r("4uTw"),o=r("wJg7"),n=r("GoyQ"),s=r("9Nap");e.exports=function(e,t,r,l){if(!n(e))return e;for(var c=-1,u=(t=i(t,e)).length,f=u-1,m=e;null!=m&&++c<u;){var d=s(t[c]),_=r;if("__proto__"===d||"constructor"===d||"prototype"===d)return e;if(c!=f){var b=m[d];void 0===(_=l?l(b,d,m):void 0)&&(_=n(b)?b:o(t[c+1])?[]:{})}a(m,d,_),m=m[d]}return e}},FfPP:function(e,t,r){var a=r("idmN"),i=r("hgQt");e.exports=function(e,t){return a(e,t,(function(t,r){return i(e,r)}))}},JZM8:function(e,t,r){var a=r("FfPP"),i=r("xs/l")((function(e,t){return null==e?{}:a(e,t)}));e.exports=i},LmMd:function(e,t,r){"use strict";r.r(t);var a=r("5YJQ"),i=r.n(a),o=r("JkKK"),n=r("mwIZ"),s=r.n(n),l=r("J2m7"),c=r.n(l),u=r("JZM8"),f=r.n(u),m=r("mk2N"),d=r("b3cV");function _(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function b(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?_(Object(r),!0).forEach((function(t){p(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):_(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function p(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var v={props:{cacheKey:{default:null},cacheLifetime:{default:1440}},computed:{storageKey:function(){return this.cacheKey?"nz-form.".concat(this.cacheKey):"nz-form.".concat(window.location.host).concat(window.location.pathname)}},methods:{getFormKey:function(){return"form"},otherPersistentKeys:function(){return[]},saveState:function(){var e=b(b({},f()(this.$data,this.otherPersistentKeys())),{},{form:this[this.getFormKey()].data()});d.a.set(this.storageKey,e,this.cacheLifetime)},restoreState:function(){var e=this,t=d.a.get(this.storageKey);null!==t&&(this[this.getFormKey()].populate(t.form),this.otherPersistentKeys().forEach((function(r){void 0!==t[r]&&e.$set(e,r,t[r])})),this.clearPersistedState())},clearPersistedState:function(){d.a.delete(this.storageKey)}}},h=r("KUSn"),g=r("l90O"),y=r("TO/g"),x=r("uuKk");function w(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}function S(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?w(Object(r),!0).forEach((function(t){C(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):w(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function C(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var O={name:"nzLiteratureObservationForm",mixins:[v,m.a],components:{NzDateInput:h.a,NzSpatialInput:g.a,NzPublicationAutocomplete:y.a,NzTaxonAutocomplete:x.a},props:{submitMoreWithSameTaxon:Boolean,observation:{type:Object,default:function(){return{original_date:null,original_locality:null,original_elevation:null,original_coordinates:null,original_identification:null,original_identification_validity:null,other_original_data:null,collecting_start_year:null,collecting_start_month:null,collecting_end_year:null,collecting_end_month:null,place_where_referenced_in_publication:null,publication_id:null,taxon_id:null,year:Object(o.a)().year(),month:Object(o.a)().month()+1,day:Object(o.a)().date(),is_original_data:!0,cited_publication_id:null,latitude:null,longitude:null,location:null,accuracy:null,elevation:null,minimum_elevation:null,maximum_elevation:null,georeferenced_by:null,georeferenced_date:null,observer:null,identifier:null,note:null,sex:null,number:null,project:null,found_on:null,habitat:null,stage_id:null,time:null,dataset:null,taxon:null,publication:null,cited_publication:null}}},sexes:{type:Object,default:function(){return{}}},validityOptions:{type:[Array,Object],default:function(){return[]}}},data:function(){return{keepAfterSubmit:this.getAttributesToKeep(),submittingWithoutRedirectWithSameTaxon:!1,locale:window.App.locale,taxonName:s()(this.observation,"taxon.name",""),publicationCitation:s()(this.observation,"publication.citation",""),citedPublication:s()(this.observation,"cited_publication.citation","")}},computed:{stages:function(){return this.form.taxon?this.form.taxon.stages:[]},time:function(){return this.form.time?Object(o.a)(this.form.time,"HH:mm").toDate():null},georeferencedDate:{get:function(){var e=Object(o.a)(this.form.georeferenced_date);return e.isValid()?e.toDate():null},set:function(e){this.form.georeferenced_date=Object(o.a)(e).format("YYYY-MM-DD")}}},created:function(){this.restoreState()},methods:{otherPersistentKeys:function(){return["taxonName","publicationCitation","citedPublication"]},newForm:function(){return new i.a(S(S({},this.observation),{},{reason:null}),{resetOnSuccess:!1})},onTaxonSelect:function(e){var t=this;this.form.taxon=e||null,this.form.taxon_id=e?e.id:null,this.taxonName=e?e.name:null,!c()(this.stages,(function(e){return e.id===t.form.stage_id}))&&(this.form.stage_id=null)},onPublicationSelect:function(e){this.form.publication=e||null,this.form.publication_id=e?e.id:null,this.publicationCitation=e?e.citation:null},onCitedPublicationSelect:function(e){this.form.cited_publication=e||null,this.form.cited_publication_id=e?e.id:null,this.citedPublication=e?e.citation:null},onTimeInput:function(e){this.form.time=e?Object(o.a)(e).format("HH:mm"):null},getAttributesToKeep:function(){return["location","accuracy","elevation","latitude","longitude","year","month","day","project","observer","identifier","dataset","publication","publication_id","cited_publication","cited_publication_id","is_original_data","minimum_elevation","maximum_elevation","original_locality","original_elevation","original_coordinates","georeferenced_by","georeferenced_date"]},hookAfterSubmitWithoutRedirect:function(){this.taxonName=""},handleIsOriginalDataInput:function(e){e&&this.onCitedPublicationSelect(null),this.form.is_original_data=e},addNewPublication:function(){this.saveState(),window.location.href=route("admin.publications.create")},dateFormater:function(e){return Object(o.a)(e).format("DD.MM.YYYY")},handleElevationFetched:function(e){this.form.minimum_elevation=e,this.form.maximum_elevation=e},submitWithoutRedirectWithSameTaxon:function(){if(!this.form.processing)return this.submitOnlyDirty&&!this.isDirty()?this.notifyNoChanges():this.shouldConfirmSubmit?this.confirmSubmit(this.performSubmitWithoutRedirectWithSameTaxon):void this.performSubmitWithoutRedirectWithSameTaxon()},performSubmitWithoutRedirectWithSameTaxon:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;this.submittingWithoutRedirectWithSameTaxon=!0,this.confirmingSubmit=!1,this.shouldAskReason&&(this.form.reason=t),this.form[this.method.toLowerCase()](this.action).then(this.onSuccessfulSubmitWithoutRedirectWithSameTaxon).catch((function(t){e.submittingWithoutRedirectWithSameTaxon=!1,e.onFailedSubmit(t)}))},onSuccessfulSubmitWithoutRedirectWithSameTaxon:function(){this.submittingWithoutRedirectWithSameTaxon=!1,this.$buefy.toast.open({message:this.trans("Saved successfully"),type:"is-success"});var e=f()(this.form.data(),this.keepAfterSubmit.concat(["original_identification_validity","place_where_referenced_in_publication","taxon","taxon_id","original_identification"]));this.form.reset(),this.form.populate(e)}}},k=r("KHd+"),P=Object(k.a)(O,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("form",{staticClass:"literature-observation-form",attrs:{action:e.action,method:"POST",lang:e.locale}},[r("div",{staticClass:"mb-8"},[r("nz-publication-autocomplete",{ref:"publicationAutocomplete",staticClass:"is-required",attrs:{publication:e.form.publication,error:e.form.errors.has("publication_id"),message:e.form.errors.has("publication_id")?e.form.errors.first("publication_id"):null,autofocus:"autofocus",label:e.trans("labels.literature_observations.publication"),placeholder:e.trans("labels.literature_observations.search_for_publication")},on:{select:e.onPublicationSelect},model:{value:e.publicationCitation,callback:function(t){e.publicationCitation=t},expression:"publicationCitation"}},[r("a",{staticClass:"button",attrs:{title:e.trans("labels.literature_observations.add_new_publication"),href:e.$ziggy("admin.publications.create")},on:{click:function(t){return t.preventDefault(),e.addNewPublication(t)}}},[r("b-icon",{attrs:{icon:"plus"}})],1)]),e._v(" "),r("b-field",{staticClass:"is-required",attrs:{label:e.trans("labels.literature_observations.is_original_data"),error:e.form.errors.has("is_original_data"),message:e.form.errors.has("is_original_data")?e.form.errors.first("is_original_data"):null}},[r("b-select",{attrs:{value:e.form.is_original_data,expanded:""},on:{input:e.handleIsOriginalDataInput}},[r("option",{domProps:{value:!0}},[e._v(e._s(e.trans("labels.literature_observations.original_data")))]),e._v(" "),r("option",{domProps:{value:!1}},[e._v(e._s(e.trans("labels.literature_observations.citation")))])])],1),e._v(" "),r("nz-publication-autocomplete",{directives:[{name:"show",rawName:"v-show",value:!e.form.is_original_data,expression:"!form.is_original_data"}],staticClass:"is-required",attrs:{publication:e.form.cited_publication,error:e.form.errors.has("cited_publication_id"),message:e.form.errors.has("cited_publication_id")?e.form.errors.first("cited_publication_id"):null,label:e.trans("labels.literature_observations.cited_publication"),placeholder:e.trans("labels.literature_observations.search_for_publication")},on:{select:e.onCitedPublicationSelect},model:{value:e.citedPublication,callback:function(t){e.citedPublication=t},expression:"citedPublication"}},[r("a",{staticClass:"button",attrs:{title:e.trans("labels.literature_observations.add_new_publication"),href:e.$ziggy("admin.publications.create")},on:{click:function(t){return t.preventDefault(),e.addNewPublication(t)}}},[r("b-icon",{attrs:{icon:"plus"}})],1)]),e._v(" "),r("nz-taxon-autocomplete",{ref:"taxonAutocomplete",staticClass:"is-required",attrs:{taxon:e.form.taxon,error:e.form.errors.has("taxon_id"),message:e.form.errors.has("taxon_id")?e.form.errors.first("taxon_id"):null,autofocus:"autofocus",label:e.trans("labels.literature_observations.taxon"),placeholder:e.trans("labels.literature_observations.search_for_taxon")},on:{select:e.onTaxonSelect},model:{value:e.taxonName,callback:function(t){e.taxonName=t},expression:"taxonName"}}),e._v(" "),r("nz-date-input",{attrs:{year:e.form.year,month:e.form.month,day:e.form.day,errors:e.form.errors,label:e.trans("labels.literature_observations.date"),placeholders:{year:e.trans("labels.literature_observations.year"),month:e.trans("labels.literature_observations.month"),day:e.trans("labels.literature_observations.day")}},on:{"update:year":function(t){return e.$set(e.form,"year",t)},"update:month":function(t){return e.$set(e.form,"month",t)},"update:day":function(t){return e.$set(e.form,"day",t)}}}),e._v(" "),r("div",[r("h2",{staticClass:"is-size-4"},[e._v(e._s(e.trans("labels.literature_observations.verbatim_data")))]),e._v(" "),r("b-field",{staticClass:"is-required",attrs:{label:e.trans("labels.literature_observations.original_identification"),type:e.form.errors.has("original_identification")?"is-danger":null,message:e.form.errors.has("original_identification")?e.form.errors.first("original_identification"):null}},[r("b-input",{attrs:{name:"original_identification"},model:{value:e.form.original_identification,callback:function(t){e.$set(e.form,"original_identification",t)},expression:"form.original_identification"}})],1),e._v(" "),r("b-field",{staticClass:"is-required",attrs:{label:e.trans("labels.literature_observations.original_identification_validity"),type:e.form.errors.has("original_identification_validity")?"is-danger":null,message:e.form.errors.has("original_identification_validity")?e.form.errors.first("original_identification_validity"):null}},[r("b-select",{attrs:{name:"original_identification_validity",expanded:""},model:{value:e.form.original_identification_validity,callback:function(t){e.$set(e.form,"original_identification_validity",t)},expression:"form.original_identification_validity"}},e._l(e.validityOptions,(function(t,a){return r("option",{key:a,domProps:{value:a}},[e._v(e._s(t))])})),0)],1),e._v(" "),r("div",{staticClass:"columns"},[r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.original_date"),type:e.form.errors.has("original_date")?"is-danger":null,message:e.form.errors.has("original_date")?e.form.errors.first("original_date"):null}},[r("b-input",{attrs:{name:"original_date"},model:{value:e.form.original_date,callback:function(t){e.$set(e.form,"original_date",t)},expression:"form.original_date"}})],1),e._v(" "),r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.original_locality"),type:e.form.errors.has("original_locality")?"is-danger":null,message:e.form.errors.has("original_locality")?e.form.errors.first("original_locality"):null}},[r("b-input",{model:{value:e.form.original_locality,callback:function(t){e.$set(e.form,"original_locality",t)},expression:"form.original_locality"}})],1)],1),e._v(" "),r("div",{staticClass:"columns"},[r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.original_coordinates"),type:e.form.errors.has("original_coordinates")?"is-danger":null,message:e.form.errors.has("original_coordinates")?e.form.errors.first("original_coordinates"):null}},[r("b-input",{model:{value:e.form.original_coordinates,callback:function(t){e.$set(e.form,"original_coordinates",t)},expression:"form.original_coordinates"}})],1),e._v(" "),r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.original_elevation"),type:e.form.errors.has("original_elevation")?"is-danger":null,message:e.form.errors.has("original_elevation")?e.form.errors.first("original_elevation"):null}},[r("b-input",{attrs:{placeholder:e.trans("labels.literature_observations.original_elevation_placeholder")},model:{value:e.form.original_elevation,callback:function(t){e.$set(e.form,"original_elevation",t)},expression:"form.original_elevation"}})],1)],1),e._v(" "),r("b-field",{staticClass:"mb-8",attrs:{label:e.trans("labels.literature_observations.other_original_data"),type:e.form.errors.has("other_original_data")?"is-danger":null,message:e.form.errors.has("other_original_data")?e.form.errors.first("other_original_data"):null}},[r("b-input",{attrs:{type:"textarea"},model:{value:e.form.other_original_data,callback:function(t){e.$set(e.form,"other_original_data",t)},expression:"form.other_original_data"}})],1),e._v(" "),r("div",{staticClass:"columns"},[r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.collecting_start_year"),type:e.form.errors.has("collecting_start_year")?"is-danger":null,message:e.form.errors.has("collecting_start_year")?e.form.errors.first("collecting_start_year"):null}},[r("b-input",{model:{value:e.form.collecting_start_year,callback:function(t){e.$set(e.form,"collecting_start_year",t)},expression:"form.collecting_start_year"}})],1),e._v(" "),r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.collecting_start_month"),type:e.form.errors.has("collecting_start_month")?"is-danger":null,message:e.form.errors.has("collecting_start_month")?e.form.errors.first("collecting_start_month"):null}},[r("b-input",{model:{value:e.form.collecting_start_month,callback:function(t){e.$set(e.form,"collecting_start_month",t)},expression:"form.collecting_start_month"}})],1)],1),e._v(" "),r("div",{staticClass:"columns"},[r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.collecting_end_year"),type:e.form.errors.has("collecting_end_year")?"is-danger":null,message:e.form.errors.has("collecting_end_year")?e.form.errors.first("collecting_end_year"):null}},[r("b-input",{model:{value:e.form.collecting_end_year,callback:function(t){e.$set(e.form,"collecting_end_year",t)},expression:"form.collecting_end_year"}})],1),e._v(" "),r("b-field",{staticClass:"column",attrs:{label:e.trans("labels.literature_observations.collecting_end_month"),type:e.form.errors.has("collecting_end_month")?"is-danger":null,message:e.form.errors.has("collecting_end_month")?e.form.errors.first("collecting_end_month"):null}},[r("b-input",{model:{value:e.form.collecting_end_month,callback:function(t){e.$set(e.form,"collecting_end_month",t)},expression:"form.collecting_end_month"}})],1)],1)],1),e._v(" "),r("nz-spatial-input",{staticClass:"mb-4",attrs:{latitude:e.form.latitude,longitude:e.form.longitude,location:e.form.location,accuracy:e.form.accuracy,elevation:e.form.elevation,errors:e.form.errors,"has-other-errors":e.form.errors.has("minimum_elevation")||e.form.errors.has("maximum_elevation")},on:{"update:latitude":function(t){return e.$set(e.form,"latitude",t)},"update:longitude":function(t){return e.$set(e.form,"longitude",t)},"update:location":function(t){return e.$set(e.form,"location",t)},"update:accuracy":function(t){return e.$set(e.form,"accuracy",t)},"update:elevation":function(t){return e.$set(e.form,"elevation",t)},"elevation-fetched":e.handleElevationFetched}},[r("b-field",{attrs:{label:e.trans("labels.literature_observations.minimum_elevation_m"),type:e.form.errors.has("minimum_elevation")?"is-danger":null,message:e.form.errors.has("minimum_elevation")?e.form.errors.first("minimum_elevation"):null,"custom-class":"is-small"}},[r("b-input",{attrs:{type:"number",size:"is-small"},model:{value:e.form.minimum_elevation,callback:function(t){e.$set(e.form,"minimum_elevation",e._n(t))},expression:"form.minimum_elevation"}})],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.maximum_elevation_m"),type:e.form.errors.has("maximum_elevation")?"is-danger":null,message:e.form.errors.has("maximum_elevation")?e.form.errors.first("maximum_elevation"):null,"custom-class":"is-small"}},[r("b-input",{attrs:{type:"number",size:"is-small"},model:{value:e.form.maximum_elevation,callback:function(t){e.$set(e.form,"maximum_elevation",e._n(t))},expression:"form.maximum_elevation"}})],1)],1),e._v(" "),r("div",{staticClass:"columns"},[r("div",{staticClass:"column"},[r("b-field",{attrs:{label:e.trans("labels.literature_observations.georeferenced_by"),type:e.form.errors.has("georeferenced_by")?"is-danger":null,message:e.form.errors.has("georeferenced_by")?e.form.errors.first("georeferenced_by"):null}},[r("b-input",{model:{value:e.form.georeferenced_by,callback:function(t){e.$set(e.form,"georeferenced_by",e._n(t))},expression:"form.georeferenced_by"}})],1)],1),e._v(" "),r("div",{staticClass:"column"},[r("b-field",{attrs:{label:e.trans("labels.literature_observations.georeferenced_date"),type:e.form.errors.has("georeferenced_date")?"is-danger":null,message:e.form.errors.has("georeferenced_date")?e.form.errors.first("georeferenced_date"):null}},[r("b-datepicker",{attrs:{"max-date":new Date,"mobile-native":!1,"date-formatter":e.dateFormater,"first-day-of-week":1,placeholder:"DD.MM.YYYY"},model:{value:e.georeferencedDate,callback:function(t){e.georeferencedDate=t},expression:"georeferencedDate"}},[r("button",{staticClass:"button is-danger",attrs:{type:"button"},on:{click:function(t){e.form.georeferenced_date=null}}},[r("b-icon",{attrs:{icon:"close"}}),e._v(" "),r("span",[e._v("Clear")])],1)])],1)],1)]),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.stage"),type:e.form.errors.has("stage_id")?"is-danger":null,message:e.form.errors.has("stage_id")?e.form.errors.first("stage_id"):null}},[r("b-select",{attrs:{disabled:!e.stages.length,expanded:"expanded"},model:{value:e.form.stage_id,callback:function(t){e.$set(e.form,"stage_id",t)},expression:"form.stage_id"}},[r("option",{domProps:{value:null}},[e._v(e._s(e.trans("labels.literature_observations.choose_a_stage")))]),e._v(" "),e._l(e.stages,(function(t){return r("option",{key:t.id,domProps:{value:t.id,textContent:e._s(e.trans("stages."+t.name))}})}))],2)],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.sex"),type:e.form.errors.has("sex")?"is-danger":null,message:e.form.errors.has("sex")?e.form.errors.first("sex"):null}},[r("b-select",{attrs:{expanded:"expanded"},model:{value:e.form.sex,callback:function(t){e.$set(e.form,"sex",t)},expression:"form.sex"}},[r("option",{domProps:{value:null}},[e._v(e._s(e.trans("labels.literature_observations.choose_a_value")))]),e._v(" "),e._l(e.sexes,(function(t,a){return r("option",{key:a,domProps:{value:a,textContent:e._s(t)}})}))],2)],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.number"),type:e.form.errors.has("number")?"is-danger":null,message:e.form.errors.has("number")?e.form.errors.first("number"):null}},[r("b-input",{attrs:{type:"number"},model:{value:e.form.number,callback:function(t){e.$set(e.form,"number",t)},expression:"form.number"}})],1),e._v(" "),r("div",{staticClass:"mt-4"},[r("b-field",{attrs:{label:e.trans("labels.literature_observations.note"),error:e.form.errors.has("note"),message:e.form.errors.has("note")?e.form.errors.first("note"):null}},[r("b-input",{attrs:{type:"textarea"},model:{value:e.form.note,callback:function(t){e.$set(e.form,"note",t)},expression:"form.note"}})],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.habitat"),type:e.form.errors.has("habitat")?"is-danger":null,message:e.form.errors.has("habitat")?e.form.errors.first("habitat"):null}},[r("b-input",{model:{value:e.form.habitat,callback:function(t){e.$set(e.form,"habitat",t)},expression:"form.habitat"}})],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.found_on"),type:e.form.errors.has("found_on")?"is-danger":null,message:e.form.errors.has("found_on")?e.form.errors.first("found_on"):null}},[r("label",{staticClass:"label",attrs:{slot:"label",for:"found_on"},slot:"label"},[r("span",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.trans("labels.literature_observations.found_on_tooltip")},expression:"{content: trans('labels.literature_observations.found_on_tooltip')}"}],staticClass:"is-dashed"},[e._v("\n            "+e._s(e.trans("labels.literature_observations.found_on"))+"\n          ")])]),e._v(" "),r("b-input",{attrs:{id:"found_on",name:"found_on"},model:{value:e.form.found_on,callback:function(t){e.$set(e.form,"found_on",t)},expression:"form.found_on"}})],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.time"),type:e.form.errors.has("time")?"is-danger":null,message:e.form.errors.has("time")?e.form.errors.first("time"):null}},[r("b-timepicker",{attrs:{value:e.time,placeholder:e.trans("labels.literature_observations.click_to_select"),icon:"clock-o","mobile-native":!1},on:{input:e.onTimeInput}},[r("button",{staticClass:"button is-danger",attrs:{type:"button"},on:{click:function(t){e.form.time=null}}},[r("b-icon",{attrs:{icon:"close"}})],1)])],1),e._v(" "),r("div",{staticClass:"columns"},[r("div",{staticClass:"column"},[r("div",{staticClass:"field"},[r("label",{staticClass:"label",attrs:{for:"project"}},[r("span",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.trans("labels.literature_observations.project_tooltip")},expression:"{content: trans('labels.literature_observations.project_tooltip')}"}],staticClass:"is-dashed"},[e._v("\n                "+e._s(e.trans("labels.literature_observations.project"))+"\n              ")])]),e._v(" "),r("b-input",{attrs:{id:"project",name:"project"},model:{value:e.form.project,callback:function(t){e.$set(e.form,"project",t)},expression:"form.project"}}),e._v(" "),e.form.errors.has("project")?r("p",{staticClass:"help",class:{"is-danger":e.form.errors.has("project")},domProps:{innerHTML:e._s(e.form.errors.first("project"))}}):e._e()],1)]),e._v(" "),r("div",{staticClass:"column"},[r("div",{staticClass:"field"},[r("label",{staticClass:"label",attrs:{for:"dataset"}},[e._v("\n              "+e._s(e.trans("labels.literature_observations.dataset"))+"\n            ")]),e._v(" "),r("b-input",{attrs:{id:"dataset",name:"dataset"},model:{value:e.form.dataset,callback:function(t){e.$set(e.form,"dataset",t)},expression:"form.dataset"}}),e._v(" "),e.form.errors.has("dataset")?r("p",{staticClass:"help",class:{"is-danger":e.form.errors.has("dataset")},domProps:{innerHTML:e._s(e.form.errors.first("dataset"))}}):e._e()],1)])]),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.observer"),type:e.form.errors.has("observer")?"is-danger":null,message:e.form.errors.has("observer")?e.form.errors.first("observer"):null}},[r("b-input",{attrs:{name:"observer"},model:{value:e.form.observer,callback:function(t){e.$set(e.form,"observer",t)},expression:"form.observer"}})],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.identifier"),type:e.form.errors.has("identifier")?"is-danger":null,message:e.form.errors.has("identifier")?e.form.errors.first("identifier"):null}},[r("b-input",{attrs:{name:"identifier"},model:{value:e.form.identifier,callback:function(t){e.$set(e.form,"identifier",t)},expression:"form.identifier"}})],1)],1)],1),e._v(" "),r("b-field",{attrs:{label:e.trans("labels.literature_observations.place_where_referenced_in_publication"),type:e.form.errors.has("place_where_referenced_in_publication")?"is-danger":null,message:e.form.errors.has("place_where_referenced_in_publication")?e.form.errors.first("place_where_referenced_in_publication"):null}},[r("b-input",{attrs:{placeholder:e.trans("labels.literature_observations.place_where_referenced_in_publication_placeholder")},model:{value:e.form.place_where_referenced_in_publication,callback:function(t){e.$set(e.form,"place_where_referenced_in_publication",t)},expression:"form.place_where_referenced_in_publication"}})],1),e._v(" "),r("hr"),e._v(" "),r("button",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.trans("labels.literature_observations.save_tooltip")},expression:"{content: trans('labels.literature_observations.save_tooltip')}"}],staticClass:"button is-primary",class:{"is-loading":e.submittingWithRedirect},attrs:{type:"submit"},on:{click:function(t){return t.preventDefault(),e.submitWithRedirect(t)}}},[e._v("\n    "+e._s(e.trans("buttons.save"))+"\n  ")]),e._v(" "),e.submitMore?r("button",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.trans("labels.literature_observations.save_more_tooltip")},expression:"{content: trans('labels.literature_observations.save_more_tooltip')}"}],staticClass:"button is-primary",class:{"is-outlined":!e.submittingWithoutRedirect,"is-loading":e.submittingWithoutRedirect},attrs:{type:"submit"},on:{click:function(t){return t.preventDefault(),e.submitWithoutRedirect(t)}}},[e._v("\n    "+e._s(e.trans("buttons.save_more"))+"\n  ")]):e._e(),e._v(" "),e.submitMoreWithSameTaxon?r("button",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.trans("labels.literature_observations.save_more_same_taxon_tooltip")},expression:"{content: trans('labels.literature_observations.save_more_same_taxon_tooltip')}"}],staticClass:"button is-primary",class:{"is-outlined":!e.submittingWithoutRedirectWithSameTaxon,"is-loading":e.submittingWithoutRedirectWithSameTaxon},attrs:{type:"button"},on:{click:function(t){return t.preventDefault(),e.submitWithoutRedirectWithSameTaxon(t)}}},[e._v("\n    "+e._s(e.trans("labels.literature_observations.save_more_same_taxon"))+"\n  ")]):e._e(),e._v(" "),r("a",{staticClass:"button is-text",attrs:{href:e.cancelUrl},on:{click:e.onCancel}},[e._v(e._s(e.trans("buttons.cancel")))])],1)}),[],!1,null,null,null);t.default=P.exports},QIyF:function(e,t,r){var a=r("Kz5y");e.exports=function(){return a.Date.now()}},"TO/g":function(e,t,r){"use strict";var a=r("vDqi"),i=r.n(a),o=r("sEfC"),n=r.n(o),s=r("mwIZ"),l=r.n(s);function c(e){return(c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var u={name:"nzPublicationAutocomplete",props:{label:{type:String,default:"Publication"},placeholder:{type:String,default:"Search for publication..."},publication:{type:Object,default:null},route:{type:String,default:"api.autocomplete.publications.index"},value:{type:String,default:""},error:Boolean,message:{type:String,default:null},except:{},autofocus:Boolean,disabled:Boolean},data:function(){return{data:[],selected:this.publication||null,loading:!1}},computed:{icon:function(){return this.selected?"check":"search"}},watch:{publication:function(e){this.selected=e}},methods:{fetchData:n()((function(){var e=this;if(this.value){this.data=[],this.loading=!0;var t={citation:this.value};this.except&&(t.except=this.except),i.a.get(route(this.route),{params:t}).then((function(t){t.data.data.forEach((function(t){return e.data.push(t)})),e.loading=!1}),(function(t){e.loading=!1}))}}),500),onSelect:function(e){this.selected=e,this.$emit("select",e)},onInput:function(e){var t=this.getValue(this.selected);t&&t!==e&&this.onSelect(null),this.$emit("input",e),this.fetchData()},focusOnInput:function(){this.$el.querySelector("input").focus()},getValue:function(e){if(e)return"object"===c(e)?l()(e,"citation"):e}}},f=r("KHd+"),m=Object(f.a)(u,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("b-field",{staticClass:"nz-publication-autocomplete",attrs:{label:e.label,type:e.error?"is-danger":null,message:e.message}},[r("b-field",{attrs:{grouped:""}},[r("b-autocomplete",{attrs:{value:e.value,data:e.data,field:"citation",loading:e.loading,icon:e.icon,placeholder:e.placeholder,expanded:"",autofocus:e.autofocus,disabled:e.disabled},on:{input:e.onInput,select:e.onSelect},scopedSlots:e._u([{key:"default",fn:function(t){return[r("div",{staticClass:"media"},[r("div",{staticClass:"media-content"},[e._v("\n            "+e._s(t.option.citation)+"\n          ")])])]}}])}),e._v(" "),e._t("default")],2)],1)}),[],!1,null,null,null);t.a=m.exports},TYy9:function(e,t,r){var a=r("XGnz");e.exports=function(e){return(null==e?0:e.length)?a(e,1):[]}},XGnz:function(e,t,r){var a=r("CH3K"),i=r("BiGR");e.exports=function e(t,r,o,n,s){var l=-1,c=t.length;for(o||(o=i),s||(s=[]);++l<c;){var u=t[l];r>0&&o(u)?r>1?e(u,r-1,o,n,s):a(s,u):n||(s[s.length]=u)}return s}},b3cV:function(e,t,r){"use strict";function a(e,t){for(var r=0;r<t.length;r++){var a=t[r];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}var i=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,r,i;return t=e,(r=[{key:"get",value:function(e){var t=JSON.parse(localStorage.getItem(e));return t?new Date(t.expires)<new Date?(localStorage.removeItem(e),null):t.value:null}},{key:"has",value:function(e){return null!==this.get(e)}},{key:"set",value:function(e,t,r){var a=(new Date).getTime(),i=new Date(a+6e4*r);localStorage.setItem(e,JSON.stringify({value:t,expires:i}))}},{key:"delete",value:function(e){this.get(e)&&localStorage.removeItem(e)}}])&&a(t.prototype,r),i&&a(t,i),e}();t.a=new i},idmN:function(e,t,r){var a=r("ZWtO"),i=r("FZoo"),o=r("4uTw");e.exports=function(e,t,r){for(var n=-1,s=t.length,l={};++n<s;){var c=t[n],u=a(e,c);r(u,c)&&i(l,o(c,e),u)}return l}},sEfC:function(e,t,r){var a=r("GoyQ"),i=r("QIyF"),o=r("tLB3"),n=Math.max,s=Math.min;e.exports=function(e,t,r){var l,c,u,f,m,d,_=0,b=!1,p=!1,v=!0;if("function"!=typeof e)throw new TypeError("Expected a function");function h(t){var r=l,a=c;return l=c=void 0,_=t,f=e.apply(a,r)}function g(e){return _=e,m=setTimeout(x,t),b?h(e):f}function y(e){var r=e-d;return void 0===d||r>=t||r<0||p&&e-_>=u}function x(){var e=i();if(y(e))return w(e);m=setTimeout(x,function(e){var r=t-(e-d);return p?s(r,u-(e-_)):r}(e))}function w(e){return m=void 0,v&&l?h(e):(l=c=void 0,f)}function S(){var e=i(),r=y(e);if(l=arguments,c=this,d=e,r){if(void 0===m)return g(d);if(p)return clearTimeout(m),m=setTimeout(x,t),h(d)}return void 0===m&&(m=setTimeout(x,t)),f}return t=o(t)||0,a(r)&&(b=!!r.leading,u=(p="maxWait"in r)?n(o(r.maxWait)||0,t):u,v="trailing"in r?!!r.trailing:v),S.cancel=function(){void 0!==m&&clearTimeout(m),_=0,l=d=c=m=void 0},S.flush=function(){return void 0===m?f:w(i())},S}},"xs/l":function(e,t,r){var a=r("TYy9"),i=r("Ioao"),o=r("wclG");e.exports=function(e){return o(i(e,void 0,a),e+"")}}}]);
//# sourceMappingURL=19.js.map?id=3fc4b24ee6716f245ba0