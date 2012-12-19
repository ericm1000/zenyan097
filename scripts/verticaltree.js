function new_window(url) 
{
 link = window.open(url,"Link");
}

function toggle(e)
{
  if (e.className == "clsHidden") 
  {
   e.className = "clsShown"
  } 
   else 
   {
    e.className = "clsHidden"
   }
}

function display_pg_in_main(main) 
{
  parent.frames(2).location.href = main;
}

function helpWindow(window_src) 
{ 
  window.open(window_src, 'newwindow', config='height=500,width=600', 
    toolbar='no', menubar='yes', scrollbars='yes', resizable='no',location='no',  
    directories='no', status='no'); 
} 