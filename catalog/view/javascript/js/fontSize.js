// 设置html页面根节点字体大小
var _html,view_width;
fontSize();
window.onresize = fontSize;
function fontSize(){
	_html = document.getElementsByTagName('html')[0];
	view_width = $(window).width();
	view_width>750?_html.style.fontSize = 750 / 15 + 'px':_html.style.fontSize = view_width / 15 + 'px';

}