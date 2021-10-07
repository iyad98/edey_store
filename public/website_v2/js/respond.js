!function(g){"use strict";var c={};function e(e,t){var n=a();n&&(n.open("GET",e,!0),n.onreadystatechange=function(){4!==n.readyState||200!==n.status&&304!==n.status||t(n.responseText)},4!==n.readyState&&n.send(null))}function p(e){return e.replace(c.regex.minmaxwh,"").match(c.regex.other)}(g.respond=c).update=function(){};var x,y,w,v,E,r,S,i,T,$,z,b,C,R,o,l,t,m=[],a=function(){var t=!1;try{t=new g.XMLHttpRequest}catch(e){t=new g.ActiveXObject("Microsoft.XMLHTTP")}return function(){return t}}();function n(){R(!0)}c.ajax=e,c.queue=m,c.unsupportedmq=p,c.regex={media:/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi,keyframes:/@(?:\-(?:o|moz|webkit)\-)?keyframes[^\{]+\{(?:[^\{\}]*\{[^\}\{]*\})+[^\}]*\}/gi,comments:/\/\*[^*]*\*+([^/][^*]*\*+)*\//gi,urls:/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,findStyles:/@media *([^\{]+)\{([\S\s]+?)$/,only:/(only\s+)?([a-zA-Z]+)\s?/,minw:/\(\s*min\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,maxw:/\(\s*max\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,minmaxwh:/\(\s*m(in|ax)\-(height|width)\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/gi,other:/\([^\)]*\)/g},c.mediaQueriesSupported=g.matchMedia&&null!==g.matchMedia("only all")&&g.matchMedia("only all").matches,c.mediaQueriesSupported||(x=g.document,y=x.documentElement,w=[],v=[],E=[],r={},S=x.getElementsByTagName("head")[0]||y,i=x.getElementsByTagName("base")[0],T=S.getElementsByTagName("link"),C=function(){var e,t=x.createElement("div"),n=x.body,a=y.style.fontSize,s=n&&n.style.fontSize,r=!1;return t.style.cssText="position:absolute;font-size:1em;width:1em",n||((n=r=x.createElement("body")).style.background="none"),y.style.fontSize="100%",n.style.fontSize="100%",n.appendChild(t),r&&y.insertBefore(n,y.firstChild),e=t.offsetWidth,r?y.removeChild(n):n.removeChild(t),y.style.fontSize=a,s&&(n.style.fontSize=s),b=parseFloat(e)},R=function(e){var t,n,a,s,r,i,o,l,m,h,d="clientWidth",u=y[d],c="CSS1Compat"===x.compatMode&&u||x.body[d]||u,p={},f=T[T.length-1],u=(new Date).getTime();if(e&&$&&u-$<30)return g.clearTimeout(z),void(z=g.setTimeout(R,30));for(t in $=u,w)w.hasOwnProperty(t)&&(a=null===(r=(n=w[t]).minw),s=null===(i=n.maxw),r=r&&parseFloat(r)*(-1<r.indexOf("em")?b||C():1),i=i&&parseFloat(i)*(-1<i.indexOf("em")?b||C():1),n.hasquery&&(a&&s||!(a||r<=c)||!(s||c<=i))||(p[n.media]||(p[n.media]=[]),p[n.media].push(v[n.rules])));for(o in E)E.hasOwnProperty(o)&&E[o]&&E[o].parentNode===S&&S.removeChild(E[o]);for(l in E.length=0,p)p.hasOwnProperty(l)&&(m=x.createElement("style"),h=p[l].join("\n"),m.type="text/css",m.media=l,S.insertBefore(m,f.nextSibling),m.styleSheet?m.styleSheet.cssText=h:m.appendChild(x.createTextNode(h)),E.push(m))},o=function(e,t,n){function a(e){return e.replace(c.regex.urls,"$1"+t+"$2$3")}var s=e.replace(c.regex.comments,"").replace(c.regex.keyframes,"").match(c.regex.media),r=s&&s.length||0,i=!r&&n;(t=t.substring(0,t.lastIndexOf("/"))).length&&(t+="/"),i&&(r=1);for(var o,l,m,h,d=0;d<r;d++){i?(o=n,v.push(a(e))):(o=s[d].match(c.regex.findStyles)&&RegExp.$1,v.push(RegExp.$2&&a(RegExp.$2))),h=(m=o.split(",")).length;for(var u=0;u<h;u++)l=m[u],p(l)||w.push({media:l.split("(")[0].match(c.regex.only)&&RegExp.$2||"all",rules:v.length-1,hasquery:-1<l.indexOf("("),minw:l.match(c.regex.minw)&&parseFloat(RegExp.$1)+(RegExp.$2||""),maxw:l.match(c.regex.maxw)&&parseFloat(RegExp.$1)+(RegExp.$2||"")})}R()},l=function(){var t;m.length&&(t=m.shift(),e(t.href,function(e){o(e,t.href,t.media),r[t.href]=!0,g.setTimeout(function(){l()},0)}))},(t=function(){for(var e=0;e<T.length;e++){var t=T[e],n=t.href,a=t.media,s=t.rel&&"stylesheet"===t.rel.toLowerCase();n&&s&&!r[n]&&(t.styleSheet&&t.styleSheet.rawCssText?(o(t.styleSheet.rawCssText,n,a),r[n]=!0):(/^([a-zA-Z:]*\/\/)/.test(n)||i)&&n.replace(RegExp.$1,"").split("/")[0]!==g.location.host||("//"===n.substring(0,2)&&(n=g.location.protocol+n),m.push({href:n,media:a})))}l()})(),c.update=t,c.getEmValue=C,g.addEventListener?g.addEventListener("resize",n,!1):g.attachEvent&&g.attachEvent("onresize",n))}(this);