$('document').ready( function()
{
    gettotalitems();
});


function addToChart(id,q){
                var quantity = q;
                $.ajax({
                type: 'POST',
                url: '/addgood/',
                data: "id="+id+"&quantity="+quantity,
                success: function(data){
                    obj = $.parseJSON( data );
                    if (obj.error != undefined) {
                    $.createNotification({content:obj.error})
                    var html = "";
                    } 
                    else {
                    $.createNotification({content:'Товар успешно добавлен'}) } gettotal(); gettotalitems(); } });
                     
                    return false;
                    }






function gettotal(){
        }
        
function gettotalitems(){
            $.ajax({
                type: 'POST',
                url: '/totalitems/',
            
                success: function(data){
				$('.countOfItems span').html(data);
                }
            });
        return false;
        }        




