this.wc=this.wc||{},this.wc.blocks=this.wc.blocks||{},this.wc.blocks["product-best-sellers"]=function(e){function t(t){for(var n,i,u=t[0],s=t[1],a=t[2],p=0,b=[];p<u.length;p++)i=u[p],Object.prototype.hasOwnProperty.call(o,i)&&o[i]&&b.push(o[i][0]),o[i]=0;for(n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n]);for(l&&l(t);b.length;)b.shift()();return c.push.apply(c,a||[]),r()}function r(){for(var e,t=0;t<c.length;t++){for(var r=c[t],n=!0,u=1;u<r.length;u++){var s=r[u];0!==o[s]&&(n=!1)}n&&(c.splice(t--,1),e=i(i.s=r[0]))}return e}var n={},o={27:0},c=[];function i(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,i),r.l=!0,r.exports}i.m=e,i.c=n,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(r,n,function(t){return e[t]}.bind(null,n));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var u=window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[],s=u.push.bind(u);u.push=t,u=u.slice();for(var a=0;a<u.length;a++)t(u[a]);var l=s;return c.push([685,0]),r()}({0:function(e,t){!function(){e.exports=this.wp.element}()},1:function(e,t){!function(){e.exports=this.wp.i18n}()},104:function(e,t){},105:function(e,t){!function(){e.exports=this.wp.coreData}()},11:function(e,t){!function(){e.exports=this.regeneratorRuntime}()},114:function(e,t){},14:function(e,t,r){"use strict";r.d(t,"m",(function(){return c})),r.d(t,"k",(function(){return i})),r.d(t,"l",(function(){return u})),r.d(t,"h",(function(){return a})),r.d(t,"c",(function(){return l})),r.d(t,"d",(function(){return p})),r.d(t,"g",(function(){return b})),r.d(t,"f",(function(){return f})),r.d(t,"j",(function(){return d})),r.d(t,"i",(function(){return g})),r.d(t,"a",(function(){return O})),r.d(t,"b",(function(){return m})),r.d(t,"e",(function(){return h})),r.d(t,"p",(function(){return j})),r.d(t,"q",(function(){return y})),r.d(t,"n",(function(){return v})),r.d(t,"o",(function(){return _}));var n,o=r(5),c=Object(o.getSetting)("wcBlocksConfig",{buildPhase:1,pluginUrl:"",productCount:0,restApiRoutes:{},wordCountType:"words"}),i=c.pluginUrl+"assets/",u=c.pluginUrl+"build/",s=c.buildPhase,a=null===(n=o.STORE_PAGES.shop)||void 0===n?void 0:n.permalink,l=o.STORE_PAGES.checkout.id,p=o.STORE_PAGES.checkout.permalink,b=o.STORE_PAGES.privacy.permalink,f=o.STORE_PAGES.privacy.title,d=o.STORE_PAGES.terms.permalink,g=o.STORE_PAGES.terms.title,O=o.STORE_PAGES.cart.id,m=o.STORE_PAGES.cart.permalink,h=o.STORE_PAGES.myaccount.permalink?o.STORE_PAGES.myaccount.permalink:Object(o.getSetting)("wpLoginUrl","/wp-login.php"),w=r(25),j=function(e,t){if(s>2)return Object(w.registerBlockType)(e,t)},y=function(e,t){if(s>1)return Object(w.registerBlockType)(e,t)},v=function(){return s>2},_=function(){return s>1}},161:function(e,t,r){"use strict";r.d(t,"a",(function(){return c}));var n=r(0),o=r(14),c=Object(n.createElement)("img",{src:o.k+"img/grid.svg",alt:"Grid Preview",width:"230",height:"250",style:{width:"100%"}})},19:function(e,t){!function(){e.exports=this.wp.apiFetch}()},21:function(e,t){!function(){e.exports=this.wp.url}()},22:function(e,t){!function(){e.exports=this.wp.compose}()},23:function(e,t){!function(){e.exports=this.wp.data}()},24:function(e,t){!function(){e.exports=this.wp.blockEditor}()},25:function(e,t){!function(){e.exports=this.wp.blocks}()},28:function(e,t){!function(){e.exports=this.wp.htmlEntities}()},29:function(e,t){!function(){e.exports=this.moment}()},3:function(e,t){!function(){e.exports=this.wp.components}()},32:function(e,t){!function(){e.exports=this.wp.primitives}()},33:function(e,t){!function(){e.exports=this.wp.dataControls}()},38:function(e,t,r){"use strict";r.d(t,"h",(function(){return f})),r.d(t,"e",(function(){return d})),r.d(t,"b",(function(){return g})),r.d(t,"i",(function(){return O})),r.d(t,"f",(function(){return m})),r.d(t,"c",(function(){return h})),r.d(t,"d",(function(){return w})),r.d(t,"g",(function(){return j})),r.d(t,"a",(function(){return y}));var n=r(4),o=r.n(n),c=r(21),i=r(19),u=r.n(i),s=r(6),a=r(5),l=r(14);function p(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function b(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?p(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):p(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var f=function(e){var t=e.selected,r=void 0===t?[]:t,n=e.search,o=void 0===n?"":n,i=e.queryArgs,a=function(e){var t=e.selected,r=void 0===t?[]:t,n=e.search,o=void 0===n?"":n,i=e.queryArgs,u=void 0===i?[]:i,s=l.m.productCount>100,a={per_page:s?100:0,catalog_visibility:"any",search:o,orderby:"title",order:"asc"},p=[Object(c.addQueryArgs)("/wc/store/products",b(b({},a),u))];return s&&r.length&&p.push(Object(c.addQueryArgs)("/wc/store/products",{catalog_visibility:"any",include:r})),p}({selected:r,search:o,queryArgs:void 0===i?[]:i});return Promise.all(a.map((function(e){return u()({path:e})}))).then((function(e){return Object(s.uniqBy)(Object(s.flatten)(e),"id").map((function(e){return b(b({},e),{},{parent:0})}))})).catch((function(e){throw e}))},d=function(e){return u()({path:"/wc/store/products/".concat(e)})},g=function(){return u()({path:"wc/store/products/attributes"})},O=function(e){return u()({path:"wc/store/products/attributes/".concat(e,"/terms")})},m=function(e){var t=e.selected,r=function(e){var t=e.selected,r=void 0===t?[]:t,n=e.search,o=Object(a.getSetting)("limitTags",!1),i=[Object(c.addQueryArgs)("wc/store/products/tags",{per_page:o?100:0,orderby:o?"count":"name",order:o?"desc":"asc",search:n})];return o&&r.length&&i.push(Object(c.addQueryArgs)("wc/store/products/tags",{include:r})),i}({selected:void 0===t?[]:t,search:e.search});return Promise.all(r.map((function(e){return u()({path:e})}))).then((function(e){return Object(s.uniqBy)(Object(s.flatten)(e),"id")}))},h=function(e){return u()({path:Object(c.addQueryArgs)("wc/store/products/categories",b({per_page:0},e))})},w=function(e){return u()({path:"wc/store/products/categories/".concat(e)})},j=function(e){return u()({path:Object(c.addQueryArgs)("wc/store/products",{per_page:0,type:"variation",parent:e})})},y=function(e,t){if(!e.title.raw)return e.slug;var r=1===t.filter((function(t){return t.title.raw===e.title.raw})).length;return e.title.raw+(r?"":" - ".concat(e.slug))}},40:function(e,t,r){"use strict";r.d(t,"a",(function(){return s})),r.d(t,"b",(function(){return a}));var n=r(30),o=r.n(n),c=r(11),i=r.n(c),u=r(1),s=function(){var e=o()(i.a.mark((function e(t){var r;return i.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if("function"!=typeof t.json){e.next=11;break}return e.prev=1,e.next=4,t.json();case 4:return r=e.sent,e.abrupt("return",{message:r.message,type:r.type||"api"});case 8:return e.prev=8,e.t0=e.catch(1),e.abrupt("return",{message:e.t0.message,type:"general"});case 11:return e.abrupt("return",{message:t.message,type:t.type||"general"});case 12:case"end":return e.stop()}}),e,null,[[1,8]])})));return function(t){return e.apply(this,arguments)}}(),a=function(e){if(e.data&&"rest_invalid_param"===e.code){var t=Object.values(e.data.params);if(t[0])return t[0]}return(null==e?void 0:e.message)||Object(u.__)("Something went wrong. Please contact us to get assistance.",'woocommerce')}},46:function(e,t){!function(){e.exports=this.wp.escapeHtml}()},47:function(e,t,r){"use strict";var n=r(0),o=r(1),c=(r(2),r(46));t.a=function(e){var t,r,i,u=e.error;return Object(n.createElement)("div",{className:"wc-block-error-message"},(r=(t=u).message,i=t.type,r?"general"===i?Object(n.createElement)("span",null,Object(o.__)("The following error was returned",'woocommerce'),Object(n.createElement)("br",null),Object(n.createElement)("code",null,Object(c.escapeHTML)(r))):"api"===i?Object(n.createElement)("span",null,Object(o.__)("The following error was returned from the API",'woocommerce'),Object(n.createElement)("br",null),Object(n.createElement)("code",null,Object(c.escapeHTML)(r))):r:Object(o.__)("An unknown error occurred which prevented the block from being updated.",'woocommerce')))}},49:function(e,t){!function(){e.exports=this.wp.keycodes}()},5:function(e,t){!function(){e.exports=this.wc.wcSettings}()},52:function(e,t){!function(){e.exports=this.wp.hooks}()},59:function(e,t,r){"use strict";var n=r(4),o=r.n(n),c=r(20),i=r.n(c),u=r(0),s=["srcElement","size"];function a(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}t.a=function(e){var t=e.srcElement,r=e.size,n=void 0===r?24:r,c=i()(e,s);return Object(u.isValidElement)(t)?Object(u.cloneElement)(t,function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?a(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({width:n,height:n},c)):null}},6:function(e,t){!function(){e.exports=this.lodash}()},62:function(e,t){!function(){e.exports=this.wp.deprecated}()},685:function(e,t,r){e.exports=r(786)},69:function(e,t){!function(){e.exports=this.wp.serverSideRender}()},73:function(e,t){!function(){e.exports=this.wp.dom}()},74:function(e,t){!function(){e.exports=this.ReactDOM}()},78:function(e,t){!function(){e.exports=this.wp.viewport}()},786:function(e,t,r){"use strict";r.r(t);var n=r(4),o=r.n(n),c=r(0),i=r(1),u=r(6),s=r(59),a=r(32),l=Object(c.createElement)(a.SVG,{xmlns:"http://www.w3.org/2000/SVG",viewBox:"0 0 24 24"},Object(c.createElement)("path",{fill:"none",d:"M0 0h24v24H0V0z"}),Object(c.createElement)("path",{d:"M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99l1.5 1.5z"})),p=r(25),b=r(15),f=r.n(b),d=r(16),g=r.n(d),O=r(17),m=r.n(O),h=r(18),w=r.n(h),j=r(9),y=r.n(j),v=r(3),_=r(24),k=r(69),P=r.n(k),E=(r(2),r(82)),S=r(83),C=r(87),x=r(161),R=r(5);function A(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,n=y()(e);if(t){var o=y()(this).constructor;r=Reflect.construct(n,arguments,o)}else r=n.apply(this,arguments);return w()(this,r)}}var T=function(e){m()(r,e);var t=A(r);function r(){return f()(this,r),t.apply(this,arguments)}return g()(r,[{key:"getInspectorControls",value:function(){var e=this.props,t=e.attributes,r=e.setAttributes,n=t.categories,o=t.catOperator,u=t.columns,s=t.contentVisibility,a=t.rows,l=t.alignButtons;return Object(c.createElement)(_.InspectorControls,{key:"inspector"},Object(c.createElement)(v.PanelBody,{title:Object(i.__)("Layout",'woocommerce'),initialOpen:!0},Object(c.createElement)(S.a,{columns:u,rows:a,alignButtons:l,setAttributes:r,minColumns:Object(R.getSetting)("min_columns",1),maxColumns:Object(R.getSetting)("max_columns",6),minRows:Object(R.getSetting)("min_rows",1),maxRows:Object(R.getSetting)("max_rows",6)})),Object(c.createElement)(v.PanelBody,{title:Object(i.__)("Content",'woocommerce'),initialOpen:!0},Object(c.createElement)(E.a,{settings:s,onChange:function(e){return r({contentVisibility:e})}})),Object(c.createElement)(v.PanelBody,{title:Object(i.__)("Filter by Product Category",'woocommerce'),initialOpen:!1},Object(c.createElement)(C.a,{selected:n,onChange:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=e.map((function(e){return e.id}));r({categories:t})},operator:o,onOperatorChange:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"any";return r({catOperator:e})}})))}},{key:"render",value:function(){var e=this.props,t=e.attributes,r=e.name;return t.isPreview?x.a:Object(c.createElement)(c.Fragment,null,this.getInspectorControls(),Object(c.createElement)(v.Disabled,null,Object(c.createElement)(P.a,{block:r,attributes:t})))}}]),r}(c.Component),B=r(94);function D(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}Object(p.registerBlockType)("woocommerce/product-best-sellers",{title:Object(i.__)("Best Selling Products",'woocommerce'),icon:{src:Object(c.createElement)(s.a,{srcElement:l}),foreground:"#96588a"},category:"woocommerce",keywords:[Object(i.__)("WooCommerce",'woocommerce')],description:Object(i.__)("Display a grid of your all-time best selling products.",'woocommerce'),supports:{align:["wide","full"],html:!1},example:{attributes:{isPreview:!0}},attributes:function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?D(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):D(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({},B.a),transforms:{from:[{type:"block",blocks:Object(u.without)(B.b,"woocommerce/product-best-sellers"),transform:function(e){return Object(p.createBlock)("woocommerce/product-best-sellers",e)}}]},edit:function(e){return Object(c.createElement)(T,e)},save:function(){return null}})},8:function(e,t){!function(){e.exports=this.React}()},82:function(e,t,r){"use strict";var n=r(4),o=r.n(n),c=r(0),i=r(1),u=(r(2),r(3));function s(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function a(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?s(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):s(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}t.a=function(e){var t=e.onChange,r=e.settings,n=r.button,o=r.price,s=r.rating,l=r.title;return Object(c.createElement)(c.Fragment,null,Object(c.createElement)(u.ToggleControl,{label:Object(i.__)("Product title",'woocommerce'),help:l?Object(i.__)("Product title is visible.",'woocommerce'):Object(i.__)("Product title is hidden.",'woocommerce'),checked:l,onChange:function(){return t(a(a({},r),{},{title:!l}))}}),Object(c.createElement)(u.ToggleControl,{label:Object(i.__)("Product price",'woocommerce'),help:o?Object(i.__)("Product price is visible.",'woocommerce'):Object(i.__)("Product price is hidden.",'woocommerce'),checked:o,onChange:function(){return t(a(a({},r),{},{price:!o}))}}),Object(c.createElement)(u.ToggleControl,{label:Object(i.__)("Product rating",'woocommerce'),help:s?Object(i.__)("Product rating is visible.",'woocommerce'):Object(i.__)("Product rating is hidden.",'woocommerce'),checked:s,onChange:function(){return t(a(a({},r),{},{rating:!s}))}}),Object(c.createElement)(u.ToggleControl,{label:Object(i.__)("Add to Cart button",'woocommerce'),help:n?Object(i.__)("Add to Cart button is visible.",'woocommerce'):Object(i.__)("Add to Cart button is hidden.",'woocommerce'),checked:n,onChange:function(){return t(a(a({},r),{},{button:!n}))}}))}},83:function(e,t,r){"use strict";var n=r(0),o=r(1),c=r(6),i=(r(2),r(3));t.a=function(e){var t=e.columns,r=e.rows,u=e.setAttributes,s=e.alignButtons,a=e.minColumns,l=void 0===a?1:a,p=e.maxColumns,b=void 0===p?6:p,f=e.minRows,d=void 0===f?1:f,g=e.maxRows,O=void 0===g?6:g;return Object(n.createElement)(n.Fragment,null,Object(n.createElement)(i.RangeControl,{label:Object(o.__)("Columns",'woocommerce'),value:t,onChange:function(e){var t=Object(c.clamp)(e,l,b);u({columns:Number.isNaN(t)?"":t})},min:l,max:b}),Object(n.createElement)(i.RangeControl,{label:Object(o.__)("Rows",'woocommerce'),value:r,onChange:function(e){var t=Object(c.clamp)(e,d,O);u({rows:Number.isNaN(t)?"":t})},min:d,max:O}),Object(n.createElement)(i.ToggleControl,{label:Object(o.__)("Align Last Block",'woocommerce'),help:s?Object(o.__)("The last inner block will be aligned vertically.",'woocommerce'):Object(o.__)("The last inner block will follow other content.",'woocommerce'),checked:s,onChange:function(){return u({alignButtons:!s})}}))}},85:function(e,t){!function(){e.exports=this.wp.date}()},87:function(e,t,r){"use strict";var n=r(10),o=r.n(n),c=r(0),i=r(1),u=(r(2),r(45)),s=r(3),a=r(30),l=r.n(a),p=r(15),b=r.n(p),f=r(16),d=r.n(f),g=r(12),O=r.n(g),m=r(17),h=r.n(m),w=r(18),j=r.n(w),y=r(9),v=r.n(y),_=r(11),k=r.n(_),P=r(22),E=r(38),S=r(40);function C(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,n=v()(e);if(t){var o=v()(this).constructor;r=Reflect.construct(n,arguments,o)}else r=n.apply(this,arguments);return j()(this,r)}}var x=Object(P.createHigherOrderComponent)((function(e){return function(t){h()(n,t);var r=C(n);function n(){var e;return b()(this,n),(e=r.apply(this,arguments)).state={error:null,loading:!1,categories:[]},e.loadCategories=e.loadCategories.bind(O()(e)),e}return d()(n,[{key:"componentDidMount",value:function(){this.loadCategories()}},{key:"loadCategories",value:function(){var e=this;this.setState({loading:!0}),Object(E.c)().then((function(t){e.setState({categories:t,loading:!1,error:null})})).catch(function(){var t=l()(k.a.mark((function t(r){var n;return k.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,Object(S.a)(r);case 2:n=t.sent,e.setState({categories:[],loading:!1,error:n});case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())}},{key:"render",value:function(){var t=this.state,r=t.error,n=t.loading,i=t.categories;return Object(c.createElement)(e,o()({},this.props,{error:r,isLoading:n,categories:i}))}}]),n}(c.Component)}),"withCategories"),R=r(47),A=r(7),T=r.n(A),B=(r(114),function(e){var t=e.categories,r=e.error,n=e.isLoading,a=e.onChange,l=e.onOperatorChange,p=e.operator,b=e.selected,f=e.isCompact,d=e.isSingle,g=e.showReviewCount,O={clear:Object(i.__)("Clear all product categories",'woocommerce'),list:Object(i.__)("Product Categories",'woocommerce'),noItems:Object(i.__)("Your store doesn't have any product categories.",'woocommerce'),search:Object(i.__)("Search for product categories",'woocommerce'),selected:function(e){return Object(i.sprintf)(Object(i._n)("%d category selected","%d categories selected",e,'woocommerce'),e)},updated:Object(i.__)("Category search results updated.",'woocommerce')};return r?Object(c.createElement)(R.a,{error:r}):Object(c.createElement)(c.Fragment,null,Object(c.createElement)(u.b,{className:"woocommerce-product-categories",list:t,isLoading:n,selected:b.map((function(e){return t.find((function(t){return t.id===e}))})).filter(Boolean),onChange:a,renderItem:function(e){var t=e.item,r=e.search,n=e.depth,s=void 0===n?0:n,a=t.breadcrumbs.length?"".concat(t.breadcrumbs.join(", "),", ").concat(t.name):t.name,l=g?Object(i.sprintf)(Object(i._n)("%1$s, has %2$d review","%1$s, has %2$d reviews",t.review_count,'woocommerce'),a,t.review_count):Object(i.sprintf)(Object(i._n)("%1$s, has %2$d product","%1$s, has %2$d products",t.count,'woocommerce'),a,t.count),p=g?Object(i.sprintf)(Object(i._n)("%d review","%d reviews",t.review_count,'woocommerce'),t.review_count):Object(i.sprintf)(Object(i._n)("%d product","%d products",t.count,'woocommerce'),t.count);return Object(c.createElement)(u.c,o()({className:T()("woocommerce-product-categories__item","has-count",{"is-searching":r.length>0,"is-skip-level":0===s&&0!==t.parent})},e,{countLabel:p,"aria-label":l}))},messages:O,isCompact:f,isHierarchical:!0,isSingle:d}),!!l&&Object(c.createElement)("div",{className:b.length<2?"screen-reader-text":""},Object(c.createElement)(s.SelectControl,{className:"woocommerce-product-categories__operator",label:Object(i.__)("Display products matching",'woocommerce'),help:Object(i.__)("Pick at least two categories to use this setting.",'woocommerce'),value:p,onChange:l,options:[{label:Object(i.__)("Any selected categories",'woocommerce'),value:"any"},{label:Object(i.__)("All selected categories",'woocommerce'),value:"all"}]})))});B.defaultProps={operator:"any",isCompact:!1,isSingle:!1};t.a=x(B)},94:function(e,t,r){"use strict";r.d(t,"b",(function(){return o}));var n=r(5),o=["woocommerce/product-best-sellers","woocommerce/product-category","woocommerce/product-new","woocommerce/product-on-sale","woocommerce/product-top-rated"];t.a={columns:{type:"number",default:Object(n.getSetting)("default_columns",3)},rows:{type:"number",default:Object(n.getSetting)("default_rows",3)},alignButtons:{type:"boolean",default:!1},categories:{type:"array",default:[]},catOperator:{type:"string",default:"any"},contentVisibility:{type:"object",default:{title:!0,price:!0,rating:!0,button:!0}},isPreview:{type:"boolean",default:!1}}}});