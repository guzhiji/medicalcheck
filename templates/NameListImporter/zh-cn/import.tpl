请稍候……
<script>
$(function(){
    $.mobile.loading( "show" );
    progress();
});
function progress(){
    $.ajax("?mode=dialog&module=preparation/importnames&function=progress",{
        type:'GET',
        dataType:'json',
        success:function(response){
            if(response==3||response==4){
                $.mobile.loading( "hide" );
                $.mobile.changePage("?module=preparation/people");
            }else{
                progress();
            }
        }
    });
}
</script>