//自定义js
function credit(user_id,session_id){
    $.ajax({
        type: "POST",
        url: "/index.php?s=/user/credit.html",
        data: "user_id="+user_id+"&sess_id="+session_id,
        dataType:"json",
        async:false,
        success: function(msg){
            if(msg.msg_code == 1000){

                alert(msg.msg_content);
            }else{
                alert(msg.msg_content);
            }
        }
    });
}

// 兑换记录
function exchange(goods_id,session_id){
    $.ajax({
        type: "POST",
        url: "/index.php?s=/user/exchange.html",
        data: "goods_id="+goods_id+"&sess_id="+session_id,
        dataType:"json",
        async:false,
        success: function(msg){
            if(msg.msg_code == 1000){

                alert(msg.msg_content);
            }else{
                alert(msg.msg_content);
            }
        }
    });
}
