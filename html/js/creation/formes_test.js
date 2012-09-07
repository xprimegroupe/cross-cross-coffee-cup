/**
 * Thjis file help to test newly contributed "forme"
 * uncomment files.push(...); and Add ids
 * eg: files.push('46','47','48','49','50','51', '52', '53');
 */
(function() {
    
    var files = new Array();
    
    //files.push('53');
    
    $.each(files, function(i, file) {
        les_objets_a_placer.shift();
        include_forme_js(file);
    });

}());