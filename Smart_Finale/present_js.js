$(document).ready(function(){    
    done_outlet();
    
});
function done_outlet(){
    setTimeout( function() {
        update_outlet();
        done_outlet(); 
        },2000);
}

function update_outlet(){
$.getJSON("present_php.php", function(data){    
    var checked_radio = $('input:radio[name=zone]:checked').val();    
    $("#arus").empty();
    $("#tegangan").empty();
    $("#pf").empty();
    $("#daya").empty();
//    $("#arus").append("<sup>Current</sup> " + data.result[checked_radio].arus + " <small> Ampere</small>");       
    //    $("#tegangan").append("<sup>Voltage</sup>  " + data.result[checked_radio].tegangan + " <small> Volt</small>");        
//    $("#pf").append("<sup>pf</sup>  " + data.result[checked_radio].pf + " <small> PF</small>");        
//    $("#daya").append("<sup>Power</sup>  "+ data.result[checked_radio].daya + " <small> KWH</small>");
    $("#arus").append(data.result[checked_radio].arus);        
    $("#tegangan").append(data.result[checked_radio].tegangan);        
    $("#pf").append(data.result[checked_radio].pf);        
    $("#daya").append(data.result[checked_radio].daya);           
  
    });    
}
