function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
function serializeForm(submitElement)
{
    var str=$($(submitElement).closest('form')).serialize();
    return str;
}
function post(url, vars, fct)
{
    $.post(url, vars, function(data, status){
        if(status=="success"){
            try{
                var ret=JSON && JSON.parse(data) || $.parseJSON(data);
                try{fct(ret);}catch(exc){alert("An error ocurred!(fct) ajax exc:\n"+exc+"\n\n-"+data);}
                try{
                    if(ret['script']!=undefined)
                        eval(ret['script']);
                }catch(exc){alert("An error ocurred!(eval) ajax exc:\n"+exc+"\n\n-"+data);}

            }catch(exc){alert("An error ocurred!(dejson) ajax exc:\n"+exc+"\n\n-"+data);}
        }
        else alert("ajax error!");
    });
}
function ajax(vars, fct){
    post("ajax.php", vars, fct);
}
function ajaxN(vars, text, title, fct){
    var note=newNotification('loading', text, title, -1);
    ajax(vars, function(ret){
        reNotification(note, ret['status'], ret['html'], "", 4000);
        if(typeof fct !== 'undefined')
            fct(ret);
    });
}
function ajaxForm(formData, fct, fn){
    if(typeof fn !== 'undefined' )
        formData.append("fn", fn);
    $.ajax({
        type:'POST',
        url: 'ajax.php',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            try{
                var ret=JSON && JSON.parse(data) || $.parseJSON(data);
                try{fct(ret);}catch(exc){alert("An error ocurred!(fct) ajax exc:\n"+exc+"\n\n-"+data);}
                try{
                    if(ret['script']!=undefined)
                        eval(ret['script']);
                }catch(exc){alert("An error ocurred!(eval) ajax exc:\n"+exc+"\n\n-"+data);}

            }catch(exc){alert("An error ocurred!(dejson) ajax exc:\n"+exc+"\n\n-"+data);}
        },
        error: function(data){
            alert('ajax form error!');
        }
    });

}
function getUrlMid()
{
    var ar=window.location.href.split('/');
    var tmp="";
    for(var i =3;i<ar.length-1;i++)
        tmp+=ar[i]+"/";
    return tmp;
}
var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
jQuery.fn.disable = function() {
   $(this).prop("disabled", true).find('input, select, textarea').prop("disabled", true);
    return $(this);
};
jQuery.fn.enable = function() {
    $(this).prop("disabled", false).find('input, select, textarea').prop("disabled", false);
    $(this).removeAttr('disabled').find('input, select, textarea').removeAttr('disabled');
    return $(this);
};
jQuery.fn.able = function(what) {
    if(what)
        $(this).enable();
    else
        $(this).disable();
    return $(this);
};
jQuery.fn.clearVals=function(){
    $(this).find("input[type='text'], input[type='password'], select, textarea").val("");
    return $(this);
};
jQuery.fn.nTh=function(th){
    return $($(this)[th]);
};
jQuery.fn.nThC=function(th){
    return $($(this).children()[th]);
};
jQuery.fn.Pa=function(){
    return $($(this).parent());
};
jQuery.fn.disableP = function() {
    $(this).children().prop("disabled", true);
    return $(this);
};
jQuery.fn.enableP = function() {
    $(this).children().prop("disabled", false);
    return $(this);
};
jQuery.fn.toggleDisableP = function() {
    if($($(this[0]).children()[0]).prop('disabled'))
        $(this).enableP();
    else
        $(this).disableP();
    return $(this);
};
jQuery.fn.center = function () {
    this.css("position","fixed");
    this.css("top", Math.max(0, ($(window).height()/2 - $(this).outerHeight()/2)) + "px");
    this.css("left", Math.max(0, ($(window).width()/2 - $(this).outerWidth() / 2))  + "px");
    return this;
}
if (typeof String.prototype.contains != 'function')
    String.prototype.contains = function(it)
        { return this.indexOf(it) != -1; };

if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str){
        return this.indexOf(str) == 0;
    };
}
