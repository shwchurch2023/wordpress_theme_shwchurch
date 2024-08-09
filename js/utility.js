
// via weibo
//var weibo_r = 'http://t.cn/zTNjNST';
// via paul lan's
var weibo_r = 'http://r1.xiaofang.me:78';
//change old location hash to new format
location.hash = location.hash.replace('selector/#', 'selector/ID_');
location.hash = location.hash.replace('selector/%23', 'selector/ID_');

(function($) {

  $.siteTitle = '基督教北京守望教会';

  var switchTabTimeoutId = 0;

  var hashEventCase = {
    homeTab: function() {

	  var patt = new RegExp('#\\/hashEvent(.+?)\\/selector\\/(ID_[a-zA-Z0-9_]*)'),
      hashPart = patt.exec(location.hash);

      return hashPart;
    }
  }

  $.extend({
    hashEvent: function() {
            // add left nav jump according to the url
      // match demo:
      //   location.hash = 'hashEventClick/selector/' + encodeURI($this.attr('id'));

      var hashPart = hashEventCase.homeTab();
      if ( hashPart != null) {
        var myEvent = hashPart[1].toLowerCase(),

            selector = decodeURI(hashPart[2]);
        $(selector.replace('ID_', '#')).trigger(myEvent)
      }

    },
    onHashChange: function () {
      // bind event on hash change
      $(window).bind('hashchange', function(){
        $.hashEvent();
      })

    },
    homePage: function(){
            // prevent click on left nav

      // nav
      var leftNavClick = function(e) {

        switchTabTimeoutId && clearTimeout(switchTabTimeoutId);

        var $this = $(this);
        var thisId = $this.attr('id');

        switchTabTimeoutId = setTimeout(function(){


        if($.lastDialogMain) {
          $.lastDialogMain.hide();
        }
        var _offset = $this.offset();
        $('#hover_layer_left_arrow').css('display', 'block').offset({
          left: _offset.left + 100,
          top: _offset.top + 1
        });
        $.lastDialogMain = $.lastDialog = $('#' + thisId + '_hover').show();

        // change title for Weixin share fix
        var documentTitle = $this.text();

        switch (true) {
          case /sermon|worship|xh|ejournal/.test(thisId): {
            documentTitle += ' >> ' + $.lastDialogMain.find('h2.post-title').text()

          }
          break;
        }

        documentTitle += ' | ' + $.siteTitle;

        document.title = documentTitle;

        $('#hover_layer_up_arrow').hide();


        }, 0);

        location.hash = '/hashEventClick/selector/' + encodeURI('ID_' + thisId);
        e.preventDefault();


      }


      var $leftNavA = $('#main .left-nav a').bind('click', leftNavClick);

      var hashPart = hashEventCase.homeTab();
      if (hashPart == null) {

        // Sunday morning, jump to sermon
        var now = new Date(), hour = now.getHours();
        if (now.getDay() === 0 && (hour > 5 && hour < 16 )) {
          $leftNavA.filter('#main_worship').click();
        } else {
          $leftNavA.filter('.default').click();
        }
      }

      $('#current_cat_container a').appendTo('#access_sw .padding-wrapper');


    },
    init: function() {
      window['void'] = function() {

      };

      $.showDialogTimeout = 0;
      $.showDialogEnter = 0;
      $.$main = $('#main');


      $('.sw-icon-close').on('click', function() {
        var $this = $(this);
        $('#hover_layer_up_arrow').css('display', 'none');
        $this.closest('.hover-layer').hide();
        if($this.hasClass('main-content')) {
          $.lastDialogHeader && $.lastDialogHeader.hide();
        } else {
          $.$main.show();
        }

        $.lastDialog.hide();


        // warning IE6
      });


      $.loadingIcon = $('#loading_icon');
      $.progressBar = $('progress', $.loadingIcon);

      var ieVersion = getMsieVersion();

      var ieWarning = '<h4 style="color:#f00;font-size:18px;margin: 30px;">你使用的浏览器 Internet Explorer ' + ieVersion + ' 已经是淘汰而且不安全的浏览器，我们目前无法保证你可以正常浏览守望网站。<br /> 建议下载安装 <a href="http://down.tech.sina.com.cn/content/40975.html">谷歌Chrome浏览器</a>。</h4>';
      if(ieVersion && ieVersion <= 6) {
        $(ieWarning).insertBefore('#access_sw');
      }

      $(document).ajaxStart(function() {
        $.loadingIcon.show();
        $.progressBar.show();
        $.animateFn({
          from: 0,
          to: $.progressBar.attr('max')/10,
          step: function(v) {
            $.progressBar.attr('value',  v);
          }
        });
      });
      $(document).ajaxStop(function() {
        $.animateFn({
          from: $.progressBar.attr('value'),
          to: $.progressBar.attr('max'),
          step: function(v) {
            $.progressBar.attr('value',  v);
          },
          complete: function() {
            $.loadingIcon.hide();
          }
        });
      });
    },
    nav: function() {
      $('#access_sw a.nav:not(.link)').mouseenter(function() {
        var $this = $(this);
        clearTimeout($.showDialogTimeout);

        $.showDialogEnter = $.now();
        $.showDialogTimeout = setTimeout(function() {
          if($.lastDialogHeader) {
            $.lastDialogHeader.hide();
          }
          var _offset = $this.offset();
          $('#hover_layer_up_arrow').css('display', 'block').offset({
            left: _offset.left,
            top: _offset.top + 22
          });
          $.lastDialogHeader = $.lastDialog = $('#' + $this.attr('id') + '_hover').show();
          $.$main.hide();
          $('#hover_layer_left_arrow').hide();
        }, 300);
      }).mouseleave(function() {
        if($.now() - $.showDialogEnter < 300) {
          clearTimeout($.showDialogTimeout);
        }
      });
    },
    toplink: function() {
      $('#nav_group').click(function() {
        alert($.trim($('#nav_group_hover').find('.entry').text()));
      });
    },
    weibo: function() {
      $('#weibo').click(function() {
        var title = '';
        var siteName = '北京_守望_教会网站';
        var getText = function($obj, len) {
            return $.trim($obj.find('p').text()).substring(0, len);
          };
        var isHome = (location.pathname === '/');
        var $entry = $('body').find('.entry-content');
        var firstTitle = document.title.replace('  ', ' ').split('|')[0].toString();
        var documentTitle = ('#' + firstTitle.replace($.siteTitle, '')).substring(0, 30);
        var lenToGet = 115 - documentTitle.length;

        var entryTitle = documentTitle + '# ' + getText($entry, lenToGet);
        if($entry.length > 1) {
          entryTitle = documentTitle;
        }

        title = (isHome && ( $('.main-content').filter(':visible').find('header').text() )) || entryTitle;


        var pic = location.protocol + '//' + location.hostname + '/wp-content/themes/shwchurch/images/logo.png';
        pic = $('body').find('.size-thumbnail:first').attr('src') || $('body').find('.wp-post-image:first').attr('src') || pic;
        var myUrl = weibo_r + location.pathname;
        if (isHome) {
          myUrl = weibo_r + '/' + location.hash;
        }

        var param = {
          url: myUrl,
          type: '2',
          count: '1',
          /**是否显示分享数，1显示(可选)*/
          appkey: '',
          /**您申请的应用appkey,显示分享来源(可选)*/
          title: title,
          /**分享的文字内容(可选，默认为所在页面的title)*/
          // pic: pic,
          /**分享图片的路径(可选)*/
          ralateUid: '3180084791',
          /**关联用户的UID，分享微博会@该用户(可选)*/
          language: 'zh_cn',
          /**设置语言，zh_cn|zh_tw(可选)*/
          rnd: new Date().valueOf()
        };
        var temp = [];
        for(var p in param) {
          temp.push(p + '=' + encodeURIComponent(param[p] || ''));
        }
        temp = temp.join('&');
        var _url = 'http://service.weibo.com/share/share.php?' + temp;
        window.open(_url, '_blank', "width=615,height=505");
      });
    },
    loadjQueryPlugins: function() { /*! jQuery JSON plugin 2.4.0 | code.google.com/p/jquery-json */
      (function($) {
        'use strict';
        var escape = /["\\\x00-\x1f\x7f-\x9f]/g,
          meta = {
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"': '\\"',
            '\\': '\\\\'
          },
          hasOwn = Object.prototype.hasOwnProperty;
        $.toJSON = typeof JSON === 'object' && JSON.stringify ? JSON.stringify : function(o) {
          if(o === null) {
            return 'null';
          }
          var pairs, k, name, val, type = $.type(o);
          if(type === 'undefined') {
            return undefined;
          }
          if(type === 'number' || type === 'boolean') {
            return String(o);
          }
          if(type === 'string') {
            return $.quoteString(o);
          }
          if(typeof o.toJSON === 'function') {
            return $.toJSON(o.toJSON());
          }
          if(type === 'date') {
            var month = o.getUTCMonth() + 1,
              day = o.getUTCDate(),
              year = o.getUTCFullYear(),
              hours = o.getUTCHours(),
              minutes = o.getUTCMinutes(),
              seconds = o.getUTCSeconds(),
              milli = o.getUTCMilliseconds();
            if(month < 10) {
              month = '0' + month;
            }
            if(day < 10) {
              day = '0' + day;
            }
            if(hours < 10) {
              hours = '0' + hours;
            }
            if(minutes < 10) {
              minutes = '0' + minutes;
            }
            if(seconds < 10) {
              seconds = '0' + seconds;
            }
            if(milli < 100) {
              milli = '0' + milli;
            }
            if(milli < 10) {
              milli = '0' + milli;
            }
            return '"' + year + '-' + month + '-' + day + 'T' + hours + ':' + minutes + ':' + seconds + '.' + milli + 'Z"';
          }
          pairs = [];
          if($.isArray(o)) {
            for(k = 0; k < o.length; k++) {
              pairs.push($.toJSON(o[k]) || 'null');
            }
            return '[' + pairs.join(',') + ']';
          }
          if(typeof o === 'object') {
            for(k in o) {
              if(hasOwn.call(o, k)) {
                type = typeof k;
                if(type === 'number') {
                  name = '"' + k + '"';
                } else if(type === 'string') {
                  name = $.quoteString(k);
                } else {
                  continue;
                }
                type = typeof o[k];
                if(type !== 'function' && type !== 'undefined') {
                  val = $.toJSON(o[k]);
                  pairs.push(name + ':' + val);
                }
              }
            }
            return '{' + pairs.join(',') + '}';
          }
        };
        $.evalJSON = typeof JSON === 'object' && JSON.parse ? JSON.parse : function(str) {
          return eval('(' + str + ')');
        };
        $.secureEvalJSON = typeof JSON === 'object' && JSON.parse ? JSON.parse : function(str) {
          var filtered = str.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, '');
          if(/^[\],:{}\s]*$/.test(filtered)) {
            return eval('(' + str + ')');
          }
          throw new SyntaxError('Error parsing JSON, source is not valid.');
        };
        $.quoteString = function(str) {
          if(str.match(escape)) {
            return '"' + str.replace(escape, function(a) {
              var c = meta[a];
              if(typeof c === 'string') {
                return c;
              }
              c = a.charCodeAt();
              return '\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
            }) + '"';
          }
          return '"' + str + '"';
        };
      }(jQuery));
    },
    /**
     * use to check HTML5 support
     * user case: $.isAttrSupported('input', 'placeholder');
     *
     */
    isAttrSupport: function(tagName, attrName) {

      var c = tagName + '_' + attrName;
      if(c in $.isAttrSupported) {
        return $.isAttrSupported[c];
      }
      $.isAttrSupported[c] = attrName in document.createElement(tagName);
      delete input;
      return $.isAttrSupported[c];
    },

    /**
     * controll progress bar in loading icon
     * @return xhr
     * user case:
     * $.ajax({
     *  url: './path',
     *  xhr: $.progressXhr
     * })
     */
    progressXhr: function() {
      var xhr = $.ajaxSettings.xhr();;

      if('withCredentials' in xhr) { // check if XHR2 available
        xhr.addEventListener('progress', function(e) {
          if(e.lengthComputable) {
            $.progressBar.attr({
              max: e.total
            });
            $.animateFn({
              from: $.progressBar.attr('value'),
              to: e.loaded,
              step: function(v) {
                $.progressBar.attr('value', v);
              }
            });

          }
        }, false); // for handling the progress
      }
      return xhr;
    },
    /**
     * animate update a value
     * user case
     *  $.animateFn({from: 10, to: 90, step: function(v) {
     *      console.log(v);
     *    }
     *  })
     */
    animateFn: function(obj) {
      obj.duration = obj.duration || 1000;
      $({_v: obj.from}).animate({_v:obj.to}, {
        duration: obj.duration,
        easing: 'swing',
        step: function() {
          obj.step.call(this, Math.ceil(this._v));
        },
        complete: obj.complete
      })
    }

  });

})(jQuery);

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34557703-1']);
  _gaq.push(['_setDomainName', 'shwchurch.org']);
  _gaq.push(['_trackPageview']);

setTimeout(function(){

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
}, 8000)
//Google analytics and Disqus


function getMsieVersion() {
var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");

if (msie > 0) // If Internet Explorer, return version number
{
  return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
}

return false;
}
