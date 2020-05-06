var after_msg;
$(function(){
    $('#login_email,#login_password').keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            doLogin();
            return false;
        }
    });
});
function chk_join(page){
    if(loginid) load_page(page);
    else msg_show('msgbox_login', '', function(){ load_page(page) });
}
function msg_show(id, msg, proc_handler){
    if($('#'+id).length){
        if(msg) $('#'+id+ ' #msg_container').html(msg);
        $('.mask_layer').show();
        $('#'+id).show();
        if(proc_handler) after_msg = function(){ proc_handler() };
        $("html, body").animate({ scrollTop: 0 });
    }else{
        alert(msg);
        if(proc_handler) proc_handler();
    }
}
function msg_hide(id){
	$('.mask_layer').hide();
	$('.msgbox').hide();
	if(after_msg) after_msg();
	after_msg = null;
}
function msgbox_show(msg){
    msg_show('msgbox_alert', msg);
}
function proc_error(errors){
    $('.has-error .control-label').remove();
    $('.has-error').removeClass('has-error');
    if(errors){
        $.each(errors, function( col, errmsg ) {
          var label = '<label class="control-label" for="'+col+'">'+errmsg +'</label>';
            if($("[for='"+col+"']").length == 0){
            $('#' + col).parent().append(label);
            $('#' + col).addClass('has-error');
            }
          //console.log("col:"+col+" emsg:"+errmsg);
        });
    }
}
function load_page(url){
    location.href=url;
}
function reload_page(){
    location.reload(true);
}
function prev_page(){
    window.history.back();
}
function register_form(frm, func_callback, func_before){
    $(frm).ajaxForm({
        beforeSubmit: function(){
                    if(func_before){
                        var s = func_before();
                        if(s === false) return false;
                    }
                    $('.loading').show();
                },
        success: function(ret){
            proc_ret(ret, func_callback, null, frm);
        },
        error: function(ret){
            if(ret.status == 422){
                var errors = ret.responseJSON;
                var err = {status:'err', errors:errors };
                proc_ret(JSON.stringify(err), func_callback, null, frm);
            }else{
                console.log(ret);
                msgbox_show('表單錯誤，我們會盡快修復，請稍候再試！');
            }
        }
    });
}
function submit_form(frm, func_callback, func_before){
        $(frm).ajaxSubmit({
        beforeSubmit: function(){
                    if(func_before){
                        func_before();
                    }
                },
        success: function(ret){
            proc_ret(ret, func_callback);
        }
    });
}
function edit_form_submit(form_id){
    for ( instance in CKEDITOR.instances ) CKEDITOR.instances[instance].updateElement();
    $(form_id).submit();
}
function get_data(url, send_data, proc_handler, err_handler){
	send_data['_token'] =  $('#csrf_token').val();
    $.ajax({
        url:url,
        type:'post',
        data:send_data,
        success:function(ret){
        	console.log(ret);
            proc_ret(ret, proc_handler, err_handler);
        },
        error:function(jq, err_status, err_string){
            console.log('get_data err_string: '+err_string);
        }
    });
}
function proc_ret(res, proc_handler, err_handler, frm){
    $('.loading').hide();
    try{
        $('.has-error').removeClass('has-error');
        $('.error-icon').remove();
        if(typeof(res) == 'string' && res.indexOf('<pre style="word-wrap: break-word; white-space: pre-wrap;">') !== false){
            res = res.replace('<pre style="word-wrap: break-word; white-space: pre-wrap;">','' );
            res = res.replace('</pre>','');
            res = $.parseJSON(res);
        }
        if(res.status == 'ok'){
            if(res.msg){
                msg_show('msgbox_alert', res.msg, function(){ if(proc_handler) proc_handler(res)});
                return;
            }
            if(proc_handler){
                try{
                    proc_handler(res);
                    return;
                }catch(e){
                    alert('要接續呼叫的指令碼發生錯誤！(PROC_HANDLER ERROR)');
                    console.log(e);
                }
            }
        }else if(res.status == 'err'){
			if(res.errors){
                var errori = 0;
                $.each(res.errors, function(k, v){
                    var errtext = '';
                    if(typeof(v) == 'object'){
                         $.each(v, function(x,y){
                            errtext += y + "\n";
                         });
                    }else if(typeof(v) == 'string'){
                        errtext = v;
                    }
                    var err_icon=$('<div class="error-icon"><i class="fa fa-exclamation-circle"></i>'+errtext+'</div>');                
                    $('input[name="' + k + '"]').parent().addClass('has-error').append(err_icon);
                    $('textarea[name="' + k + '"]').parent().addClass('has-error').addClass('txt-error').append(err_icon);
                    $('#'+k).parent().addClass('has-error').append(err_icon);
                });
                $('.has-error').eq(0).find('input,select').eq(0).focus();
            }
            if(res.msg) {
                msgbox_show(res.msg);
            }
            if(res.chkimg){
                $('#chkimg').attr('src', res.chkimg);
            }
            if(typeof(err_handler) === 'function') err_handler(res);

        }else{
            msgbox_show('沒有回傳值status，請聯絡程式人員處理！');
            console.log(res);
        }
    }catch(e){
        console.log('e='+e);
        msgbox_show('系統錯誤，可能是連線中斷，請稍候再試！!!');
        console.log(res);
    }
}
function del_item(delobj, delsn, delid){
    var _token = $('#csrf_token').val();
    if(!confirm("確定要刪除嗎？")){
        return false;
    }else{
        get_data('/do/del_obj',{delobj:delobj, delsn:delsn, '_token':_token},function(res){
            if(delid){
                $('#' + delid).remove();
            }else if($("#item_row" + delsn)){
                $("#item_row" + delsn).remove();
            }
        });
    }
}
function del_item_all(delobj, delsn){
    var _token = $('#csrf_token').val();
    if(!confirm("確定要執行嗎？？")){
        return false;
    }else{
        var delIndex = 0;
        for(var i = 0; i < delsn.length; i++) {
            get_data('/do/del_obj',{delobj:delobj, delsn:delsn[i], '_token':_token},function(res){
                if($("#item_row" + delsn[delIndex])){
                    $("#item_row" + delsn[delIndex]).remove();
                }
                delIndex++;
                return ; 
            });
        }
    }
}
function get_job(id){
    var _token = $('#csrf_token').val();
    if(!confirm("確認是否應徵？")){
        return false;
    }else{
        get_data('/do/get_job',{id:id ,'_token':_token});
    }
}