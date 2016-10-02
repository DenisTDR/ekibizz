function colorLink(){
    //try{
    var arr=new Array();

    var theActive=getUrlVars()['pn'];
    var m=$('#menuUl');

    for(var i=0;i< m.children().length;i++)
            arr.push(m.nThC(i).children().first());

    for(var i=0;i<arr.length;i++)
        try{
            if(arr[i].attr("onclick") != 'undefined')
            if(arr[i].attr("onclick").startsWith("gotoPage('"+theActive+"'"))
                arr[i].Pa().addClass("active");
            else
                arr[i].Pa().removeClass("active");
        }catch(exc){}

}


$(window).bind('popstate', function(event) {
    // if the event has our history data on it, load the page fragment with AJAX
    var state = event.originalEvent.state;
    if (state) {
        if(typeof state.upn !== 'undefined')
            loadUPage(state.upn)
        else
            loadPage(state.pn);
    }
});

function gotoPage(page, vars){
    loading_flag=true;
    vars = typeof vars !== 'undefined' ? vars : "";
    var url="/"+getUrlMid()+"?pn="+page;
    history.pushState({pn: page}, "", url);
    loadPage(page, vars);
}
function loadPage(page, vars){
    var loadPageNotification=newNotification("loading", loading_page, please_wait, -1);
    $("#contentDiv").slideUp();
    loading_flag=true;
    post("ajax.php", "pn="+page+"&"+vars, function(ret){
        $("#contentDiv").html(ret['html']).slideDown();
        reNotification(loadPageNotification, 'success', '', page_loaded+'!', 2000);
        colorLink();
        try{reTopContent();}catch(ext){}
        loading_flag=false;
    });
}
function gotoUPage(page, vars){
    loading_flag=true;
    vars = typeof vars !== 'undefined' ? vars : "";
    var pn=getUrlVars()['pn'];
    var url="";
    if(getUrlVars()['pn']!='umyaccount'){
        pn="umyaccount";
        url="/"+getUrlMid()+"?pn="+pn+"&upn="+page;
        history.pushState({pn: pn, upn: page}, "", url);
        loadPage(pn, "upn="+page);
        return;
    }
    url="/"+getUrlMid()+"?pn="+pn+"&upn="+page;
    history.pushState({pn: pn, upn: page}, "", url);
    loadUPage(page, vars);
}
function loadUPage(page, vars){
    if($("#contentUDiv").length==0)
    {
        loadPage("umyaccount&upn="+page, vars);
        return;
    }
    loading_flag=true;
    var loadPageNotification=newNotification("loading", loading_page, please_wait, -1);
    post("ajax.php", "pn="+page+"&"+vars, function(ret){
        $("#contentUDiv").html(ret['html']);
        reNotification(loadPageNotification, 'success', '', page_loaded+'!', 2000);
        colorLink();
        try{reTopContent();}catch(ext){}
        loading_flag=false;
    });
}
function changeLanguage(toLang){
    var aNotification=newNotification("loading", "", "Loading language...",-1);
    post("ajax.php", "fn=changeLanguage&toLang="+toLang, function(ret){
        killNotification(aNotification);
        if(ret['status']=='success')
            eval(ret['js']);
        else
            alert(ret['error']);
    });
}
function newNotification(type, text, title, autoHideCd){
    autoHideCd = typeof autoHideCd !== 'undefined' ? autoHideCd : 7500;
    var theNotification = $("<div></div>");theNotification=$(theNotification);

    var theTitle= $("<div></div>");theTitle=$(theTitle);
    theTitle.toggleClass("notificationTitle");
    theTitle.html(title);
    theNotification.append(theTitle);

    var theKillBtn=$("<div></div>");theKillBtn=$(theKillBtn);
    theKillBtn.toggleClass("killButton");
    theKillBtn.click(function(){
        killNotification(theNotification);
    });
    theNotification.append(text);
    theNotification.append(theKillBtn);
    theNotification.toggleClass(type).toggleClass("notification");
    theNotification.hide();
    $("#notificationArea").append(theNotification);
    theNotification.slideDown();
    var t=theNotification.html();
    if(autoHideCd!=-1)
        setTimeout(function(){
            if(theNotification.html()==t)
                theNotification.slideUp();
        }, autoHideCd);
    return theNotification;
}
function success(text){
    newNotification('success', text, '', 5000);
}
function error(text){
    newNotification('error', text, '', 5000);
}
function killNotification(theNotification){
    $(theNotification).dequeue();
    $(theNotification).slideUp(function(){
        $(theNotification).remove();
    });
}
function reNotification(theNotification, type, text, title, autoHideCd){
    autoHideCd = typeof autoHideCd !== 'undefined' ? autoHideCd : 7500;
    var theTitle= $("<div></div>");theTitle=$(theTitle);
    theTitle.toggleClass("notificationTitle");
    theTitle.html(title);
    theNotification.html(theTitle);

    theNotification.removeClass();
    theNotification.toggleClass(type).toggleClass("notification");
    theNotification.append(text);

    var theKillBtn=$("<div></div>");theKillBtn=$(theKillBtn);
    theKillBtn.toggleClass("killButton");
    theKillBtn.click(function(){
        killNotification(theNotification);
    });
    theNotification.append(theKillBtn);
    var t=theNotification.html();
    if(autoHideCd!=-1)
        setTimeout(function(){
            if(theNotification.html()==t)
                theNotification.slideUp();
        }, autoHideCd);
    return theNotification;
}
function previewImage(path){
    var cover= $("<div></div>");cover.toggleClass('imagePrevCover');
    var body=$('body').append(cover);
    var cont1=$("<div></div>");cont1.toggleClass('imagePrevContainer');
    var cont2=$("<div></div>");
    var img=$("<img></img>");img.attr('src', path);img.attr('alt', 'Loading...');
    cont2.append(img);
    cont1.append(cont2);
    body.append(cont1);
    cover.fadeIn();
    img.slideDown();
    cont1.click(function(){
        cover.fadeOut();
        img.slideUp(function(){
            cover.remove();
            cont1.remove();
        });
    });
}