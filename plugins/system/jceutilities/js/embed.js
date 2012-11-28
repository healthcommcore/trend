function writeFlash(p) {
	if(typeof p.wmode == 'undefined'){
		p['wmode'] = 'transparent';
	}
	writeEmbed(
		'd27cdb6e-ae6d-11cf-96b8-444553540000',
		'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0',
		'application/x-shockwave-flash',
		p
	);
}
function writeShockWave(p) {
	writeEmbed(
	'166b1bca-3f9c-11cf-8075-444553540000',
	'http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0',
	'application/x-director',
		p
	);
}
function writeQuickTime(p) {
	writeEmbed(
		'02bf25d5-8c17-4b23-bc80-d3488abddc6b',
		'http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0',
		'video/quicktime',
		p
	);
}
function writeRealMedia(p) {
	writeEmbed(
		'cfcdaa03-8be4-11cf-b84b-0020afbbccfa',
		'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0',
		'audio/x-pn-realaudio-plugin',
		p
	);
}
function writeWindowsMedia(p) {
	p.url = p.src;
	writeEmbed(
		'6bf52a52-394a-11d3-b153-00c04f79faa6',
		'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701',
		'video/x-ms-wmv',
		p
	);
}
function writeDivX(p) {
	writeEmbed(
		'67dabfbf-d0ab-41fa-9c46-cc0f21721616',
		'http://go.divx.com/plugin/DivXBrowserPlugin.cab',
		'video/divx',
		p
	);
}
function writeEmbed(cls, cb, mt, p) {
	var h = '', n;
		
	var msie 	= /msie/i.test(navigator.userAgent);
	var webkit 	= /WebKit/i.test(navigator.userAgent);
	
	if(jcexhtmlembed === 1){
		h += '<object codebase="' + cb + '"';
		if(msie || webkit){
			h += 'classid="clsid:' + cls + '"';
			for (n in p){
				if (/(id|name|width|height|style)$/.test(n)){
					h += n + '="' + p[n] + '"';	
				}
			}
		}
		h += '>';
		if(msie || webkit){
			for (n in p){
				h += '<param name="' + n + '" value="' + p[n] + '">';
			}
		}
		if(!msie || !webkit){
			h += '<object type="'+ mt +'" data="'+ p.src +'"';
			for (n in p){
				h += n + '="' + p[n] + '"';
			}
			h += '></object>';
		}
	}else{
		h += '<object codebase="' + cb + '" classid="clsid:' + cls + '"';
		for (n in p){
			if (/(id|name|width|height|style)$/.test(n)){
				h += n + '="' + p[n] + '"';	
			}
		}
		h += '>';
		for (n in p){
			if (!/^(id|name|width|height|style)$/.test(n)){
				h += '<param name="' + n + '" value="' + p[n] + '">';
			}
		}
		h += '<embed type='+ mt +' ';
		for (n in p){
			if (n != 'style'){
				h += n + '="' + p[n] + '"';
			}
		}
		h += '></embed>';
	}
	h += '</object>';
	document.write(h);
}
