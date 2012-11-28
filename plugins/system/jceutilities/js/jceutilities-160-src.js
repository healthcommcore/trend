/*
 * JCE Utilities 1.6.0
 *
 * Copyright (c) 2007 - 2008 Ryan Demmer (www.cellardoor.za.net)
 * Licensed under the GPL (http://www.gnu.org/licenses/licenses.html#GPL)license.
 * JCE Tooltips based on Mootools Tips plugin - http://www.mootools.net
 * JCE Lightbox plugin based on Slimbox - http://www.digitalia.be/software/slimbox - and Thickbox - http://jquery.com/demo/thickbox/
 */
jQuery.noConflict();
(function($){
	$.extend({
		getWidth: function(){
			return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
		},	
		getHeight: function(){
			return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
		},
		getScrollHeight: function(){
			return document.documentElement.scrollHeight || document.body.scrollHeight;
		},	
		getScrollWidth: function(){
			return document.documentElement.scrollWidth || document.body.scrollWidth;
		},
		getScrollTop: function(){
			return document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop || 0;
		},
		getScrollLeft: function(){
			return document.documentElement.scrollLeft || window.pageXOffset || document.body.scrollLeft || 0;
		},
		getPosition : function(el){
			var left = 0, top = 0;
			do {
				left += el.offsetLeft || 0;
				top += el.offsetTop || 0;
				el = el.offsetParent;
			} while (el);
			return {'x': left, 'y': top};
		},
		getCoordinates : function(el){
			var pos = $.getPosition(el);
			var obj = {
				'width': el.offsetWidth,
				'height': el.offsetHeight,
				'left': pos.x,
				'top': pos.y
			};
			obj.right = obj.left + obj.width;
			obj.bottom = obj.top + obj.height;
			return obj;
		}
	});
	$.jceUtilities = function(options){
		return $.jceUtilities.init(options);
	};
	$.jceUtilities.init = function(options){
		this.options = $.extend({
			lightbox : {
				legacy				: 0,
				convert				: 0,
				overlayopacity 		: 0.8,
				overlaycolor		: '#000000',
				resize				: 1,	
				icons				: 1,
				fadespeed			: 500,
				scalespeed			: 500
			},
			tooltip : {
				classname		: 'tooltip',
				opacity			: 1,
				speed			: 150,
				position		: 'br',
				offsets			: {'x': 16, 'y': 16}
			},
			pngfix				: 0,
			imgpath				: 'plugins/system/jceutilities/img/'						
		}, options);
		if(this.options.lightbox.convert > 0){
			$('a').each(function(){
				$.jceUtilities.convertType(this);
			});
		}else{
			$.jceUtilities.tooltip.init(this.options.tooltip);
			$.jceUtilities.lightbox.init(this.options.lightbox);
		}
		if(this.options.pngfix == 1 && $.browser.ie6){
			this.pngFix();	
		}
	};
	$.jceUtilities.cleanupEventStr = function(s) {
		s = "" + s;
		s = s.replace('function anonymous()\n{\n', '');
		s = s.replace('\n}', '');
		s = s.replace(/^return true;/gi, ''); // Remove event blocker
		return s;
	};
	$.jceUtilities.parseQuery = function(query){
		var params = {}, kv, k, v;
		if(!query){
			return params;
		}
		var pairs = query.split(/[;&]/);
		for(var i=0; i<pairs.length; i++){
			kv = pairs[i].split('=');
			if(!kv || kv.length != 2){
				continue;
			}
			k = unescape(kv[0]);
			v = unescape(kv[1]);
			v = v.replace(/\+/g, ' ');
			params[k] = v;
		}
		return params;
	};
	$.jceUtilities.convertType = function(link){
		if($.jceUtilities.options.lightbox.convert > 0){
			if(link.href.toLowerCase().match(/\.jpg|\.jpeg|\.png|\.gif|\.bmp/g)){
				var linkclass = '';
				var rel = link.rel;
				switch($.jceUtilities.options.lightbox.convert){
					case 1:
						if(!rel){
							rel = 'lightbox';
						}else{
							rel = 'lightbox[' + rel + ']'
						}
						break;
					case 2:
						linkclass = 'thickbox';
						if(!rel){
							rel = '';
						}
						break;
					case 3:
						if(!rel){
							rel = 'rokzoom';
						}else{
							rel = 'rokzoom[' + rel + ']'
						}
						link.setAttribute('rel', rel);
						break;
				}
				link.setAttribute('rel', rel);
				link.className = link.className.replace(/jcelightbox/gi, linkclass);
				
				if(link.className == '') link.removeAttribute('class');
				if(link.rel == '') link.removeAttribute('rel');
			}
		}
		return link;
	};
	$.jceUtilities.pngFix = function(){
		var images = $('img[@src*="png"]', document);
		images.each( function() {
			var p = this.src;
			this.css('filter', 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + p + '\', sizingMethod=\'\')');			
			this.src = 'plugins/system/jceutilities/img/blank.gif';
		});
	};
	$.jceUtilities.tooltip = {
		init: function(options){				
			var self = this;
			this.options = $.extend({}, options);
			$('.jcetooltip, .jce_tooltip').each(function(){
				$(this).bind('mouseover', function(){
					self.show(this);
				});
				$(this).bind('mousemove', function(e){
					self.locate(e);
				});
				$(this).bind('mouseout', function(){
					self.hide(this);
				}).bind('blur', function(){
					self.hide(this);
				});
			
				this.myText = this.title || false;
				this.myTitle = '';
				$(this).removeAttr('title');
				if(this.myText && /::/g.test(this.myText)){
					var dual = this.myText.split('::');
					this.myTitle 	= $.trim(dual[0]);
					this.myText 	= $.trim(dual[1]);
				}	
			});
		},
		show : function(el){
			var d = document;
			this.tip 	= d.createElement('div');
			this.title 	= d.createElement('h4');
			this.text 	= d.createElement('p');	
							
			$(this.tip).addClass(this.options.classname).css('position', 'absolute').appendTo('body').hide();
			$(this.title).appendTo($(this.tip));
			$(this.text).appendTo($(this.tip));
			
			$(this.title).html(el.myTitle);
			$(this.text).html(el.myText);
			
			$(this.tip).animate({'opacity': this.options.opacity}, this.options.speed).show();
			
			this.exists = true;
		},
		locate : function(e){
			if(this.exists){
				var o 		= this.options.offsets;
				
				var page 	= {'x': e.clientX + $.getScrollLeft(), 'y': e.clientY + $.getScrollTop()};
				var tip 	= {'x': this.tip.offsetWidth, 'y': this.tip.offsetHeight};
				var pos 	= {'x': e.clientX + o.x, 'y': e.clientY + o.y};
										
				switch(this.options.position){
					case 'tl':
						pos.x = (page.x - tip.x) - o.x;
						pos.y = (page.y - tip.y) - o.y;
						break;
					case 'tr':
						pos.x = page.x + o.x;
						pos.y = (page.y - tip.y) - o.y;
						break;
					case 'tc':
						pos.x = (page.x - Math.round((tip.x / 2))) + o.x;
						pos.y = (page.y - tip.y) - o.y;
						break;
					case 'bl':
						pos.x = (page.x - tip.x) - o.x;
						pos.y = (page.y + tip.y) - o.y;
						break;
					case 'br':
						pos.x = page.x + o.x;
						pos.y = page.y + o.y;
						break;
					case 'bc':
						pos.x = (page.x - Math.round((tip.x / 2))) + o.x;
						pos.y = (page.y + tip.y) - o.y;
						break;
				}
				$(this.tip).css({
					top: pos.y + 'px', 
					left: pos.x + 'px'
				});
			}
		},
		hide : function(el){
			if(this.exists){
				$(this.tip).fadeOut(this.options.speed).remove();
			}
		}
	};
	$.jceUtilities.lightbox = {
		anchors : [],
		init : function(options){
			var self = this;					
			this.options = $.extend({}, options);
			if(this.options.legacy == 1){
				var op = 'index2.php?option=com_jce&task=popup';
				var mp = 'mosce/jscripts/tiny_mce/popupImage.php';
				$('a[onclick.contains('+ op +')][onclick.contains('+ mp +')][href.contains('+ op +')]').each(function(){						
					$.jceUtilities.convertType(this);  
				});
			}
			$("a.jcebox, a.jcelightbox").each(function(){
				if(self.options.icons == 1){
					self.setZoom(this);
				}
				self.anchors.push(this);
				$(this).click(function(){
					return self.start(this);
				});
			});
		},
		setPNG : function(el){
			var s = el.src;
			$(el).attr('src', 'plugins/system/jceutilities/img/blank.gif').css('filter', 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + s + '\', sizingMethod=\'\')');
		},
		setZoom : function(el){
			var h, w, mt, ml, mr, iw, ih, self = this;
			$(el).each(function(){
				if(this.firstChild.nodeName.toLowerCase() == 'img'){
					var child 	= this.firstChild;
					var zoom 	= document.createElement('img');
					$(window).bind('load', function(){
						w 	= parseInt($(child).width()) || parseInt($(child).css('width'));
						h 	= parseInt($(child).height()) || parseInt($(child).css('height'));
						mt 	= parseInt($(child).css('marginTop')) || 0;
						ml 	= parseInt($(child).css('marginLeft')) || 0;
						mr 	= parseInt($(child).css('marginRight')) || 0;
						$(zoom).attr({
							'src': $.jceUtilities.options.imgpath + 'zoom-img.png'
						}).addClass('zoomImg').insertAfter($(child));
						
						iw = parseInt($(zoom).css('width')) || 20;
						ih = parseInt($(zoom).css('height')) || 20;
						
						$(zoom).css({
							'top': h - (ih - mt),
							'cursor': 'pointer',
							'float': $(child).css('float')
						});
						switch($(child).css('float')){
							default:
								$(zoom).css({
									'top': -mt,
									'right': mr + iw,
									'margin-right': -(mr - iw)
								});
							case 'left':
								$(zoom).css({
									'right': mr + iw,
									'margin-right': -(mr + iw)
								});
								break;
							case 'right':
								var l = $.browser.msie ? (w * 2) - (ml + mr) : w + ml; 
								$(zoom).css({
									'left': l,
									'margin-left': -(w + ml)
								});
								break;
						}
						if($.browser.msie && $.browser.version < 7 && $.jceUtilities.options.pngfix == 1){
							self.setPNG(zoom);
						}
					});
				}else{
					zoom = document.createElement('img');
					$(zoom).attr({
						src: $.jceUtilities.options.imgpath + 'zoom-link.png'
					}).addClass('zoomLink').appendTo(el);
					if($.browser.msie && $.browser.version < 7 && $.jceUtilities.options.pngfix == 1){
						self.setPNG(zoom);
					}
				}
			});
		},
		trigger : function(s, t){
			var link = {};
			if(typeof s == 'object'){
				link = {
					'href' 	: s.href || s.src,
					'title' : s.title || ''
				}
			}else{
				link = {
					'href' 	: s,
					'title' : t || ''
				}	
			}
			return this.start(link);
		},
		start: function(link){			
			var d = document, self = this;
			
			if(this.options.overlay == 1){
				this.overlay = d.createElement('div');			
				$(this.overlay).attr('id', 'jcelightbox-overlay').appendTo('body').css({opacity: '0', cursor: 'pointer', backgroundColor: this.options.overlaycolor, width: $.getWidth()}).click(function(){
					self.close();
				});
			}
			
			this.center = d.createElement('div');
			$(this.center).attr('id', 'jcelightbox-center').css({width: 300, height: 300, marginLeft: -150}).appendTo('body').hide();
			
			this.loader = d.createElement('div');
			$(this.loader).attr('id', 'jcelightbox-loading').appendTo(this.center).hide();
			
			this.image = d.createElement('div');
			$(this.image).attr('id', 'jcelightbox-image').appendTo(this.center);

			this.bottom = d.createElement('div');
			$(this.bottom).attr('id', 'jcelightbox-bottom').appendTo(this.center).hide();
						
			this.closeLink = d.createElement('a');
			$(this.closeLink).attr({'id': 'jcelightbox-close', 'href': 'javascript:void(0);'}).appendTo(this.bottom).click(function(){
				self.close();
			});
			
			this.caption = d.createElement('div');
			$(this.caption).attr('id', 'jcelightbox-caption').appendTo(this.bottom);
			
			this.number = d.createElement('div');
			$(this.number).attr('id', 'jcelightbox-number').appendTo(this.bottom);
			
			//$('<div style="clear:both;"></div>').appendTo(this.bottom);	
		
			if(link.href.toLowerCase().match(/\.jpg|\.jpeg|\.png|\.gif|\.bmp/g)){
				this.type = 'image';
				this.preloadPrev = new Image();
				this.preloadNext = new Image();
						
				this.realImage = d.createElement('img');
				$(this.realImage).attr('id', 'jcelightbox-realimage').appendTo(this.image);
				
				this.nav = d.createElement('div');
				$(this.nav).attr('id', 'jcelightbox-nav').appendTo(this.image);
				
				this.prevLink = d.createElement('a');
				$(this.prevLink).attr({'id': 'jcelightbox-navPrev', 'href': 'javascript:void(0);'}).appendTo(this.nav);
			
				this.nextLink = d.createElement('a');
				$(this.nextLink).attr({'id': 'jcelightbox-navNext', 'href': 'javascript:void(0);'}).appendTo(this.nav);
				
				$(this.prevLink).click(function(){
					self.previous();
				});
				$(this.nextLink).click(function(){
					self.next();
				});						
				var imageNum = 0, images = [];
				if(!link.rel){
					images.push([link.href, link.title || '']);
				}else{
					$.each(this.anchors, function(){
						if(this.rel == link.rel){
							for(var i=0; i<images.length; i++) 
								if(images[i][0] == this.href) 
									break;
							if(i == images.length){
								images.push([this.href, this.title]);
								if(this.href == link.href){
									imageNum = i;
								}
							}
						}
					});
				}
				return this.open(images, imageNum);
			}else{
				this.type 	= 'iframe';
				var query 	= link.href.replace(/^[^\?]+\??/,'');
				var params 	= $.jceUtilities.parseQuery(query);			
				var url 	= link.href.replace('&width=' + params['width'] + '&height=' + params['height'], '', 'g');
				var width 	= parseInt(params['width']) || 300;
				var height 	= parseInt(params['height']) || 300;
				return this.open([[url, link.title || '', width, height]], 0);
			}
		},	
		open: function(images, imageNum){
			this.images = images;
			this.position();
			this.setup(true);
			this.top = $.getScrollTop() + ($.getHeight() / 15);
			$(this.center).css({top: this.top, display: ''});
			if(this.options.overlay == 1){
				$(this.overlay).fadeTo(this.options.fadespeed, this.options.overlayopacity);
			}
			return this.changeImage(imageNum);
		},	
		position: function(){
			if(this.options.overlay == 1){
				$(this.overlay).css({'top': $.getScrollTop(), 'height': $.getHeight()});
			}
		},	
		setup: function(open){
			var self = this;
			if($.browser.msie && $.browser.version < 7){
				$('object', 'select', 'embed').each(function(){
					if(open) this.lbBackupStyle = this.style.visibility;
					this.style.visibility = open ? 'hidden' : el.lbBackupStyle;
				});
			}
			if(open){
				$(window).bind('scroll', function(){
					self.position();
				});
				$(window).bind('resize', function(){
					self.position();
				});
				$(document).bind('keydown', function(event){
					self.keyboardListener(event);
				})
			}else{
				$(window).unbind('scroll');
				$(window).unbind('resize');
				$(document).unbind('keydown');
			}
			this.step = 0;
		},	
		keyboardListener: function(event){
			switch (event.keyCode){
				case 27: case 88: case 67: this.close(); break;
				case 37: case 80: this.previous(); break;	
				case 39: case 78: this.next();
			}
		},
		nextImage: function(n){
			if($.browser.opera || ($.browser.msie && $.browser.version < 7)){
				$(this.bottom).hide();
				$(this.image).hide();
				return this.changeImage(n);
			}else{
				var self = this;
				$(this.bottom).fadeOut(this.options.fadespeed, function(){
					$(self.image).fadeTo(self.options.fadespeed, 0, function(){
						return self.changeImage(n);
					});
				});
			}
		},
		previous: function(){
			return this.nextImage(this.activeImage-1);
		},	
		next: function(){
			return this.nextImage(this.activeImage+1);
		},	
		changeImage: function(imageNum){
			var self = this;
			if(this.step || (imageNum < 0) || (imageNum >= this.images.length)) return false;
			this.step = 1;
			this.activeImage = imageNum;
			
			$(this.image).css({visibility: 'hidden', opacity: 0}).show();
			$(this.loader).show();
	
			if(this.type == 'image'){
				this.preload = new Image();
				this.preload.onload = function(){
					return self.nextEffect()
				};
				this.preload.src = this.images[imageNum][0];
				this.prevLink.style.display = this.nextLink.style.display = 'none';
			}
			if(this.type == 'iframe'){
				this.iframe = document.createElement('iframe');
				$(this.iframe).attr({
					frameBorder: 0, 
					title: this.images[imageNum][1],
					onload: function(){
						return self.nextEffect();
					}
				}).css({
					width: this.images[imageNum][2], 
					height: this.images[imageNum][3]
				}).appendTo(this.image).attr('src', this.images[imageNum][0]);
			}
			return false;
		},
		nextEffect: function(){
			var self = this;
			switch (this.step++){
			case 1:	
				$(this.loader).hide();
				var title = this.images[this.activeImage][1] || '';
				if(title.indexOf('http://') != -1) title = '<a href="' + title + '" target="_blank">' + title + '</a>'; 
				
				if(this.type == 'image'){
					var w = this.preload.width;
					var h = this.preload.height;
					if(this.options.resize == 1){	
						var x =  Math.round($.getWidth() - 150);
						var y =  Math.round($.getHeight() - 150);
						if(w > x){
							h = h * (x / w); 
							w = x; 
							if(h > y){ 
								w = w * (y / h); 
								h = y; 
							}
						}else if (h > y){ 
							w = w * (y / h); 
							h = y; 
							if(w > x){ 
								h = h * (x / w); 
								w = x;
							}
						}
					}
					w = Math.round(w);
					h = Math.round(h);
					
					$(this.image).width(w).height(h);					
					$(this.realImage).attr({'src': this.images[this.activeImage][0], 'width': w, 'height': h});
					$(this.nav).width(w+20).height(h);
		
					$(this.caption).html(title);
					var html = '';
					if(this.images.length > 1){
						for(var i=0; i<this.images.length; i++){
							var n = i + 1;
							if(n == 1 && this.activeImage != n - 1){
								html += '<a href="javascript:void(0);" class="jcelightbox-numberPrev">&lt;&nbsp;</a>';
							}
							var seperator = (n == this.images.length) ? '' : ' | ';
							if(this.activeImage != i){ 
								html += '<a href="javascript:void(0);" class="jcelightbox-numberLink">';
							}
							html += n;
							if(this.activeImage != i){
								html += '</a>';
							}
							html += seperator;
							if(n == this.images.length && this.activeImage != n - 1){
								html += '<a href="javascript:void(0);" class="jcelightbox-numberNext">&nbsp;&gt;</a>';
							}
						}
					}
					$(this.number).html(html);
					$('a.jcelightbox-numberLink').each(function(){
						$(this).click(function(){
							var n = parseInt($(this).text());
							return self.nextImage(n - 1);
						});								   
					});
					$('a.jcelightbox-numberNext').each(function(){
						$(this).click(function(){
							return self.next();
						});								   
					});
					$('a.jcelightbox-numberPrev').each(function(){
						$(this).click(function(){
							return self.previous();
						});								   
					});
					
					if(this.activeImage){
						this.preloadPrev.src = this.images[this.activeImage-1][0];
					}
					if(this.activeImage != (this.images.length - 1)){
						this.preloadNext.src = this.images[this.activeImage+1][0];
					}
				}
				if(this.type == 'iframe'){
					$(this.image).width(this.images[this.activeImage][2]).height(this.images[this.activeImage][3]);
					$(this.caption).html(title);
				}
				if (this.center.clientHeight != this.image.offsetHeight){
					$(this.center).animate({
						height: this.image.offsetHeight
					}, this.options.scalespeed, function(){
						return self.nextEffect();
					});
					break;
				}
				this.step++;
			case 2:
				if(this.center.clientWidth != this.image.offsetWidth){					
					$(this.center).animate({
						width: this.image.offsetWidth, 
						marginLeft: -this.image.offsetWidth/2
					}, this.options.scalespeed, function(){
						return self.nextEffect();
					});
					break;
				}
				this.step++;
			case 3:
				$(this.image).css('visibility', 'visible').fadeTo(this.options.fadespeed, 1, function(){
					return self.nextEffect();
				});
				break;
			case 4:
				$(this.center).animate({height: $(this.center).height() + 50}, this.options.scalespeed, function(){
					return self.nextEffect();
				});
				break;
			case 5:
				if($.browser.opera || ($.browser.msie && $.browser.version < 7)){
					$(this.bottom).show();
				}else{					
					$(this.bottom).fadeIn(this.options.fadespeed);
				}
				if(this.type == 'image'){
					if(this.activeImage){
						$(this.prevLink).show();
					}
					if(this.activeImage != (this.images.length - 1)){
						$(this.nextLink).show();
					}
				}
				this.step = 0;
			}
		},	
		close: function(){
			var self = this;
			if (this.step < 0) return;
			this.step = -1;
			if (this.preload){
				this.preload.onload = null;
				this.preload = null;
			}
			$(this.bottom).hide();
			$(this.center).fadeOut(this.options.fadespeed, function(){
				if(self.options.overlay == 1){
					$(self.overlay).fadeOut(self.options.fadespeed, function(){
						$(self.center).remove();
						$(self.overlay).remove();													  
					});
				}else{
					$(self.center).remove();	
				}
			});
			return false;
		}
	};
})(jQuery);
var jceutilities 	= jQuery.jceUtilities;
var jcelightbox 	= jceutilities.lightbox;