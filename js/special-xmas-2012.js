(function($) {
  'use strict';
  // domready
  $(function() {

    var Init, i, Event, View, Controller, Model, Lib;

    Event = function(sender) {
      this._sender = sender;
      this._listeners = [];
    };

    Event.prototype = {
      attach: function(listener) {
        this._listeners.push(listener);
      },

      notify: function(args) {
        var index;

        for(index = 0; index < this._listeners.length; index += 1) {
          this._listeners[index](this._sender, args);
        }
      }
    };

    View = function(model, lib) {
      var self = this;

      self.updated = new Event(this);

      self.init = function() {
        self.generateRightTiles();
      };

      model.inited.attach(self.init);

      self.generateRightTiles = function() {
        // generate rightAside
        var _rightChildHtml = [];
        for(i in lib.rightAside) {
          _rightChildHtml.push('<div class="tile' + (!lib.rightAside[i].thumbnail && ' no-thumbnail' || '') + '" data-id="' + lib.rightAside[i].id + '" id="aside_' + lib.rightAside[i].id + '">' + lib.rightAside[i].thumbnail + '<a class="title" href="./?postids=[' + lib.rightAside[i].id + ']">' + lib.rightAside[i].title + '</a>' + '</div>');
        }

        _rightChildHtml = _rightChildHtml.join('');

        lib.$rightAside.append(_rightChildHtml);

      };

      // apply template with variables

      // obj = {tpl: @String, map: @Object}
      self.$applyTemplate = function(obj) {
        var tpl = obj.tpl;
        var patt;
        for (var key in obj.map) {
          patt = new RegExp('%_' + key + '_%', 'g');
          tpl = tpl.replace(patt, obj.map[key]);
        }

        return $(tpl);

      };

      // make layout in pinterest style, fix css float left can't arrange floating box well
      self.changeLeftExcerptLayout = function() {
        // change article layout
        var _layout = {};
        _layout._width = lib.$content.width() * 50 / 100 - 15;
        _layout.heightAjdust = 0;
        _layout.boxMargin = 10;
        _layout.leftOffset = {
          left: 10,
          top: 0
        };
        _layout.rightOffset = {
          left: _layout.leftOffset.left + _layout._width + 15,
          top: 0
        };
        _layout.maxHeight = 0;
        _layout.maxL, _layout.maxR;
        lib.$leftExcerpt.not('#height_wrapper').each(function() {
          var $this = $(this);
          _layout._height = $this.height() + _layout.heightAjdust;
          var isOdd = _layout.leftOffset.top <= _layout.rightOffset.top ? true : false;;
          $this.css({
            'width': _layout._width,
            'height': _layout._height,
            'left': isOdd ? _layout.leftOffset.left : _layout.rightOffset.left,
            'top': isOdd ? _layout.leftOffset.top : _layout.rightOffset.top,
            'position': 'absolute'
          });
          _layout.extraHeight = _layout._height + _layout.boxMargin;
          if(isOdd) {
            _layout.maxL = _layout.leftOffset.top += _layout.extraHeight;
          } else {
            _layout.maxR = _layout.rightOffset.top += _layout.extraHeight;
          };
          _layout.maxHeight = Math.max(_layout.maxL, _layout.maxR);

        }).end().filter('#height_wrapper').css({
          'height': _layout.maxHeight,
          'position': 'static'
        });
      };

      self.showLeftExcerpt = function() {
        lib.$leftExcerpt.show().addClass('css3-show');
      };

      self.removeSingle = function() {
        lib.$content.find('.single').remove();
      };

      self.showSingle = function() {
        lib.$single.removeClass('css3-show');
        lib.$content.append(lib.$single);
        // init event
        lib.$leftExcerpt.css('display', 'none').removeClass('css3-show');
        lib.$single.css({
          'display': 'block'
        });
        lib.$single.addClass('css3-readyshow');
        lib.$html.animate({
          scrollTop: lib.$single.offset().top - 20
        }, 500, function() {
          lib.$single.addClass('css3-show');
          lib.$single.removeClass('css3-readyshow');
        });
      };

      self.generateSingle = function(obj) {
        var id = model.get('currentSingle');
        var singleData = model.get(id);
        // lib.$single = lib.tplSingle.clone().find('.entry-header').html(singleData.title).end().find('.entry-content').html(singleData.content).end();
        lib.$single = self.$applyTemplate({
          tpl:lib.tplSingle,
          map: {
            title: singleData.title,
            id: id,
            content: singleData.content
          }
        });
      };

      self.pushState = function(sender, obj) {

        if(history.pushState) {
          // check if browser support
          history.pushState(lib.stateObj, '', lib.historyUrl);
        }
      }
      model.historyUpdated.attach(self.pushState);
      self.update = function(sender, obj) {
        switch(obj.view) {
        case 'left-excerpt':
          {
            // main list
            self.removeSingle();
            self.showLeftExcerpt();
            self.updated.notify(obj);
            lib.$html.animate({
              'scrollTop': lib.excerptScrollTop
            }, 500);
          }
          break;
        case 'single':
          {
          // single
            self.removeSingle();
            self.generateSingle(obj);
            self.showSingle();
            self.updated.notify(obj);

          }

        }

      };

      model.viewSet.attach(self.update);

    };



    Model = function() {
      var self = this;
      var data = {};
      self.viewSet = new Event(self);
      self.inited = new Event(self);
      self.historyUpdated = new Event(self);

      self.get = function(key) {
        return data[key];
      };

      self.set = function(key, value) {
        data[key] = value;
      };

      var getUrl = function(ids) {
        var url = '';
        switch(ids[0]) {
        case 'left-excerpt':
          {
            url = './';
          }
          break;
        default:
          url = '/ajax/?postids=' + $.toJSON(ids);
        }
        return url;
      };



      self.loadAjax = function(obj) {
        // obj = {ids:@array, url:@string, global: @boolean}
        var dfd = $.Deferred();
        if(obj.ids.length === 0) {
          dfd.resolve();
        } else {
          dfd = $.ajax({
            url: obj.url,
            dataType: 'json',
            global: obj.global,
            xhr: $.progressXhr         
          }).done(function() {
            self.preload();
          });
        }
        return dfd;
      };

      self.load = function(obj) {
        var i;
        // generate url obj

        obj.oriIds = obj.ids;

        obj.ids = self.removeLoadedIds(obj.ids);

        obj.global = (typeof obj.global === 'undefined') ? true : obj.global;

        var dfd = $.Deferred();
        obj.url = getUrl(obj.ids);
        self.loadAjax({
          ids: obj.ids,
          url: obj.url,
          global: obj.global
        }).done(function(res) {
          if(obj.view === 'single' && !obj.preload) {
            self.set('currentSingle', obj.oriIds[0]);
          }
          if (typeof res === 'undefined') {
            dfd.resolve();
          } else {
            var i;
            for(i = 0; i < res.length; i++) {
              self.set(res[i].id, {
                'title': res[i].title,
                'content': res[i].content
              });
            }
            dfd.resolve();
          }
          self.updateHistory(obj)
        });
        return dfd;
      };


      // preload all content after first ajax request
      self.preload = function(obj) {
        if (!lib.preloaded) {
          // load all post
          self.load({'view': 'single', 'ids': lib.ids, 'preload': true, 'global': false})
          lib.preloaded = true;

        }
      };

      self.removeLoadedIds = function(ids) {
        var newIds = [];
        for(var i = 0; i < ids.length; i++) {
          if(typeof self.get(ids[i]) === 'undefined') {
            newIds.push(ids[i]);
          }
        }

        return newIds;

      }

      self.setView = function(obj) {
        if (typeof obj.ids === 'undefined') {
          obj.ids = [];
        }
        self.load(obj).done(function() {

          data.view = obj.view;

          self.viewSet.notify(obj);

        });

      };

      self.updateHistory = function(obj) {
        if (obj.global) {
          var url = location.protocol + '//' + location.hostname + location.pathname;
          switch(obj.view) {
            case 'single': {
              url = url + '?postids=[' + obj.oriIds[0] + ']';
            }
            break;
            case 'left-excerpt': {
              // do nothing
            }
            break;
          }
          lib.historyUrl = url;
          self.historyUpdated.notify(obj);
        }
      };

      self.getHistory = function(obj) {

      };


      self.init = function() {
        self.inited.notify();
      }

    };



    Lib = function() {
      var self = this;
      self.$html = ($.browser.mozilla || $.browser.msie) && $('html') || $('body');
      self.$content = $('#page #content');
      self.$dataContainer = $('#data_container');
      self.$rightAside = $('<div id="right_aside" class="right-aside"></div>').insertAfter(self.$content);
      self.rightAside = self.$dataContainer.data('rightaside');
      self.ids = self.$dataContainer.data('ids');
      self.viewdata = self.$dataContainer.data('viewdata');
      var $tplContainer = $('#tpl_container');
      self.tplSingle = $tplContainer.find('.single').clone().wrapAll('<div></div>').parent().html();;
      self.stateObj = {};
      self.leftExcerptInited = false;
      self.preloaded = false;
      self.historyUrl = './';
      self.excerptScrollTop = 0;

      // update $dom
      self.update = function() {
        self.$leftExcerpt = self.$content.find('article');
      }

    };

    Controller = function(model, view, lib) {

      // init model
      model.init();

      // store dom object into lib
      lib.update();

      // bind event for right aside tiles
      lib.$rightAside.find('a, .wp-post-image').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        // set view
        var postIds = [];
        postIds.push($this.closest('.tile').data('id'));
        var obj = {
          view: 'single',
          ids: postIds
        };
        model.setView(obj);
        return false;
      });

      //TODO continue check
      // checking 
      // init left excerpt, bind event, just for once, on domready or on ajax load
      self.initLeftExcerpt = function() {
        if(lib.leftExcerptInited) {
          return;
        }
        view.changeLeftExcerptLayout();
        lib.$content.find('article a, article .wp-post-image').click(function(e) {
          e.preventDefault();
          lib.excerptScrollTop = lib.$html.scrollTop();
          var $this = $(this);
          var postIds = [];
          postIds.push($this.closest('article').data('id'));
          var obj = {
            view: 'single',
            ids: postIds
          };
          model.setView(obj);
          return false;
        });

        lib.leftExcerptInited = true;

      };
      self.initSingle = function() {
        // back btn
        lib.$single.find('.back-icon').click(function() {
          model.setView({'view': 'left-excerpt'});
          return false;
        });

      };

      self.initView = function(sender, obj) {
        switch(obj.view) {
        case 'left-excerpt':
          {
            self.initLeftExcerpt();
          }
          break;
        case 'single':
          {
            self.initSingle();
          }
          break;
        }
      };

      view.updated.attach(self.initView);

      // bind event for current view
      lib.viewdata.domready = true;
      model.setView(lib.viewdata);
    };

    var model = new Model();
    var lib = new Lib();
    var view = new View(model, lib);
    var controller = Controller(model, view, lib);

  });
})(jQuery);