var les_objets_a_placer = new Array();

(function() {
    //-- 
    var max_forme_num = 45;
    var max_num_formes = 10;
    
    var include_js = function (files) {
        if(typeof files == 'string') {
            files = new Array(files);
        }
        $.each(files, function(i, file) {
            document.write(unescape('%3Cscript src="'+file+'" charset="utf-8" type="text/javascript" %3E%3C/script%3E'));
        });
    }
    
    max_forme_num = max_forme_num - 1; 
//    for(var i=1; i<=max_num_formes; i++) {
//        include_js('/js/creation/formes/forme_'+(Math.floor(Math.random()*max_forme_num)+1)+'.js');
//    }
    
    var tmp_arr = [];
    
    while(tmp_arr.length < max_num_formes){
        var randomnumber=Math.ceil(Math.random()*max_forme_num)+1;
        var found=false;
        var max_lenght = tmp_arr.length;
        for(var i=0; i<max_lenght; i++){
            if(tmp_arr[i]==randomnumber){
                found=true;
                break
            }
        }
        if(!found) {
            include_js('/js/creation/formes/forme_'+randomnumber+'.js');
            tmp_arr.push(randomnumber);
        }
    }
}());