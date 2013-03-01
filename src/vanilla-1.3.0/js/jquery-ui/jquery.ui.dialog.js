(function(b){var a="ui-dialog ui-widget ui-widget-content ui-corner-all ";b.widget("ui.dialog",{options:{autoOpen:true,buttons:{},closeOnEscape:true,closeText:"close",dialogClass:"",draggable:true,hide:null,height:"auto",maxHeight:false,maxWidth:false,minHeight:150,minWidth:150,modal:false,position:"center",resizable:true,show:null,stack:true,title:"",width:300,zIndex:1000},_create:function(){this.originalTitle=this.element.attr("title");var k=this,l=k.options,i=l.title||k.originalTitle||"&#160;",d=b.ui.dialog.getTitleId(k.element),j=(k.uiDialog=b("<div></div>")).appendTo(document.body).hide().addClass(a+l.dialogClass).css({zIndex:l.zIndex}).attr("tabIndex",-1).css("outline",0).keydown(function(m){if(l.closeOnEscape&&m.keyCode&&m.keyCode==b.ui.keyCode.ESCAPE){k.close(m);m.preventDefault()}}).attr({role:"dialog","aria-labelledby":d}).mousedown(function(m){k.moveToTop(false,m)}),f=k.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(j),e=(k.uiDialogTitlebar=b("<div></div>")).addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(j),h=b('<a href="#"></a>').addClass("ui-dialog-titlebar-close ui-corner-all").attr("role","button").hover(function(){h.addClass("ui-state-hover")},function(){h.removeClass("ui-state-hover")}).focus(function(){h.addClass("ui-state-focus")}).blur(function(){h.removeClass("ui-state-focus")}).click(function(m){k.close(m);return false}).appendTo(e),g=(k.uiDialogTitlebarCloseText=b("<span></span>")).addClass("ui-icon ui-icon-closethick").text(l.closeText).appendTo(h),c=b("<span></span>").addClass("ui-dialog-title").attr("id",d).html(i).prependTo(e);if(b.isFunction(l.beforeclose)&&!b.isFunction(l.beforeClose)){l.beforeClose=l.beforeclose}e.find("*").add(e).disableSelection();(l.draggable&&b.fn.draggable&&k._makeDraggable());(l.resizable&&b.fn.resizable&&k._makeResizable());k._createButtons(l.buttons);k._isOpen=false;(b.fn.bgiframe&&j.bgiframe())},_init:function(){if(this.options.autoOpen){this.open()}},destroy:function(){var c=this;(c.overlay&&c.overlay.destroy());c.uiDialog.hide();c.element.unbind(".dialog").removeData("dialog").removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body");c.uiDialog.remove();(c.originalTitle&&c.element.attr("title",c.originalTitle));return c},widget:function(){return this.uiDialog},close:function(e){var c=this;if(false===c._trigger("beforeClose",e)){return}(c.overlay&&c.overlay.destroy());c.uiDialog.unbind("keypress.ui-dialog");c._isOpen=false;(c.options.hide?c.uiDialog.hide(c.options.hide,function(){c._trigger("close",e)}):c.uiDialog.hide()&&c._trigger("close",e));b.ui.dialog.overlay.resize();if(c.options.modal){var d=0;b(".ui-dialog").each(function(){if(this!=c.uiDialog[0]){d=Math.max(d,b(this).css("z-index"))}});b.ui.dialog.maxZ=d}return c},isOpen:function(){return this._isOpen},moveToTop:function(g,f){var c=this,e=c.options;if((e.modal&&!g)||(!e.stack&&!e.modal)){return c._trigger("focus",f)}if(e.zIndex>b.ui.dialog.maxZ){b.ui.dialog.maxZ=e.zIndex}(c.overlay&&c.overlay.$el.css("z-index",b.ui.dialog.overlay.maxZ=++b.ui.dialog.maxZ));var d={scrollTop:c.element.attr("scrollTop"),scrollLeft:c.element.attr("scrollLeft")};c.uiDialog.css("z-index",++b.ui.dialog.maxZ);c.element.attr(d);c._trigger("focus",f);return c},open:function(){if(this._isOpen){return}var d=this,e=d.options,c=d.uiDialog;d.overlay=e.modal?new b.ui.dialog.overlay(d):null;(c.next().length&&c.appendTo("body"));d._size();d._position(e.position);c.show(e.show);d.moveToTop(true);(e.modal&&c.bind("keypress.ui-dialog",function(h){if(h.keyCode!=b.ui.keyCode.TAB){return}var g=b(":tabbable",this),i=g.filter(":first"),f=g.filter(":last");if(h.target==f[0]&&!h.shiftKey){i.focus(1);return false}else{if(h.target==i[0]&&h.shiftKey){f.focus(1);return false}}}));b([]).add(c.find(".ui-dialog-content :tabbable:first")).add(c.find(".ui-dialog-buttonpane :tabbable:first")).add(c).filter(":first").focus();d._trigger("open");d._isOpen=true;return d},_createButtons:function(f){var e=this,c=false,d=b("<div></div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix");e.uiDialog.find(".ui-dialog-buttonpane").remove();(typeof f=="object"&&f!==null&&b.each(f,function(){return !(c=true)}));if(c){b.each(f,function(g,i){var h=b('<button type="button"></button>').text(g).click(function(){i.apply(e.element[0],arguments)}).appendTo(d);(b.fn.button&&h.button())});d.appendTo(e.uiDialog)}},_makeDraggable:function(){var c=this,e=c.options,f=b(document),d;c.uiDialog.draggable({cancel:".ui-dialog-content, .ui-dialog-titlebar-close",handle:".ui-dialog-titlebar",containment:"document",start:function(g){d=e.height==="auto"?"auto":b(this).height();b(this).height(b(this).height()).addClass("ui-dialog-dragging");c._trigger("dragStart",g)},drag:function(g){c._trigger("drag",g)},stop:function(g,h){e.position=[h.position.left-f.scrollLeft(),h.position.top-f.scrollTop()];b(this).removeClass("ui-dialog-dragging").height(d);c._trigger("dragStop",g);b.ui.dialog.overlay.resize()}})},_makeResizable:function(g){g=(g===undefined?this.options.resizable:g);var d=this,f=d.options,c=d.uiDialog.css("position"),e=typeof g=="string"?g:"n,e,s,w,se,sw,ne,nw";d.uiDialog.resizable({cancel:".ui-dialog-content",containment:"document",alsoResize:d.element,maxWidth:f.maxWidth,maxHeight:f.maxHeight,minWidth:f.minWidth,minHeight:d._minHeight(),handles:e,start:function(h){b(this).addClass("ui-dialog-resizing");d._trigger("resizeStart",h)},resize:function(h){d._trigger("resize",h)},stop:function(h){b(this).removeClass("ui-dialog-resizing");f.height=b(this).height();f.width=b(this).width();d._trigger("resizeStop",h);b.ui.dialog.overlay.resize()}}).css("position",c).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")},_minHeight:function(){var c=this.options;return(c.height=="auto"?c.minHeight:Math.min(c.minHeight,c.height))},_position:function(d){var e=[],f=[0,0];d=d||b.ui.dialog.prototype.options.position;if(typeof d=="string"||(typeof d=="object"&&"0" in d)){e=d.split?d.split(" "):[d[0],d[1]];if(e.length==1){e[1]=e[0]}b.each(["left","top"],function(h,g){if(+e[h]==e[h]){f[h]=e[h];e[h]=g}})}else{if(typeof d=="object"){if("left" in d){e[0]="left";f[0]=d.left}else{if("right" in d){e[0]="right";f[0]=-d.right}}if("top" in d){e[1]="top";f[1]=d.top}else{if("bottom" in d){e[1]="bottom";f[1]=-d.bottom}}}}var c=this.uiDialog.is(":visible");if(!c){this.uiDialog.show()}this.uiDialog.css({top:0,left:0}).position({my:e.join(" "),at:e.join(" "),offset:f.join(" "),of:window,collision:"fit",using:function(h){var g=b(this).css(h).offset().top;if(g<0){b(this).css("top",h.top-g)}}});if(!c){this.uiDialog.hide()}},_setOption:function(f,g){var d=this,c=d.uiDialog,h=c.is(":data(resizable)"),e=false;switch(f){case"beforeclose":f="beforeClose";break;case"buttons":d._createButtons(g);break;case"closeText":d.uiDialogTitlebarCloseText.text(""+g);break;case"dialogClass":c.removeClass(d.options.dialogClass).addClass(a+g);break;case"disabled":(g?c.addClass("ui-dialog-disabled"):c.removeClass("ui-dialog-disabled"));break;case"draggable":(g?d._makeDraggable():c.draggable("destroy"));break;case"height":e=true;break;case"maxHeight":(h&&c.resizable("option","maxHeight",g));e=true;break;case"maxWidth":(h&&c.resizable("option","maxWidth",g));e=true;break;case"minHeight":(h&&c.resizable("option","minHeight",g));e=true;break;case"minWidth":(h&&c.resizable("option","minWidth",g));e=true;break;case"position":d._position(g);break;case"resizable":(h&&!g&&c.resizable("destroy"));(h&&typeof g=="string"&&c.resizable("option","handles",g));(h||(g!==false&&d._makeResizable(g)));break;case"title":b(".ui-dialog-title",d.uiDialogTitlebar).html(""+(g||"&#160;"));break;case"width":e=true;break}b.Widget.prototype._setOption.apply(d,arguments);(e&&d._size())},_size:function(){var d=this.options;this.element.css("width","auto").hide();var c=this.uiDialog.css({height:"auto",width:d.width}).height();this.element.css(d.height=="auto"?{minHeight:Math.max(d.minHeight-c,0),height:"auto"}:{minHeight:0,height:Math.max(d.height-c,0)}).show();(this.uiDialog.is(":data(resizable)")&&this.uiDialog.resizable("option","minHeight",this._minHeight()))}});b.extend(b.ui.dialog,{version:"1.8rc3",uuid:0,maxZ:0,getTitleId:function(c){return"ui-dialog-title-"+(c.attr("id")||++this.uuid)},overlay:function(c){this.$el=b.ui.dialog.overlay.create(c)}});b.extend(b.ui.dialog.overlay,{instances:[],oldInstances:[],maxZ:0,events:b.map("focus,mousedown,mouseup,keydown,keypress,click".split(","),function(c){return c+".dialog-overlay"}).join(" "),create:function(d){if(this.instances.length===0){setTimeout(function(){if(b.ui.dialog.overlay.instances.length){b(document).bind(b.ui.dialog.overlay.events,function(e){return(b(e.target).zIndex()>=b.ui.dialog.overlay.maxZ)})}},1);b(document).bind("keydown.dialog-overlay",function(e){if(d.options.closeOnEscape&&e.keyCode&&e.keyCode==b.ui.keyCode.ESCAPE){d.close(e);e.preventDefault()}});b(window).bind("resize.dialog-overlay",b.ui.dialog.overlay.resize)}var c=(this.oldInstances.length?this.oldInstances.splice(0,1)[0]:b("<div></div>").addClass("ui-widget-overlay")).appendTo(document.body).css({width:this.width(),height:this.height()});(b.fn.bgiframe&&c.bgiframe());this.instances.push(c);return c},destroy:function(c){this.oldInstances.push(this.instances.splice(b.inArray(this.instances,c),1)[0]);if(this.instances.length===0){b([document,window]).unbind(".dialog-overlay")}c.remove();var d=0;b.each(this.instances,function(){d=Math.max(d,this.css("z-index"))});this.maxZ=d},height:function(){if(b.browser.msie&&b.browser.version<7){var d=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight);var c=Math.max(document.documentElement.offsetHeight,document.body.offsetHeight);if(d<c){return b(window).height()+"px"}else{return d+"px"}}else{return b(document).height()+"px"}},width:function(){if(b.browser.msie&&b.browser.version<7){var c=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth);var d=Math.max(document.documentElement.offsetWidth,document.body.offsetWidth);if(c<d){return b(window).width()+"px"}else{return c+"px"}}else{return b(document).width()+"px"}},resize:function(){var c=b([]);b.each(b.ui.dialog.overlay.instances,function(){c=c.add(this)});c.css({width:0,height:0}).css({width:b.ui.dialog.overlay.width(),height:b.ui.dialog.overlay.height()})}});b.extend(b.ui.dialog.overlay.prototype,{destroy:function(){b.ui.dialog.overlay.destroy(this.$el)}})})(jQuery);