(function($){

  $(initOnDomReady)
  //TODO: tmp fix for jquery old version issue
  //$(window).load(initOnDomReady)
  
  // domready
  function initOnDomReady(){
    window.swLoaded = true;
    $.loadjQueryPlugins();
    $.init();
    $.nav();
    $.toplink();

    if (location.pathname === '/') {
    	$.homePage();
    }
    $.hashEvent();
    $.weibo();
    $.onHashChange();
  };
})(jQuery);
