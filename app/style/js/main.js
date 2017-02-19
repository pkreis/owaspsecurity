
$('#mainMenu ul li').click(function (){
    if ($(this).hasClass('active')) {
        
    }
    else{
        $('#mainMenu ul li').removeClass('active');    
        $(this).addClass('active');
        $('#mainMenu ul li ul').stop().slideUp(500);    
        $('#mainMenu ul li.active ul').slideDown(500);    
    }
});

$('#mainMenu ul li.active ul').slideDown(500);


function setCookiePanel()
{
    $i = 0;
    $('#content header .panel button[data-button]').each(function(){
        $element = ($(this).data('button'));
        $(this).addClass($.cookie($element));
        if ($(this).hasClass('active')) {
            $i++;
        }
    });
    if ($i == 0){
        $('#content header .panel button:first-child').addClass('active');
        $element = ($("#content header .panel button:first-child").data('button'));
        $.cookie($element, 'active');
        $('#content .workspace:first-of-type').addClass('active');
    }
    $('#content .workspace[data-button]').each(function(){
        $element = ($(this).data('button'));
        $(this).addClass($.cookie($element));
    }); 
}
$("#content header .panel button").click(function() {
    $element = ($(this).data('button'));
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');    
        $("#content .workspace[data-button='"+$element+"']").removeClass('active');
        $.cookie($element, '');
    }
    else{
        $(this).addClass('active');
        $("#content .workspace[data-button='"+$element+"']").addClass('active');
        $.cookie($element, 'active');
    }
});

//////////////////////////////////////
//////////FUNKCJE DYNAMICZNE//////////
//////////////////////////////////////

	function startupFunctions(){
		setCookiePanel();
	}
	function resizeFunctions(){
		
	}
	
	window.onload = startupFunctions;
	window.onresize = resizeFunctions;
	document.ready = resizeLayout;	
	
//////////////////////////////////////
//////////FUNKCJE DYNAMICZNE//////////
//////////////////////////////////////