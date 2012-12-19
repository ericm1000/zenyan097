var mastertabvar=new Object()
mastertabvar.baseopacity=0
mastertabvar.browserdetect=""

function showsubmenu(masterid, id){
  if (typeof highlighting!="undefined")
    clearInterval(highlighting)
    submenuobject=document.getElementById(id)
    mastertabvar.browserdetect=submenuobject.filters? "ie" : typeof submenuobject.style.MozOpacity=="string"? "mozilla" : ""
    hidesubmenus(mastertabvar[masterid]) 
    submenuobject.style.display="block"   
}

function hidesubmenus(submenuarray){
  for (var i=0; i<submenuarray.length; i++) {
    document.getElementById(submenuarray[i]).style.display="none"
  }  
}

function initalizetab(tabid){
mastertabvar[tabid]=new Array()
var menuitems=document.getElementById(tabid).getElementsByTagName("li")
 for (var i=0; i<menuitems.length; i++){
  if (menuitems[i].getAttribute("rel")){
   menuitems[i].setAttribute("rev", tabid) //associate this submenu with main tab
   mastertabvar[tabid][mastertabvar[tabid].length]=menuitems[i].getAttribute("rel") //store ids of submenus of tab menu
    if (menuitems[i].className=="selected")
     showsubmenu(tabid, menuitems[i].getAttribute("rel"))
     menuitems[i].getElementsByTagName("a")[0].onclick=function(){
     showsubmenu(this.parentNode.getAttribute("rev"), this.parentNode.getAttribute("rel"))
    }
  }
 }
}