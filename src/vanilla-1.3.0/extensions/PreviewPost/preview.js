var request;var form;var comprev;function createrequest_post(b,d,c){request=false;if(window.XMLHttpRequest){request=new XMLHttpRequest();if(request.overrideMimeType){request.overrideMimeType("text/xml")}}else{if(window.ActiveXObject){try{request=new ActiveXObject("Msxml2.XMLHTTP")}catch(a){try{request=new ActiveXObject("Microsoft.XMLHTTP")}catch(a){}}}}if(!request){return false}request.onreadystatechange=c;request.open("POST",b,true);request.setRequestHeader("Content-type","application/x-www-form-urlencoded");request.setRequestHeader("Content-length",d.length);request.setRequestHeader("Connection","close");request.send(d);return true}function getform(){var a=document.getElementById("frmPostDiscussion");if(!a){a=document.getElementById("frmPostComment")}return a}function _showpreview(){if(request.readyState==4&&request.status==200){comprev.innerHTML=request.responseText;getform().btnPreview.value="Refresh Preview";comprev.parentNode.scrollIntoView()}}function showpreview(e,b){var l,c,k,j,d,g,h,a;a='<a href="'+e+"account.php?u="+b.id+'">'+b.name+"</a>";form=getform();if(form){if(!(comprev=document.getElementById("CommentBody_Preview"))){if(!(l=document.getElementById("Comments"))){l=document.createElement("ul");l.id="Comments";l.className="Preview";l.style.marginBottom="10px";document.getElementById("Content").insertBefore(l,document.getElementById("Form"))}c=document.createElement("li");c.id="Comment_Preview";c.innerHTML='<div class="CommentHeader"><ul><li id="_cp_userinfo"></li><li> right now</li></ul><span><a href="javascript:getform().submit();">submit comment</a></span></div><div id="CommentBody_Preview" class="CommentBody"></div>';l.appendChild(c);comprev=document.getElementById("CommentBody_Preview");comprev.parentNode.style.backgroundImage="url("+e+"extensions/PreviewPost/preview.png)"}h=form.WhisperUsername?form.WhisperUsername.value:"";comprev.parentNode.className=h.length?"WhisperFrom":"";document.getElementById("_cp_userinfo").innerHTML=a+(h.length?(" to "+h):"");if(typeof(FCKeditorAPI)!="undefined"){k=FCKeditorAPI.GetInstance("Body").GetXHTML(true)}else{k=form.Body.value}k=(encodeURIComponent)?encodeURIComponent(k):escape(k.replace(/\+/g,"%2B"));if(!form.FormatType.length){j=form.FormatType.value}else{for(d=g=0;d<form.FormatType.length;d++){if(form.FormatType[d].checked){g=1;break}}if(!g){d=0}j=escape(form.FormatType[d].value)}if(!createrequest_post(e+"extensions/PreviewPost/ajax.php","Data="+k+"&Type="+j,_showpreview)){alert("An error occured while attempting to set up request")}}else{alert("Unable to find form")}return};