/**
 * svg "formes" array container
 */
var les_objets_a_placer = new Array();

/**
 * help to include js files from in js 
 */
var include_js = function (files) {
    if(typeof files == 'string') {
        files = new Array(files);
    }
    $.each(files, function(i, file) {
        document.write(unescape('%3Cscript src="'+file+'" charset="utf-8" type="text/javascript" %3E%3C/script%3E'));
    });
};

var include_forme_js = function (file) {
    include_js('/js/creation/formes/forme_'+file+'.js');
};

(function() {
    //-- 
    var max_forme_num = 53;
    var max_num_formes = 10;
    
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
            include_forme_js(randomnumber);
            tmp_arr.push(randomnumber);
        }
    }
}());