"use-strict";

var hamburgerMenuSpeed = 333;

$( document ).ready(function() {
	
   $(".hamburgerButton").click(hamMenuToggle);
   $(".hamburgerNestedButton").click(hamNestedMenuToggle);
   
   $('html').click(function() {
   	
   		$(".hamburgerMenu").each(function(){
   			if($(this).hasClass('hamburgerOpen'))
			{
				closeMenu(this);	
			}
   		});
		
	  
	});
    
});

function hamMenuToggle(input)
{
	input.stopPropagation();
	input.preventDefault();
	
	var parentMenu = $(input.target).next(".hamburgerMenu");
	
	if(parentMenu.hasClass("hamburgerClosed"))
	{
		openMenu(parentMenu,$(input.target));
	}
	else
	{
		closeMenu(parentMenu,$(input.target));
	}
	
}

function openMenu(parentMenu, buttonInput)
{
	 $(".hamburgerMenu").css("max-height",$(window).height()-50);
	 
	$(buttonInput).html("cancel");
	
	$(parentMenu).addClass("hamburgerOpen");
	$(parentMenu).removeClass("hamburgerClosed");
	
	$(parentMenu).find(".hamburgerNestedList").addClass('hamburgerNestedClosed');
	
	
	$(parentMenu).find("i").each(function(index){
		if($(this).html() == "arrow_drop_down_circle")
		{
			$(this).html("arrow_drop_down");
		}
	});
	
	$(parentMenu).css("left",-$(parentMenu).width());
	
	$(parentMenu).animate({
	    
	    left: "+=" + $(parentMenu).width(),
	    
	  }, hamburgerMenuSpeed, function() {
	    // Animation complete.
	 });
}

function closeMenu(parentMenu, buttonInput)
{
	
	if(!buttonInput)
	{
		$(".hamburgerButton").each(function(){
   			$(this).html("menu");
   		});
	}
	else
	{
		$(buttonInput).html("menu");
	}
	
	$(parentMenu).animate({
	    
	    left: "-=" + $(parentMenu).width(),
	    
	  }, hamburgerMenuSpeed, function() {
	    $(parentMenu).addClass("hamburgerClosed");
		$(parentMenu).removeClass("hamburgerOpen");
	 });
}

function hamNestedMenuToggle(input)
{
	var parentMenu; 
	input.stopPropagation();
	input.preventDefault();
	
	if($(input.target).parent().hasClass("hamburgerNestedButton"))
	{
		parentMenu= $(input.target).parent().next(".hamburgerNestedList");
	}
	else{
		parentMenu = $(input.target).next(".hamburgerNestedList");
	}
	
	
	if(parentMenu.hasClass("hamburgerNestedClosed"))
	{
		
		$(input.currentTarget).children("i").html("arrow_drop_down_circle");
		openNestedMenu(parentMenu);
	}
	else
	{
		$(input.currentTarget).children("i").html("arrow_drop_down");
		closeNestedMenu(parentMenu);
	}
}

function openNestedMenu(parentMenu)
{
	$(parentMenu).addClass("hamburgerNestedOpen");
	$(parentMenu).removeClass("hamburgerNestedClosed");
	
	$(parentMenu).find(".hamburgerNestedList").addClass('hamburgerNestedClosed');
}

function closeNestedMenu(parentMenu)
{
	$(parentMenu).addClass("hamburgerNestedClosed");
	$(parentMenu).removeClass("hamburgerNestedOpen");
}
