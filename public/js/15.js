(window.webpackJsonp=window.webpackJsonp||[]).push([[15],{"+Wua":function(t,e,n){"use strict";n.r(e);var r=n("9KKN"),o=n("uTtz"),a=n("LNOP"),i={name:"nzViewGroupsTable",mixins:[r.a],components:{NzPerPageSelect:o.a,NzSortableColumnHeader:a.a},props:{perPageOptions:{type:Array,default:function(){return[15,30,50,100]},validator:function(t){return t.length}},listRoute:String,editRoute:String,deleteRoute:String,empty:{type:String,default:"Nothing here."}},data:function(){return{data:[],total:0,loading:!1,sortField:"id",sortOrder:"desc",page:1,perPage:this.perPageOptions[0],checkedRows:[]}},created:function(){this.restoreState(),this.loadAsyncData()},methods:{loadAsyncData:function(){var t=this;return this.loading=!0,axios.get(route(this.listRoute).withQuery({sort_by:"".concat(this.sortField,".").concat(this.sortOrder),page:this.page,per_page:this.perPage})).then((function(e){var n=e.data;t.data=[],t.total=n.meta.total,n.data.forEach((function(e){return t.data.push(e)})),t.loading=!1}),(function(e){t.data=[],t.total=0,t.loading=!1}))},onPageChange:function(t){this.page=t,this.loadAsyncData()},onSort:function(t,e){this.sortField=t,this.sortOrder=e,this.saveState(),this.loadAsyncData()},onPerPageChange:function(t){t!==this.perPage&&(this.perPage=t,this.saveState(),this.loadAsyncData())},confirmRemove:function(t){var e=this;this.$buefy.dialog.confirm({message:this.trans("Are you sure you want to delete this record?"),confirmText:this.trans("buttons.delete"),cancelText:this.trans("buttons.cancel"),type:"is-danger",onConfirm:function(){e.remove(t)}})},remove:function(t){var e=this;return axios.delete(route(this.deleteRoute,t.id)).then((function(t){e.$buefy.toast.open({message:e.trans("Record deleted"),type:"is-success"}),e.loadAsyncData()})).catch((function(t){console.error(t)}))},editLink:function(t){return route(this.editRoute,t.id)}}},s=n("KHd+"),u=Object(s.a)(i,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"view-groups-table"},[n("b-table",{attrs:{data:t.data,loading:t.loading,paginated:"","backend-pagination":"",total:t.total,"per-page":t.perPage,"current-page":t.page,"pagination-position":"both","backend-sorting":"","default-sort-direction":"asc","default-sort":[t.sortField,t.sortOrder],"mobile-cards":""},on:{"page-change":t.onPageChange,sort:t.onSort},scopedSlots:t._u([{key:"top-left",fn:function(){return[n("nz-per-page-select",{attrs:{value:t.perPage,options:t.perPageOptions},on:{input:t.onPerPageChange}})]},proxy:!0},{key:"bottom-left",fn:function(){return[n("nz-per-page-select",{attrs:{value:t.perPage,options:t.perPageOptions},on:{input:t.onPerPageChange}})]},proxy:!0},{key:"empty",fn:function(){return[n("section",{staticClass:"section"},[n("div",{staticClass:"content has-text-grey has-text-centered"},[n("p",[t._v(t._s(t.empty))])])])]},proxy:!0}])},[t._v(" "),t._v(" "),n("b-table-column",{attrs:{field:"id",label:t.trans("labels.id"),width:"40",numeric:"",sortable:""},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.id)+"\n      ")]}},{key:"header",fn:function(e){var r=e.column;return[n("nz-sortable-column-header",{attrs:{column:r,sort:{field:t.sortField,order:t.sortOrder}}})]}}])}),t._v(" "),n("b-table-column",{attrs:{field:"name",label:t.trans("labels.view_groups.name")},scopedSlots:t._u([{key:"default",fn:function(e){var n=e.row;return[t._v("\n        "+t._s(n.name)+"\n      ")]}}])}),t._v(" "),n("b-table-column",{attrs:{width:"150",numeric:""},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.row;return[n("a",{attrs:{href:t.editLink(r)}},[n("b-icon",{attrs:{icon:"edit"}})],1),t._v(" "),n("a",{on:{click:function(e){return t.confirmRemove(r)}}},[n("b-icon",{attrs:{icon:"trash"}})],1)]}}])})],1)],1)}),[],!1,null,null,null);e.default=u.exports},"44Ds":function(t,e,n){var r=n("e4Nc");function o(t,e){if("function"!=typeof t||null!=e&&"function"!=typeof e)throw new TypeError("Expected a function");var n=function(){var r=arguments,o=e?e.apply(this,r):r[0],a=n.cache;if(a.has(o))return a.get(o);var i=t.apply(this,r);return n.cache=a.set(o,i)||a,i};return n.cache=new(o.Cache||r),n}o.Cache=r,t.exports=o},"4sDh":function(t,e,n){var r=n("4uTw"),o=n("03A+"),a=n("Z0cm"),i=n("wJg7"),s=n("shjB"),u=n("9Nap");t.exports=function(t,e,n){for(var c=-1,l=(e=r(e,t)).length,f=!1;++c<l;){var p=u(e[c]);if(!(f=null!=t&&n(t,p)))break;t=t[p]}return f||++c!=l?f:!!(l=null==t?0:t.length)&&s(l)&&i(p,l)&&(a(t)||o(t))}},"4uTw":function(t,e,n){var r=n("Z0cm"),o=n("9ggG"),a=n("GNiM"),i=n("dt0z");t.exports=function(t,e){return r(t)?t:o(t,e)?[t]:a(i(t))}},"9KKN":function(t,e,n){"use strict";var r=n("JZM8"),o=n.n(r),a=n("b3cV");e.a={props:{cacheKey:{default:null},cacheLifetime:{default:1440}},computed:{storageKey:function(){return this.cacheKey?"nz-table.".concat(this.cacheKey):"nz-table.".concat(window.location.host).concat(window.location.pathname)}},methods:{getPersistantKeys:function(){return["sortField","sortOrder","perPage"]},saveState:function(){a.a.set(this.storageKey,o()(this.$data,this.getPersistantKeys()),this.cacheLifetime)},restoreState:function(){var t=this,e=a.a.get(this.storageKey);null!=e&&(this.getPersistantKeys().forEach((function(n){void 0!==e[n]&&t.$set(t,n,e[n])})),this.saveState())}}}},"9Nap":function(t,e,n){var r=n("/9aa");t.exports=function(t){if("string"==typeof t||r(t))return t;var e=t+"";return"0"==e&&1/t==-1/0?"-0":e}},"9ggG":function(t,e,n){var r=n("Z0cm"),o=n("/9aa"),a=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,i=/^\w*$/;t.exports=function(t,e){if(r(t))return!1;var n=typeof t;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=t&&!o(t))||(i.test(t)||!a.test(t)||null!=e&&t in Object(e))}},BiGR:function(t,e,n){var r=n("nmnc"),o=n("03A+"),a=n("Z0cm"),i=r?r.isConcatSpreadable:void 0;t.exports=function(t){return a(t)||o(t)||!!(i&&t&&t[i])}},FZoo:function(t,e,n){var r=n("MrPd"),o=n("4uTw"),a=n("wJg7"),i=n("GoyQ"),s=n("9Nap");t.exports=function(t,e,n,u){if(!i(t))return t;for(var c=-1,l=(e=o(e,t)).length,f=l-1,p=t;null!=p&&++c<l;){var d=s(e[c]),h=n;if("__proto__"===d||"constructor"===d||"prototype"===d)return t;if(c!=f){var g=p[d];void 0===(h=u?u(g,d,p):void 0)&&(h=i(g)?g:a(e[c+1])?[]:{})}r(p,d,h),p=p[d]}return t}},FfPP:function(t,e,n){var r=n("idmN"),o=n("hgQt");t.exports=function(t,e){return r(t,e,(function(e,n){return o(t,n)}))}},GNiM:function(t,e,n){var r=n("I01J"),o=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,a=/\\(\\)?/g,i=r((function(t){var e=[];return 46===t.charCodeAt(0)&&e.push(""),t.replace(o,(function(t,n,r,o){e.push(r?o.replace(a,"$1"):n||t)})),e}));t.exports=i},I01J:function(t,e,n){var r=n("44Ds");t.exports=function(t){var e=r(t,(function(t){return 500===n.size&&n.clear(),t})),n=e.cache;return e}},JZM8:function(t,e,n){var r=n("FfPP"),o=n("xs/l")((function(t,e){return null==t?{}:r(t,e)}));t.exports=o},Juji:function(t,e){t.exports=function(t,e){return null!=t&&e in Object(t)}},LNOP:function(t,e,n){"use strict";var r={name:"nzSortableColumnHeader",props:{column:{type:Object,required:!0},sort:Object},computed:{isNotSortedColumn:function(){return this.sort.field!==this.column.field},sortIcon:function(){return this.isNotSortedColumn?"sort":"asc"===this.sort.order?"sort-asc":"sort-desc"}}},o=n("KHd+"),a=Object(o.a)(r,(function(){var t=this.$createElement,e=this._self._c||t;return e("span",{staticClass:"is-flex is-align-items-center"},[this._v("\n  "+this._s(this.column.label)+"\n  "),this.column.sortable?e("b-icon",{staticClass:"ml-2",class:{"has-text-grey-light":this.isNotSortedColumn},attrs:{pack:"fa",icon:this.sortIcon,size:"is-small"}}):this._e()],1)}),[],!1,null,null,null);e.a=a.exports},TYy9:function(t,e,n){var r=n("XGnz");t.exports=function(t){return(null==t?0:t.length)?r(t,1):[]}},XGnz:function(t,e,n){var r=n("CH3K"),o=n("BiGR");t.exports=function t(e,n,a,i,s){var u=-1,c=e.length;for(a||(a=o),s||(s=[]);++u<c;){var l=e[u];n>0&&a(l)?n>1?t(l,n-1,a,i,s):r(s,l):i||(s[s.length]=l)}return s}},ZWtO:function(t,e,n){var r=n("4uTw"),o=n("9Nap");t.exports=function(t,e){for(var n=0,a=(e=r(e,t)).length;null!=t&&n<a;)t=t[o(e[n++])];return n&&n==a?t:void 0}},b3cV:function(t,e,n){"use strict";function r(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}var o=function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t)}var e,n,o;return e=t,(n=[{key:"get",value:function(t){var e=JSON.parse(localStorage.getItem(t));return e?new Date(e.expires)<new Date?(localStorage.removeItem(t),null):e.value:null}},{key:"has",value:function(t){return null!==this.get(t)}},{key:"set",value:function(t,e,n){var r=(new Date).getTime(),o=new Date(r+6e4*n);localStorage.setItem(t,JSON.stringify({value:e,expires:o}))}},{key:"delete",value:function(t){this.get(t)&&localStorage.removeItem(t)}}])&&r(e.prototype,n),o&&r(e,o),t}();e.a=new o},hgQt:function(t,e,n){var r=n("Juji"),o=n("4sDh");t.exports=function(t,e){return null!=t&&o(t,e,r)}},idmN:function(t,e,n){var r=n("ZWtO"),o=n("FZoo"),a=n("4uTw");t.exports=function(t,e,n){for(var i=-1,s=e.length,u={};++i<s;){var c=e[i],l=r(t,c);n(l,c)&&o(u,a(c,t),l)}return u}},uTtz:function(t,e,n){"use strict";var r={name:"nzPerPageSelect",props:{value:Number,options:Array}},o=n("KHd+"),a=Object(o.a)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("b-field",[n("b-select",{attrs:{value:t.value,placeholder:"Per page"},on:{input:function(e){return t.$emit("input",e)}}},t._l(t.options,(function(e,r){return n("option",{key:r,domProps:{value:e,textContent:t._s(e)}})})),0)],1)}),[],!1,null,null,null);e.a=a.exports},"xs/l":function(t,e,n){var r=n("TYy9"),o=n("Ioao"),a=n("wclG");t.exports=function(t){return a(o(t,void 0,r),t+"")}}}]);
//# sourceMappingURL=15.js.map?id=0ad538acabede0d6ffe4