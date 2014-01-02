
function hidden(element)
{
	element='infos_'+element;

	document.getElementById(element).setAttribute("style", "display:none; visibility:hidden;");
}
function show(element)
{
	element='infos_'+element;

	document.getElementById(element).setAttribute("style", "display:inline; visibility:show;");
}
