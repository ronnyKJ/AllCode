function countStringLength(str){   
    var str_length = 0;   
    for (var i = 0; i < str.length; i++){   
        if (str.charCodeAt(i)<= 256){   
            str_length += 1;   
        }else{
            str_length += 1;   
        }   
    }   
    return str_length;   
}   
function checkInputLength(obj,num){   
    var StrErr = document.getElementById("StrErr"+"-"+obj);   
    var StrInfo = document.getElementById("StrInfo"+"-"+obj);   
    var StrLength = document.getElementById("StrLength"+"-"+obj);   
    var str = $("#"+obj).val();
    var len = num - countStringLength(str);   
    if(len < 0){   
        len = 0;   
        StrErr.style.display = "block";   
        StrInfo.style.display = "none";   
    }else{   
        StrErr.style.display = "none";   
        StrInfo.style.display = "";   
    }   
    document.getElementById("StrLength"+"-"+obj).innerHTML = len;   
}   