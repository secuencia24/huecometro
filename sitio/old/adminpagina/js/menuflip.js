$(document).ready(function()
{
$("#firstpane p.menu_head").click(function()
{
$(this).css({backgroundImage:"url(https://lh5.googleusercontent.com/-BBN4_uSiCs4/TlQJSAXI5CI/AAAAAAAABnk/cmdGRetC38U/flecha-arriba.png)"}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
$(this).siblings().css({backgroundImage:"url(https://lh5.googleusercontent.com/-mQHPLQrjxcI/TlQJSHgEsZI/AAAAAAAABno/HbkoM9nbaWQ/flecha-abajo.png)"});
});


$("#secondpane p.menu_head").mouseover(function()
{
$(this).css({backgroundImage:"url(https://lh5.googleusercontent.com/-BBN4_uSiCs4/TlQJSAXI5CI/AAAAAAAABnk/cmdGRetC38U/flecha-arriba.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
$(this).siblings().css({backgroundImage:"url(https://lh5.googleusercontent.com/-mQHPLQrjxcI/TlQJSHgEsZI/AAAAAAAABno/HbkoM9nbaWQ/flecha-abajo.png)"});
});
});