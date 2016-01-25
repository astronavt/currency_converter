$(document).ready(function(){
    $('#converter-form').submit(function(){
       var data = $(this).serialize();
       $.get('',data).success(function(result){    
            var values = result['body'];   
            console.log(values);      
            $('#converterform-tovalue').val(values['toValue']);
            $('#converterform-fromvalue').attr('placeholder',values['fromValue']);
       }); 
       return false;
    });
    $('#converterform-fromvalue').keyup(function(){$('#converter-form').submit();});
    $('#converter-form').change(function(){$('#converter-form').submit();});
});