//自定义js
function credit(user_id,session_id){
    $.ajax({
        type: "POST",
        url: "/index.php?s=/user/credit.html",
        data: "user_id="+user_id+"&sess_id="+session_id,
        dataType:"json",
        async:false,
        success: function(msg){
            alert("成功~");
        }
    });
}
