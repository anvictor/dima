

var arrQuery=[];

function addNewRule() {
    var rule, oper='';
    if(field.value && operator.value && +value.value>0){
        switch(operator.value){
            case 'more': oper = '>';
                break;
            case 'less': oper = '<';
                break;
            default: oper = '';
        }
        rule = field.value+':' + oper + value.value
        arrQuery.push(rule);
        console.log(arrQuery);
        showQueryArray(arrQuery);
    }else{alert("Value не может быть () или 0 или (-)");}

}

function deleteLastRule(){
    arrQuery.pop();
    showQueryArray(arrQuery);
}

function showQueryArray(arr) {
    if(('[<br>'+arr.join(",<br>")+'<br>]')!='[<br><br>]'){
        viewPlace.innerHTML = '[<br>'+arr.join(",<br>")+'<br>]';
    }else{viewPlace.innerHTML = '';}
    quereArraySend.value=arrQuery;
}

function clearAllRules() {
    arrQuery=[];
    showQueryArray(arrQuery);
}



