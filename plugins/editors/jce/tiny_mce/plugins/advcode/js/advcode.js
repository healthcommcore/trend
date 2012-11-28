tinyMCEPopup.requireLangPack();
var wHeight=0, wWidth=0, owHeight=0, owWidth=0;
var SourceEditor = {
	saveContent : function() {
		if(this.textarea.disabled){
			tinyMCEPopup.editor.setContent(this.getCode());	
		}else{
			tinyMCEPopup.editor.setContent(this.textarea.value);
		}
		tinyMCEPopup.close();
	},
	init : function() {
		var d = document;
		tinyMCEPopup.resizeToInnerSize();
	
		this.textarea 	= d.getElementById('htmlSource');
		
		this.language	= 'html';
		this.isGecko 	= tinymce.isGecko;
		this.isIE 		= tinymce.isIE;
		this.isOpera 	= tinymce.isOpera;
		
		this.isBrowser 	= this.isGecko || this.isIE || this.isOpera; 
				
		// Remove Gecko spellchecking
		if (this.isGecko){
			d.body.spellcheck = tinyMCEPopup.editor.getParam("gecko_spellcheck");
		}
	
		this.textarea.value = tinyMCEPopup.editor.getContent();
	
		if(!tinyMCEPopup.getParam('theme_advanced_source_editor_highlight') || !this.isBrowser){
			d.getElementById('editorLanguageLine').style.display = 'none';
			d.getElementById('highlightLine').style.display = 'none';
			if(tinyMCEPopup.getParam("theme_advanced_source_editor_wrap", true)) {
				this.setWrap(true);
				d.getElementById('wraped').checked = true;
			}
			//this.resizeInputs();
		}else{					
			if(/<\?(\s+|php\s+)([\w\W]*?)\?>/gi.test(this.textarea.value)){
				this.language = 'php';
			}else if(/<script type="text\/javascript">([\w\W]*?)<\/script>/gi.test(this.textarea.value)){
				this.language = 'javascript';
			}else if(/<style[^>]*>([\w\W]*?)<\/style>/gi.test(this.textarea.value)){
				this.language = 'css';	
			}
			if(tinyMCEPopup.getParam('theme_advanced_source_editor_php')){
				this.addEditorLanguage('PHP', 'php');
			}
			if(tinyMCEPopup.getParam('theme_advanced_source_editor_script')){
				this.addEditorLanguage('Javascript', 'javascript');
			}
			this.selectEditorLanguage(this.language);
			this.buildEditor();
		}
		this.resizeInputs();
	},
	buildEditor : function(){
		var dom = tinyMCEPopup.dom;
		this.iframe = dom.create('iframe', { 
			'class' : 'editor',
			wrap : 'soft',
			frameborder: 0,
			src : 'javascript;'
		});
		dom.setStyles(this.iframe, {
			'width': '100%', 
			'height': '85%',
			'border': '1px solid gray',
			'visibility': 'hidden',
			'position': 'absolute'
		});
		dom.setStyles(this.textarea, {'overflow': 'hidden', 'overflow' : 'auto'});
		this.textarea.disabled = true;
		this.textarea.parentNode.insertBefore(this.iframe, this.textarea);
		
		this.setEditor(this.language);
	},
	initEditor : function(){
		var dom = tinyMCEPopup.dom, iframe = this.iframe.contentWindow;
		this.editor 				= iframe.CodePress;
		this.editor.body 			= iframe.document.getElementsByTagName('body')[0];
		this.editor.pre 			= iframe.document.getElementsByTagName('pre')[0];
		
		this.editor.setCode(this.textarea.value);

		this.editor.syntaxHighlight('init');
		dom.hide(this.textarea);

		dom.setStyles(this.iframe, {
			'position': 'static',
			'visibility': 'visible',
			'display': 'block'
		});
		
		if(tinyMCEPopup.editor.getParam("theme_advanced_source_editor_wrap", true)) {
			document.getElementById('wraped').checked = true;
			this.setWrap(true);
		}
		if(tinyMCEPopup.editor.getParam("theme_advanced_source_editor_numbers", true)) {
			this.toggleLineNumbers();
		}
	},
	setEditor : function(lang){
		if(!this.textarea.disabled){
			return;
		}	
		this.iframe.src = tinyMCEPopup.getWindowArg('plugin_url') + '/editor.html?language='+lang+'&ts='+(new Date).getTime();
		tinymce.dom.Event.add(this.iframe, 'load', function(e) {
   			SourceEditor.initEditor();
		});
	},
	setEditorLanguage : function(v){
		this.textarea.value = this.editor.getCode();
		this.editor.setCode(this.textarea.value);
		
		this.setEditor(v);
	},
	selectEditorLanguage : function(v){
		var s = document.getElementById('editorLanguage');
		for (var i=0; i<s.options.length; i++) {
			var o = s.options[i];
	
			if (o.value == v) {
				o.selected = true;
			} else{
				o.selected = false;
			}
		}
	},
	addEditorLanguage : function(n, v){
		var s = document.getElementById('editorLanguage');
		var o = new Option(n, v);
		s.options[s.options.length] = o;
	},
	toggleClass : function(e, c){
		var dom = tinyMCEPopup.dom;
		if(dom.hasClass(e, c)){
			dom.removeClass(e, c);	
		}else{
			dom.addClass(e, c);	
		}
	},
	toggleEditor : function(){
		if(document.getElementById('highlight').checked){
			this.textarea.disabled = true;
			this.setCode(this.textarea.value);
			this.editor.syntaxHighlight('init');
			this.iframe.style.display = 'block';
			this.textarea.style.display = 'none';
			
			var lang = document.getElementById('editorLanguage').value;			
			if(this.language != lang){
				this.setEditorLanguage(lang);
			}			
		}else{
			this.textarea.value = this.getCode();
			this.textarea.disabled = false;
			this.iframe.style.display = 'none';
			this.textarea.style.display = 'block';
			this.setWrap(document.getElementById('wraped').checked);
			this.resizeInputs();
		}
	},
	toggleLineNumbers : function(){
		if(document.getElementById('numbers').checked){
			tinyMCEPopup.dom.addClass(this.editor.body, 'show-line-numbers');
		}else{
			tinyMCEPopup.dom.removeClass(this.editor.body, 'show-line-numbers');	
		}
	},
	toggleAutoComplete : function(){
		this.editor.autocomplete = document.getElementById('autocomplete').checked;
	},
	getCode : function(){
		return this.textarea.disabled ? this.editor.getCode() : this.textarea.value;
	},
	setCode : function(code){
		this.textarea.disabled ? this.editor.setCode(code) : this.textarea.value = code;
	},
	onResize : function(){
		if(!document.getElementById('htmlSource').disabled){
			this.resizeInputs();	
		}
	},
	setWrap : function(check) {
		var v, n, p, s = this.textarea;
		if(this.textarea.disabled){
			if(this.isOpera){
				o = this.editor.body;
			}else{
				o = this.editor.pre;	
			}
			if(check){
				tinyMCEPopup.dom.addClass(o, 'soft');
			}else{
				tinyMCEPopup.dom.removeClass(o, 'soft');
			}
		}else{
			s.wrap = check ? 'soft' : 'off';
			if (!this.isIE) {
				v = s.value;
				n = s.cloneNode(false);
				n.setAttribute("wrap", check ? 'soft' : 'off');
				s.parentNode.replaceChild(n, s);
				n.value = v;
			}
		}
	},
	toggleWordWrap : function() {
		this.setWrap(document.getElementById('wraped').checked);
	},
	resizeInputs : function() {
		var el = document.getElementById('htmlSource');
		
		if(el.disabled){
			el = this.iframe;	
		}
	
		if (!tinymce.isIE) {
			 wHeight = self.innerHeight - 100;
			 wWidth = self.innerWidth - 26;
		} else {
			 wHeight = document.body.clientHeight - 90;
			 wWidth = document.body.clientWidth - 30;
		}	
		el.style.height = Math.abs(wHeight) + 'px';
		el.style.width  = Math.abs(wWidth) + 'px';
	}
}
tinyMCEPopup.onInit.add(SourceEditor.init, SourceEditor);
