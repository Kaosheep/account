import{_ as W,a as G,b as H,c as J,d as K,e as Q,f as X,g as Z,h as aa,i as ta}from"./tra-dcb6de31.js";import{a as y,o as ea,c as A,r as w,d as h,e as g,g as sa,f as e,h as C,t as k,F as S,i as la,j as I,k as x,s as oa,u as na,l as ra,p as ca,m as da,q as ia}from"./index-d1ddd117.js";import{C as ua,p as pa}from"./chartjs-plugin-datalabels.esm-16786eaf.js";import{_ as _a,a as m}from"./_plugin-vue_export-helper-487259a6.js";import{n as ha}from"./navp-29266585.js";const d=v=>(ca("data-v-6e04313a"),v=v(),da(),v),ga=na('<h1 data-v-6e04313a>消費分析</h1><div class="sum" data-v-6e04313a><div class="container" data-v-6e04313a></div><div class="block" data-v-6e04313a><div class="row" data-v-6e04313a></div><div class="row" data-v-6e04313a></div></div></div>',2),ma={class:"board"},va={class:"frame"},fa=d(()=>e("br",null,null,-1)),ya={class:"dochart"},ba=d(()=>e("thead",null,[e("th",null,"消費類別"),e("th",null,"消費總額")],-1)),Ca=["src"],ka={key:1},Da=d(()=>e("td",{colspan:"2"},"查無資料",-1)),Fa=[Da],Ba={key:0,class:"settime"},Aa=d(()=>e("h2",null,"輸入日期",-1)),wa=d(()=>e("label",{for:"start"},"起始日期",-1)),Sa=d(()=>e("label",{for:"end"},"結束日期",-1)),Ia={__name:"analysis",setup(v){const D=(t,a)=>{ia[t]({message:a})},F=y(null);ea(()=>{M(),$(),Y()});const B=A(()=>s.arr?s.arr.filter(t=>t.t==="0"):0),E=A(()=>s.arr?s.arr.map(t=>t.sum).reduce((t,a)=>t+parseInt(a),0):0),l=y([]),i=()=>{s.arr.map(a=>a.m_id).forEach(a=>{a==="foo"?l.value.push("#B6B6CF"):a==="clo"?l.value.push("#F5DAC2"):a==="dal"?l.value.push("#B5CAA0"):a==="edu"?l.value.push("#7DB9DE"):a==="els"?l.value.push("#ccc"):a==="med"?l.value.push("#D9CD90"):a==="tra"?l.value.push("#F8C3CD"):a==="ent"?l.value.push("#FAD689"):a==="mon"&&l.value.push("#F9BF45")})};let c;const N=()=>{c=new ua(F.value.getContext("2d"),{type:"doughnut",data:{labels:s.arr.map(t=>t.m_name),datasets:[{data:s.arr.map(t=>parseInt(t.sum)),backgroundColor:l.value,hoverOffset:4}]},options:{responsive:!0,maintainAspectRatio:!1,plugins:{legend:{position:"bottom",labels:{usePointStyle:!0}},datalabels:{labels:{title:{color:"black"}},formatter:(t,a)=>{const _=s.arr.map(b=>parseInt(b.sum)).reduce((b,P)=>b+P,0),z=(t/_*100).toFixed(1);return[`${a.chart.data.labels[a.dataIndex]}`,`${z}%`]}}}},plugins:[pa]})},f=t=>{c.data.labels=t.map(a=>a.m_name),c.data.datasets[0].data=t.map(a=>parseInt(a.sum)),c.data.datasets[0].backgroundColor=l.value,c.update()},u=()=>{c.data.labels=["沒有資料"],c.data.datasets[0].data=["0"],c.update()},V=t=>new URL(Object.assign({"../assets/image/icon/analytics.png":W,"../assets/image/icon/clo.png":G,"../assets/image/icon/dal.png":H,"../assets/image/icon/edu.png":J,"../assets/image/icon/els.png":K,"../assets/image/icon/ent.png":Q,"../assets/image/icon/foo.png":X,"../assets/image/icon/med.png":Z,"../assets/image/icon/mon.png":aa,"../assets/image/icon/tra.png":ta})[`../assets/image/icon/${t}.png`],self.location).href,o=w({full:{},year:{},month:{},date:{},day:{}}),M=()=>{let t=new Date;o.year=String(t.getFullYear()),o.month=String(t.getMonth()+1<10?"0"+(t.getMonth()+1):t.getMonth()+1),o.date=String(t.getDate()<10?"0"+t.getDate():t.getDate()),o.full=`${o.year}-${o.month}-${o.date}`;const a=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];o.day=a[new Date().getDay()]},s=w({arr:[]}),$=()=>{const t="http://localhost/dashboard/public/php/fetchbydayt.php";m.post(t,{type:"1",full:o.full}).then(a=>{a.data.length>0?(s.arr=a.data,i(),N()):(s.arr=a.data,u())}).catch(a=>{console.log(a.message)})},U=()=>{const t="http://localhost/dashboard/public/php/fetchbydayt.php";m.post(t,{type:"1",full:o.full}).then(a=>{a.data.length>0?(s.arr=a.data,l.value=[],i(),f(a.data)):(u(),s.arr=a.data)}).catch(a=>{console.log(a.message)})},L=()=>{const t="http://localhost/dashboard/public/php/fetchbydayt.php";m.post(t,{type:"2",full:o.full}).then(a=>{a.data.length>0?(s.arr=a.data,l.value=[],i(),f(a.data)):(u(),s.arr=a.data)}).catch(a=>{console.log(a.message)})},j=()=>{const t="http://localhost/dashboard/public/php/fetchbydayt.php";m.post(t,{type:"3",full:o.full}).then(a=>{a.data.length>0?(s.arr=a.data,l.value=[],i(),f(a.data)):(u(),s.arr=a.data)}).catch(a=>{console.log(a.message)})},r=y({start:"",end:""}),p=y(!1),q=()=>{p.value=!0},O=()=>{p.value=!1,r.value.start="",r.value.end=""},R=()=>{if(r.value.start=="")D("warning","未輸入起始日期");else if(r.value.end=="")D("warning","未輸入結束日期");else{const t="http://localhost/dashboard/public/php/fetchbydayt.php";m.post(t,{type:"4",full:o.full,start:r.value.start,end:r.value.end}).then(a=>{a.data.length>0?(s.arr=a.data,l.value=[],i(),f(a.data),p.value=!1):(u(),s.arr=a.data,p.value=!1)}).catch(a=>{console.log(a.message)})}},T=t=>{if(t==="foo")return"#B6B6CF";if(t==="clo")return"#F5DAC2";if(t==="dal")return"#B5CAA0";if(t==="edu")return"#7DB9DE";if(t==="els")return"#ccc";if(t==="med")return"#D9CD90";if(t==="tra")return"#F8C3CD";if(t==="ent")return"#FAD689";if(t==="mon")return"#F9BF45"},Y=()=>{const t=[...document.querySelectorAll(".board .time span")];t.forEach(a=>{a.addEventListener("click",n=>{t.forEach(_=>{_===n.target?_.style.backgroundColor="#D1AACB":_.style.backgroundColor="#B6B6CF"})})})};return(t,a)=>(h(),g(S,null,[sa(ha),e("main",null,[ga,e("div",ma,[e("div",va,[e("span",null,[C(" 支出總額 : "),fa,C(" "+k(E.value),1)]),e("div",ya,[e("canvas",{ref_key:"myChart",ref:F},null,512)])]),e("div",{class:"time"},[e("span",{style:{"background-color":"#D1AACB"},onClick:U},"本週"),e("span",{onClick:L},"本月"),e("span",{onClick:j},"今年"),e("span",{onClick:q},"自訂")]),e("table",null,[ba,B.value?(h(!0),g(S,{key:0},la(B.value,n=>(h(),g("tr",{key:n.m_id,style:ra({backgroundColor:T(n.m_id)})},[e("td",null,[e("img",{src:V(n.m_id),alt:""},null,8,Ca),C(k(n.m_name),1)]),e("td",null,k(n.sum)+"元",1)],4))),128)):(h(),g("tr",ka,Fa))])]),p.value?(h(),g("div",Ba,[Aa,e("div",null,[wa,I(e("input",{type:"date",id:"start","onUpdate:modelValue":a[0]||(a[0]=n=>r.value.start=n)},null,512),[[x,r.value.start]])]),e("div",null,[Sa,I(e("input",{type:"date",id:"end","onUpdate:modelValue":a[1]||(a[1]=n=>r.value.end=n)},null,512),[[x,r.value.end]])]),e("button",{onClick:R},"確定"),e("button",{onClick:O},"取消")])):oa("",!0)])],64))}},Ua=_a(Ia,[["__scopeId","data-v-6e04313a"]]);export{Ua as default};