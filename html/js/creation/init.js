$(document).ready(function() {
    $('label').inFieldLabels();

    /* PAPER */
    var paper = new Raphael(document.getElementById('raphael'), 1020, 850);

    var even_color ='225,66,66';
    var odd_color ='98,195,188';
    
    /*positions*/
    var all_pos = ["t40,540", "t200,540", "t360,540", "t520,540", "t680,540", "t40,700", "t200,700", "t360,700", "t520,700", "t680,700"];


    var isEven = function(someNumber){
        return (someNumber%2 == 0);
    };

    var meshandles = [];

    /*4 - appliquer .set et .push aux elements du tableau objet "racine" */

    var inc = 0;

    $.each(les_objets_a_placer, function(i, elt) {

        var forme = paper.set();
        $.each(elt, function(j, sub_elt) {
            var shapes = paper.path(sub_elt)
            forme.push(shapes)

            if (isEven(inc)) {
                shapes.attr({
                    fill:"rgb("+even_color+")", 
                    stroke:"none"
                });
            }else {
                shapes.attr({
                    fill:"rgb("+odd_color+")", 
                    stroke:"none"
                });
            }
            ++inc;

        });


        /*POSITIONING*/
        forme.transform(all_pos[i]);
    
        /*FREETRANSFROM*/
        var ft = paper.freeTransform(forme);

        ft.setOpts({
            keepRatio: true,
            draw: "circle",
            rotate: "axisX",
            scale: "axisX",
            drag: "self"
        });

        //HIDE THE HANDLES
        meshandles.push(ft);


    });

    var the_hide = function(){
        for(var i = 0 ; i < meshandles.length; i++){
            meshandles[i].hideHandles();
        }
    }

    var the_show = function(){
        for(var i = 0 ; i < meshandles.length; i++){
            meshandles[i].showHandles();
        }
    }



    /*LOGO : SHAPES */
    var logo_ribbon = paper.path("M286.469,164.988 L 266.852,145.371 L 285.85,126.373 L 23.58,126.373 L 42.578,145.371 L 22.961,164.988").attr({
        fill:"rgb("+odd_color+")", 
        stroke:"none"
    });
    var logo_line_top = paper.path("M40 119L270 119").attr({
        stroke:"#62c3bc"
    });
    var logo_line_bottom = paper.path("M40 172L270 172").attr({
        stroke:"#62c3bc"
    });

    var logo_shape = paper.path("M257.46,129.596 c0,34.619-17.227,65.214-43.576,83.682c-16.576,11.617-36.763,18.435-58.541,18.435c-31.627,0-59.896-14.378-78.627-36.955 c-14.67-17.682-23.489-40.392-23.489-65.163c0-31.652,14.401-59.942,37.009-78.672c17.674-14.643,40.363-23.444,65.107-23.444 c31.283,0,59.28,14.067,78.012,36.22C248.394,81.485,257.46,104.482,257.46,129.596z").attr({
        fill:"rgb("+odd_color+")", 
        stroke:"rgb("+even_color+")", 
        "stroke-width":15
    });
    var logo_shape_1 = "M257.46,129.596 c0,34.619-17.227,65.214-43.576,83.682c-16.576,11.617-36.763,18.435-58.541,18.435c-31.627,0-59.896-14.378-78.627-36.955 c-14.67-17.682-23.489-40.392-23.489-65.163c0-31.652,14.401-59.942,37.009-78.672c17.674-14.643,40.363-23.444,65.107-23.444 c31.283,0,59.28,14.067,78.012,36.22C248.394,81.485,257.46,104.482,257.46,129.596z";
    var logo_shape_2 = "M154.646,31.949c0,0-108.733,61.318-108.733,130.841c0,30.501,24.587,55.184,54.916,55.184c19.017,0,35.773-5.335,45.611-17.229 c-6.527,24.069-14.922,52.829-17.792,52.829h53.408c-2.887,0-11.265-28.76-17.809-52.813 c9.854,11.877,26.596,17.213,45.611,17.213c30.33,0,54.916-24.682,54.916-55.184C264.774,93.267,154.646,31.949,154.646,31.949";
    var logo_shape_3 = "M155.343,18 c6.936,0,13.346,3.01,16.832,9.002l95.195,163.361c3.502,6.025,3.52,13.147,0.043,19.184c-3.473,6.036-9.908,9.453-16.873,9.453 H60.147c-6.97,0-13.41-3.586-16.882-9.629c-3.47-6.043-3.447-13.414,0.063-19.434l47.59-81.606L138.503,27 c3.481-6.001,9.894-9,16.834-9H155.343z";

    paper.text(509,275, "COFFEE").attr({
        "font-size": "35", 
        "text-align":"left", 
        "font-family": "HelveticaRoundedCondensed", 
        "fill" : "#ffffff", 
        "width":"250"
    });
    paper.text(509,320, "CUP").attr({
        "font-size": "70", 
        "text-align":"left", 
        "font-family": "HelveticaRoundedCondensed", 
        "fill" : "#ffffff", 
        "width":"250"
    });
  
    var logo = paper.set();
    logo.push(logo_ribbon, logo_line_bottom, logo_line_top, logo_shape );
 

    /* NAME */


    var the_name = $('#enter_name input').val();

    $('#enter_name input').change(function() {
        var the_new_name = $('#enter_name input').val();
        name_t.attr('text', the_new_name)
    });
    var name_t = paper.text(509, 238, the_name).attr({
        "font-size": "20", 
        "text-align":"left", 
        "font-family": "HelveticaRoundedCondensed", 
        "fill" : "#ffffff", 
        "width":"250"
    });
    name_t.attr('text', 'cross:cross')
  
    /* TWITTER */

    var twitter_t = paper.text(509, 90, the_twitter).attr({
        "text":"twitter", 
        "font-size": "14", 
        "text-align":"left", 
        "font-family": "Georgia", 
        "font-weight": "bold", 
        "font-style": "italic", 
        "fill" : "rgb("+odd_color+")"
    });
    var twitter_t_width = twitter_t.getBBox().width
    var picto_twitter = paper.path('M24.936,5.225c-0.867,0.383-1.805,0.646-2.785,0.762c1.002-0.6,1.771-1.551,2.135-2.685 c-0.938,0.558-1.977,0.962-3.087,1.178c-0.884-0.941-2.14-1.533-3.538-1.533c-2.682,0-4.854,2.173-4.854,4.853 c0,0.384,0.04,0.755,0.123,1.108C8.896,8.705,5.319,6.771,2.925,3.835C2.506,4.553,2.274,5.387,2.274,6.276 c0,1.682,0.855,3.169,2.157,4.042c-0.8-0.03-1.544-0.245-2.201-0.606c0,0.015,0,0.04,0,0.059c0,2.353,1.676,4.311,3.896,4.76 c-0.409,0.109-0.839,0.168-1.28,0.168c-0.313,0-0.618-0.029-0.913-0.086c0.615,1.928,2.408,3.332,4.532,3.367 c-1.659,1.306-3.753,2.078-6.025,2.078c-0.394,0-0.779-0.02-1.158-0.064c2.147,1.379,4.697,2.182,7.438,2.182 c8.93,0,13.809-7.396,13.809-13.813c0-0.21-0.003-0.42-0.012-0.629C23.466,7.051,24.289,6.198,24.936,5.225z').attr({
        fill:"rgb("+even_color+")", 
        stroke:"none"
    });
    var the_twitter = $('#enter_twt input').val();
  
    var movedatwt = function(obj, x){
        obj.transform("t"+(500-x)+",80")
    }
    movedatwt(picto_twitter, twitter_t_width);

    $('#enter_twt input').change(function() {
        var the_new_twitter = $('#enter_twt input').val();
        twitter_t.attr('text', the_new_twitter);
        var twitter_t_width = twitter_t.getBBox().width;
        movedatwt(picto_twitter, twitter_t_width);
    });


    /*LOGO : DYNAMIC BABY*/
    var params = {
        path: logo_shape_2
    };

    /*ALL LOGO SHAPES*/
    var the_logos_shapes = new Array(logo_shape_1, logo_shape_2, logo_shape_3);
    var count_shapes = the_logos_shapes.length;

    logo.click(function(){
        params.path =  the_logos_shapes[Math.floor(Math.random()*count_shapes)];
        logo_shape.animate(params,500,"elastic");
    })


    var ft_text = paper.freeTransform(name_t);
    ft_text.setOpts({
        keepRatio: true,
        draw: "circle",
        rotate: "none",
        scale: "self",
        drag: "center",
        boundary: {
            x: 509, 
            y: 200, 
            width: 0, 
            height: 50
        }
    })
    //HIDE THE HANDLES
    meshandles.push(ft_text);


    /*VARIATIONS*/


    var reset_position = function(){
        logo.transform("t355,150");
    }
    reset_position();

    /*INVERT COLORS*/
    $('#colors').click(function(){
        $('#raphael path').each(function() {
            $(this).attr('fill', ($(this).attr('fill') == '#e14242'? '#62c3bc': '#e14242'));
            if($(this).attr('stroke') != 'none') {
                $(this).attr('stroke', ($(this).attr('stroke') == '#e14242'? '#62c3bc': '#e14242'));
            }
        });

        twitter_t.attr('fill', (twitter_t.attr('fill') == '#e14242'? '#62c3bc': '#e14242'));
        
        return false;
    });

    /*SHOW / HIDE TOOLS*/
    $('#tools').toggle(function() {
        the_hide();
    }, function() {
        the_show();
    });



    /*PICTURE IT*/

    function clearCanvas_normal(){
        var canvas = document.getElementById("canvas_normal_crop");
        var context = canvas.getContext("2d");
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function clearCanvas_x2(){
        var canvas = document.getElementById("canvas_x2_crop");
        var context = canvas.getContext("2d");
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    /* RESET SIZE */
  
    function reset_size(){
        paper.setViewBox("auto","auto",700,660)
    }

    $('#reset').click(function(){
        reset_size();
    })
 
    /* / RESET SIZE */

    $('.cta').click(function(){

        clearCanvas_normal();
        the_hide();

        $('<svg>').append('<img src="img/the_sticky.png" />')

        var full = document.getElementById('canvas_normal_raw');
        full.width=1020;
        full.height=850;
        var svg = $('#raphael').html().replace(/>\s+/g, ">").replace(/\s+</g, "<");
        canvg(full, svg) 

        //crop
        var myVisibleCanvas = document.getElementById('canvas_normal_crop');
        var ctx = myVisibleCanvas.getContext('2d');
        ctx.drawImage(full,0,63,1020,461,0,0,1020,461);
        var sticky = document.querySelector("#sticky");
        ctx.drawImage(sticky, 0, 52);
    
        //production du PNG
        var rotate = Math.ceil(Math.random()*7)
        var img = document.getElementById('canvas_normal_crop').toDataURL("image/png");
        $('body').append('<img style="border:1px solid #000" class="white_box style_'+rotate+'" src="'+img+'"/>');
        the_show();
        
        return false;
    });

    
    /* HD */
    $('#vector').click(function(){
        the_hide();

        var svg = $('#raphael').html().replace(/>\s+/g, ">").replace(/\s+</g, "<");

        var img = document.getElementById('canvas_normal_crop').toDataURL("image/png");
        var twitter = $('#twitter').val();
        var name = $('#name').val();

        $('#vector_render').val(svg);

        var request = $.ajax({
            "type": "POST",
            "url": "/c4/cup",
            "data": {
                twitter: twitter, 
                name: name, 
                svg: img
            } ,
            "dataType": "json"
        });
        
        request.done(function(id) {
            document.location.href = "/c4/cup/" + id;
        });
    });


    /* /HD */

    $('#process').hide();

//END FUNCTIONS

});