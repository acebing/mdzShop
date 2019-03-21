require.config({
	baseUrl:'./js',
	paths: {

　　　　　　"jquery": "./jquery",
　　　　}
});
require(['jquery'],function ($) {
	
	console.log($('.fbutton'));
});