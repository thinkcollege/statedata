//\//////////////////////////////////////////////////////////////////////////////////
//\  overLIB 3.50  --  This notice must remain untouched at all times.
//\  Copyright Erik Bosrup 1998-2001. All rights reserved.
//\
//\  By Erik Bosrup (erik@bosrup.com).  Last modified 2001-08-28.
//\  Portions by Dan Steinman (dansteinman.com). Additions by other people are
//\  listed on the overLIB homepage.
//\
//\  Get the latest version at http://www.bosrup.com/web/overlib/
//\
//\  This script is published under an open source license. Please read the license
//\  agreement online at: http://www.bosrup.com/web/overlib/license.html
//\  If you have questions regarding the license please contact erik@bosrup.com.
//\
//\  This script library was originally created for personal use. By request it has
//\  later been made public. This is free software. Do not sell this as your own
//\  work, or remove this copyright notice. For full details on copying or changing
//\  this script please read the license agreement at the link above.
//\
//\  Please give credit on sites that use overLIB and submit changes of the script
//\  so other people can use them as well. This script is free to use, don't abuse.
//\//////////////////////////////////////////////////////////////////////////////////

//\  THIS IS A VERY MODIFIED VERSION. DO NOT EDIT OR PUBLISH. GET THE ORIGINAL!

function noPopUp()
{
	return ver3fix;
}

function showPopUp()
{
	var args=arguments;
	var x = properties.x;
	var y = properties.y;
	properties = new PopUpProperties(args[POP_UP_PROPERTIES]);
	properties.x = x;
	properties.y = y;

	var imgId = args[POP_UP_IMG_ID];

	var overridetext = args[POP_UP_TEXT];
	if(overridetext != null && typeof overridetext != 'undefined' && overridetext.length > 0)
	{
		properties.text = overridetext;
	}

	var overridex = args[POP_UP_X];
	var overridey = args[POP_UP_Y];
	if(overridex != null && typeof overridex != 'undefined' && overridex > -100 && overridey != null && typeof overridey != 'undefined' && overridey > -100)
	{
		if(ns4)
		{
			img = document.images[imgId];
		}
		else
		{
			img = document.getElementById(imgId);
		}
		if(img != null)
		{
			imgwidth = img.offsetWidth;
			imgheight = img.offsetHeight;
			imgx = getPageLeft(img);
			imgy = getPageTop(img);
			properties.fixx = overridex + imgx
			properties.fixy = overridey + imgy;
			properties.offsetx = 0;
			properties.offsety = 0;
			properties.allowMove = 1;
		}
	}

	var overrideurl = args[DD_URL];
	var overridetarget = args[DD_TARGET];
	if(overrideurl != null && typeof overrideurl != 'undefined' && overrideurl.length > 0)
	{
		properties.url = overrideurl;
		if(overridetarget != null && typeof overridetarget != 'undefined' && overridetarget.length > 0)
		{
			properties.target = overridetarget;
		}
	}

	properties.textSize-=3;
	var text = getFormattedText();
	var overridewidth = getPixelWidth(text);
	if(properties.width > overridewidth)
	{
		properties.width = overridewidth;
	}

	var overrideheight = getPixelHeight(text);
	properties.height = overrideheight;

	if(properties.width > imgwidth)
	{
		properties.width = imgwidth
		properties.x = 0;
	}
	if(properties.height > imgheight)
	{
		properties.height = imgheight
		properties.y = 0;
	}


	if((ns4)||(ie4)||(ns6))
	{
		oframe=ol_frame;
		if(ns4)
		{
			over=oframe.document.overDiv;
		}
		if(ie4)
		{
			over=oframe.overDiv.style;
		}
		if(ns6)
		{
			over=oframe.document.getElementById("overDiv");
		}
	}
	if(!(navigator.platform.substr(0,3) == "Mac" && ie4))
	{
		return overlib();
	}
}

function getFormattedText()
{
	var txt;
	if(ns4)
	{
		txt="<FONT POINT-SIZE="+properties.textSize+" FACE="+properties.textFont+properties.textBackup+" COLOR="+properties.textColor+">"+properties.text+"</FONT>";
		if(properties.textWeight=="bold")
			txt = "<B>" + txt + "</B>";
		if(properties.textStyle=="italic")
			txt = "<I>" + txt + "</I>";
	}
	else
	{
		txt="<FONT style=\"font-family: "+properties.textFont+properties.textBackup+";color: "+properties.textColor+";font-size: "+properties.textSize+properties.textSizeUnit+";font-weight: "+properties.textWeight+";font-style:"+properties.textStyle+"\">"+properties.text+"</FONT>";
	}
	return txt;
}

function getPixelWidth(sStr)
{
	var obj;
	var w;
	if(ns4)
	{
		obj=document["hdiv"];
		obj.document.open();
		obj.document.write(sStr);
		obj.document.close();
		w = obj.document.width + 6;
	}
	else if(ie4)
	{
		obj=oframe.hdiv;
		obj.innerHTML = sStr;
		w = obj.offsetWidth + 6;
	}
	else if(ns6)
	{
		obj=oframe.document.getElementById("hdiv");
		obj.innerHTML = sStr;
		w = obj.offsetWidth + 6;
	}
	return w;
}

function getPixelHeight(sStr)
{
	var obj;
	var h;
	if(ns4)
	{
		obj=document["hdiv"];
		obj.document.open();
		obj.document.write(sStr);
		obj.document.close();
		h = obj.document.height;
	}
	else if(ie4)
	{
		obj=oframe.hdiv;
		obj.innerHTML = sStr;
		h = obj.offsetHeight;
	}
	else if(ns6)
	{
		obj=oframe.document.getElementById("hdiv");
		obj.innerHTML = sStr;
		h = obj.offsetHeight;
	}
	return h;
}

function hidePopUp()
{
	if((ns4)||(ie4)||(ns6)){
		properties.allowMove=0;
		if(over !=null)hideObject(over);
	}
	return true;
}

function getPageLeft(el)
{
	if(ns4)
	{
		return el.x;
	}
	var x;
	x = 0;
	while(el.offsetParent!=null)
	{
		x+=el.offsetLeft;
		el=el.offsetParent;
	}
	x+=el.offsetLeft;
	return x;
}

function getPageTop(el)
{
	if(ns4)
	{
		return el.y;
	}
	var y;
	y=0;
	while(el.offsetParent!=null)
	{
		y+=el.offsetTop;
		el=el.offsetParent;
	}
	y+=el.offsetTop;
	return y;
}

function overlib()
{
	var layerhtml;

	layerhtml=getSimpleContext();
	//newwindow = window.open();
	//newwindow.document.write("<HTML>" + layerhtml + "</HTML>");
	layerWrite(layerhtml);
	properties.allowMove=0;
	display();
	return true;
}

function getSimpleContext()
{
	var height = "";
	var bordercolor = "";
	var fillcolor = "";

	if(properties.transBG && properties.border > 0)
	{
		bordercolor="style=\"border-width:thin;border-style:solid;border-color:"+properties.borderColor+"\";";
	}
	else
	{
		if(properties.borderColor!="")
		{
			bordercolor="BGCOLOR=\""+properties.borderColor+"\"";
		}
		if(properties.fillColor!="")
		{
			fillcolor="BGCOLOR=\""+properties.fillColor+"\"";
		}
		if(properties.transBG)
		{
			bordercolor="";
			fillcolor="";
		}
	}

	if(properties.height > 0)
	{
		height="HEIGHT=" + properties.height;
	}

	var extra = "style=\"cursor:pointer;cursor:hand\"";
	if(properties.url != null)
	{
		self.status = "LINK: " + properties.url;
		extra+="onclick=\"goTo('"+properties.url+"','";
		if(properties.target != null)
		{
			extra+=properties.target+"');\"";
		}
		else
		{
			extra+="self');\"";
		}
	}

	if(properties.padxl != 0 || properties.padxr != 0 || properties.padyt != 0 || properties.padyb != 0)
	{
		txt="<TABLE "+extra+" BORDER=0 CELLPADDING="+properties.border+" CELLSPACING=0 "+bordercolor+" "+height+"><TR><TD><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD COLSPAN=3 HEIGHT="+properties.padyt+" "+fillcolor+"></TD></TR><TR><TD WIDTH="+properties.padxl+" "+fillcolor+"></TD><TD VALIGN=TOP "+fillcolor+"><TABLE WIDTH="+(properties.width-properties.padxl-properties.padxr)+" BORDER=0 CELLPADDING=0 CELLSPACING=0 "+fillcolor+" "+height+"><TR><TD VALIGN=TOP ALIGN="+properties.justification+">";
		txt+=getFormattedText()+"</TD></TR></TABLE></TD><TD WIDTH="+properties.padxr+" "+fillcolor+"></TD></TR><TR><TD COLSPAN=3 HEIGHT="+properties.padyb+" "+fillcolor+"></TD></TR></TABLE></TD></TR></TABLE>";
	}
	else
	{
		txt="<TABLE "+extra+" WIDTH="+properties.width+" BORDER=0 CELLPADDING="+properties.border+" CELLSPACING=0 "+bordercolor+" "+height+"><TR><TD><TABLE WIDTH=100% BORDER=0 CELLPADDING=2 CELLSPACING=0 "+fillcolor+" "+height+"><TR><TD VALIGN=TOP ALIGN="+properties.justification+">"+getFormattedText()+"</TD></TR></TABLE></TD></TR></TABLE>";
	}
	return txt;
}

function goTo(url, target)
{
	var loop = true;

	var f = findFrame(target);

	if(f)
	{
		f.location = url;
	}
	else
	{
		target = target.substring(1);
		f = findFrame(target);
		if(f)
		{
			f.location = url;
		}
		else
		{
			window.open(url);
		}
	}
}

function findFrame(what)
{
	var frame = self;
	var oldframe = null;
	while(frame != null && frame != oldframe)
	{
		oldframe = frame;
		if(frame.frames)
		{
			if(frame.frames[what])
			{
				return frame.frames[what];
			}
		}
		frame = frame.parent;
	}
	return null;
}

function display()
{
	if((ns4)||(ie4)||(ns6))
	{
		if(properties.allowMove==0)
		{
			placeLayer();
			showObject(over);
			properties.allowMove=1;
		}
	}
}

function placeLayer()
{
	var placeX, placeY, winoffset, iwidth;
	if(properties.fixx > -100)
	{
		properties.x=properties.fixx;
	}
	else
	{
		winoffset=(ie4)? oframe.document.body.scrollLeft : oframe.pageXOffset;
		if(ie4)iwidth=oframe.document.body.clientWidth;
		if(ns4)iwidth=oframe.innerWidth;// was screwed in mozilla, fixed now?
		if(ns6)iwidth=oframe.outerWidth;
		if(properties.hauto == 1)
		{
			if((properties.x - winoffset) > ((eval(iwidth))/ 2))
			{
				properties.hpos=LEFT;
			}
			else
			{
				properties.hpos=RIGHT;
			}
		}
	}

	if(properties.hpos==CENTER) // Center
	{
		placeX = properties.x + properties.offsetx - (properties.width/2);
	}
	else if(properties.hpos==RIGHT) // Right
	{
		placeX=properties.x+properties.offsetx;
		if((eval(placeX)+eval(properties.width))>(winoffset + iwidth))
		{
			placeX=iwidth+winoffset-properties.width;
			if(placeX < 0)placeX=0;
		}
	}
	else if(properties.hpos==LEFT) // Left
	{
		placeX=properties.x-properties.offsetx-properties.width;
		if(placeX < winoffset)placeX=winoffset;
	}

	var scrolloffset=0;
	if(properties.fixy > -100)
	{
		properties.y=properties.fixy;
	}
	else
	{
		scrolloffset=(ie4)? oframe.document.body.scrollTop : oframe.pageYOffset;
		if(properties.vauto==1)
		{
			if(ie4)iheight=oframe.document.body.clientHeight;
			if(ns4)iheight=oframe.innerHeight;
			if(ns6)iheight=oframe.outerHeight;
			iheight=(eval(iheight))/ 2;
			if((properties.y - scrolloffset)> iheight)
			{
				properties.vpos=ABOVE;
			}
			else
			{
				properties.vpos=BELOW;
			}
		}
	}
	if(properties.vpos==ABOVE)
	{
		if(properties.aboveheight==0)
		{
			var divref=(ie4)? oframe.document.all['overDiv'] : over;
			properties.aboveheight=(ns4)? divref.clip.height : divref.offsetHeight;
		}
		placeY=properties.y-(properties.aboveheight+properties.offsety);
		if(placeY < scrolloffset)placeY=scrolloffset;
	}
	else if(properties.vpos==BELOW)
	{
		placeY=properties.y+properties.offsety;
	}
	else if(properties.vpos==CENTER)
	{
		placeY=properties.y+properties.offsety-(properties.height/2);
	}

	if(img != null)
	{
		var element;

		//alert(imgwidth);
		//alert(imgheight);

		if(placeX < imgx)
		{
			placeX = imgx;
		}
		if(placeY < imgy)
		{
			placeY = imgy;
		}

		if(placeX + properties.width > imgx + imgwidth)
		{
			placeX = imgx + imgwidth - properties.width;
		}
		if(placeY + properties.height + 6 > imgy + imgheight)
		{
			placeY = imgy + imgheight - properties.height - 6;
		}
	}

	repositionTo(over, placeX, placeY);
}

function mouseMove(e)
{
	if((ns4)||(ns6)){properties.x=e.pageX;properties.y=e.pageY;}
	if(ie4){properties.x=event.x;properties.y=event.y;}
	if(ie5){properties.x=event.x+oframe.document.body.scrollLeft;properties.y=event.y+oframe.document.body.scrollTop;}

	if(img != null)
	{
		var element;

		if(properties.x < imgx)
		{
			hidePopUp();
		}
		else if(properties.x > imgx + imgwidth)
		{
			hidePopUp();
		}
		else if(properties.y < imgy)
		{
			hidePopUp();
		}
		else if(properties.y > imgy + imgheight)
		{
			hidePopUp();
		}
	}

	if(properties.allowMove==1)
	{
		placeLayer();
	}
}

function compatibleframe(frameid)
{
	if(ns4)
	{
		if(typeof frameid.document.overDiv=='undefined')return false;
	}
	else if(ie4)
	{
		if(typeof frameid.document.all["overDiv"]=='undefined')return false;
	}
	else if(ns6)
	{
		if(frameid.document.getElementById('overDiv')==null)return false;
	}
	return true;
}

function layerWrite(txt)
{
	txt +="\n";
	if(ns4)
	{
		var lyr=oframe.document.overDiv.document;
		lyr.write(txt);
		lyr.close();
	}
	else if(ie4)
	{
		oframe.document.all["overDiv"].innerHTML=txt;
	}
	else if(ns6)
	{
		range=oframe.document.createRange();
		range.setStartBefore(over);
		domfrag=range.createContextualFragment(txt);
		while(over.hasChildNodes())
		{
			over.removeChild(over.lastChild);
		}
		over.appendChild(domfrag);
	}
}

function showObject(obj)
{
	if(ns4)obj.visibility="show";
	else if(ie4)obj.visibility="visible";
	else if(ns6)obj.style.visibility="visible";
}

function hideObject(obj)
{
	if(ns4)obj.visibility="hide";
	else if(ie4)obj.visibility="hidden";
	else if(ns6)obj.style.visibility="hidden";
	self.status="";
}

function repositionTo(obj,xL,yL)
{
	if((ns4)||(ie4))
	{
		obj.left=xL;
		obj.top=yL;
	}
	else if(ns6)
	{
		obj.style.left=xL + "px";
		obj.style.top=yL+ "px";
	}
}

function PopUpProperties(props)
{
	if(props==null || props=="")
	{
		this.popUpType=1;
		this.text="No Text Specified";
		this.fillColor="#CCCCFF";
		this.borderColor="Black";
		this.textColor="Black";
		this.offsetx=2;
		this.offsety=2;
		this.hpos=CENTER;
		this.width=9999;
		this.border=1;
		this.height=0;
		this.fixx=-100;
		this.fixy=-100;
		this.padxl=0;
		this.padxr=0;
		this.padyt=0;
		this.padyb=0;
		this.vpos=ABOVE;
		this.aboveheight=0;
		this.textFont="";
		this.textBackup=",Helvetica,Arial";
		this.textSize="10";
		this.textSizeUnit="pt";
		this.textWeight="";
		this.textStyle="";
		this.allowMove=0;
		this.hauto=0;
		this.vauto=0;
		this.x=0;
		this.y=0;
		this.transBG=0;
		this.justification="LEFT";
		this.url=null;
		this.target=null;
	}
	else
	{
		this.popUpType=props.popUpType;
		this.text=props.text;
		this.fillColor=props.fillColor;
		this.borderColor=props.borderColor;
		this.textColor=props.textColor;
		this.offsetx=props.offsetx;
		this.offsety=props.offsety;
		this.hpos=props.hpos;
		this.width=props.width;
		this.border=props.border;
		this.height=props.height;
		this.fixx=props.fixx;
		this.fixy=props.fixy;
		this.padxl=props.padxl;
		this.padxr=props.padxr;
		this.padyt=props.padyt;
		this.padyb=props.padyb;
		this.vpos=props.vpos;
		this.aboveheight=props.aboveheight;
		this.textFont=props.textFont;
		this.textBackup=props.textBackup;
		this.textSize=props.textSize;
		this.textSizeUnit=props.textSizeUnit;
		this.textWeight=props.textWeight;
		this.textStyle=props.textStyle;
		this.allowMove=props.allowMove;
		this.hauto=props.hauto;
		this.vauto=props.vauto;
		this.x=props.x;
		this.y=props.y;
		this.transBG=props.transBG;
		this.justification=props.justification;
		this.url=props.url;
		this.target=props.target;
	}
	return this;
}

var jsPopUp = 1;
var properties = new PopUpProperties();

var POP_UP_PROPERTIES=0;
var POP_UP_IMG_ID=1;
var POP_UP_TEXT=2;
var POP_UP_X=3;
var POP_UP_Y=4;
var DD_URL=5;
var DD_TARGET=6;

var POP_UP=1;
var DATA_LABEL=2;

var LEFT=1;
var RIGHT=2;
var CENTER=3;

var ABOVE=1;
var BELOW=2;
var CENTER=3;

if(typeof ol_frame=='undefined'){var ol_frame=self;}

var img = null;
var imgx = null;
var imgy = null;
var imgwidth = null;
var imgheight = null;

var oframe=ol_frame;
var over=null;
var ns4=(document.layers)? true:false;
var ns6=(document.getElementById)? true:false;
var ie4=(document.all)? true:false;
var ie5=false;

if(ie4)
{
	if((navigator.userAgent.indexOf('MSIE 5')> 0)||(navigator.userAgent.indexOf('MSIE 6')> 0))
	{
		ie5=true;
	}
	if(ns6)
	{
		ns6=false;
	}
}

if((ns4)||(ie4)||(ns6))
{
	document.onmousemove=mouseMove
	if(ns4)
	{
		document.captureEvents(Event.MOUSEMOVE)
	}
}
else
{
	showPopUp=noPopUp;
	hidePopUp=noPopUp;
	ver3fix=true;
}

if((ns4)||(ie4)||(ns6))
{
	if(!$("overDiv"))
	{
		var d = document.createElement('div');
		d.id = 'overDiv';
		d.name = 'overDiv';
		d.style.position='absolute';
		d.style.visibility = 'hidden';
		d.style.zIndex = 1000;
		document.body.insertBefore(d, document.body.childNodes[0]);
	}
	
	if(typeof document.body.hdiv=='undefined')
	{
		d = document.createElement('div');
		d.id = 'hdiv';
		d.name = 'hdiv';
		d.style.position='absolute';
		d.style.visibility = 'hidden';
		d.style.zIndex = 1000;
		document.body.insertBefore(d, document.body.childNodes[0]);
	}
}