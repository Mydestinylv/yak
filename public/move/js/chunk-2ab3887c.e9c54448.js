(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2ab3887c"],{"5dc0":function(t,s,e){"use strict";e.r(s);var o=function(){var t=this,s=t.$createElement,o=t._self._c||s;return o("div",{staticClass:"register-box"},[o("img",{staticClass:"logo-img",attrs:{src:e("9d64")}}),o("div",{staticStyle:{"padding-right":"1.143rem"}},[o("van-field",{staticClass:"w-100b colon",attrs:{label:"手机号",placeholder:"请输入手机号"},model:{value:t.tel,callback:function(s){t.tel=s},expression:"tel"}}),o("van-field",{staticClass:"w-100b colon",attrs:{label:"密码",placeholder:"请输入密码"},model:{value:t.password,callback:function(s){t.password=s},expression:"password"}}),o("van-field",{staticClass:"w-100b colon",attrs:{label:"确认密码",placeholder:"请确认密码"},model:{value:t.repassword,callback:function(s){t.repassword=s},expression:"repassword"}}),o("van-field",{staticClass:"w-100b colon",attrs:{label:"验证码",placeholder:"请输入验证码"},model:{value:t.code,callback:function(s){t.code=s},expression:"code"}},[o("button",{staticClass:"get-code-bt",attrs:{slot:"button"},on:{click:t.send},slot:"button"},[t._v("获取验证码")])])],1),o("div",{staticClass:"mg-top-20"},[o("van-radio",{staticClass:"font-9",attrs:{"icon-size":"0.9rem"}},[t._v(" 我同意并勾选 "),o("span",{staticClass:"color-2D8BFF"},[t._v("《xx协议》")])])],1),o("van-button",{staticClass:"register-bt radius-5",on:{click:t.reg}},[t._v("注册")]),o("div",{staticClass:"tx-right"},[o("router-link",{attrs:{to:"/login"}},[o("span",{staticClass:"font-9 color-2D8BFF",staticStyle:{"margin-right":"2.143rem"}},[t._v("已有账号，立即去登陆")])])],1)],1)},a=[],l=e("4ec3"),c={name:"register",data:function(){return{tel:"",password:"",repassword:"",code:""}},methods:{send:function(){Object(l["j"])({tel:this.tel}).then((function(t){console.log(t)}))},reg:function(){var t=this,s={tel:this.tel,password:this.password,repassword:this.repassword,code:this.code};console.log(s),Object(l["i"])(s).then((function(s){console.log(s),200==s.data.status&&t.$router.push({path:"/login"})}))}},created:function(){console.log(111)}},n=c,i=(e("e41f"),e("2877")),r=Object(i["a"])(n,o,a,!1,null,"c8b7c3f4",null);s["default"]=r.exports},6551:function(t,s,e){},"9d64":function(t,s,e){t.exports=e.p+"img/logo.f6578f43.png"},e41f:function(t,s,e){"use strict";var o=e("6551"),a=e.n(o);a.a}}]);
//# sourceMappingURL=chunk-2ab3887c.e9c54448.js.map