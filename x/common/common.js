function validateEmailform(frm)
{
	returnvalue = true
	msg = ""
	if(frm.from_email.value =="")
	{
		msg +="from email address missing \n";
		returnvalue = false;
	}
	else
	{
		if (!verifyEmail(frm.from_email.value))
		{
			msg +="from email address is invalid \n";
			returnvalue = false;
		}
	}
	
	if(frm.to_email.value =="")
	{
		msg +="to email address missing \n";
		returnvalue = false;
	}
	else
	{
		if (!verifyEmail(frm.to_email.value))
		{
			msg +="to email address is invalid \n";
			returnvalue = false;
		}
	}
	if(frm.subject.value =="")
	{
		msg +="subject missing \n";
		returnvalue = false;
	}
	if (returnvalue == false)
	{
		alert("The following problems were encountered:\n" + msg);
	}
	else
	{
		frm.submit();
	}
}
// based on script by Sandeep V. Tamhankar (stamhankar@hotmail.com) 
function verifyEmail(emailStr) {
	var emailPat = /^(.+)@(.+)$/;
	var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
	var validChars = "\[^\\s" + specialChars + "\]";
	var quotedUser = "(\"[^\"]*\")";
	var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom = validChars + '+';
	var word = "(" + atom + "|" + quotedUser + ")";
	var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat= new RegExp("^" + atom + "(\\." + atom +")*$");

	var matchArray = emailStr.match(emailPat);

	if (matchArray == null) { return false;}

	var user = matchArray[1]
	var domain = matchArray[2]
	if (user.match(userPat) == null) { return false; }

	var IPArray=domain.match(ipDomainPat)
	if (IPArray != null) {
		for (var i=1; i<=4; i++) {
	    		if (IPArray[i] > 255) {
	        		return false;
	    		}
    	}
   		return true;
	}

	var domainArray = domain.match(domainPat)
	if (domainArray == null) {
		return false;
	}

	var atomPat = new RegExp(atom,"g")
	var domArr = domain.match(atomPat)
	var len = domArr.length
	if (domArr[domArr.length-1].length < 2 || domArr[domArr.length-1].length > 3) {
		return false;
	}

	if (len < 2) { return false; }
	
   	return true;
}

function openEmail(url)
{
	popup("/EmailChart_Popup.php?url=" + escape(url), 800,600,1,1);
}

function openChartDownload(categories, data)
{
	popup("download_chart_data.php?categories=" + escape(categories) + "&data=" + escape(data), 800,600,'no',1);
}
/*----------------------
  Open_PopUp('home.htm','455','271','1');
  args: URL,X-dimension,Y-Dimension,scrolling(1,0)
----------------------*/

var popUpWin
function popup(page,x,y,scroll,center){
    scroll = (isNaN(scroll)) ? 0:scroll;
	x = (isNaN(x))? 480:x;
	y = (isNaN(y))? 288:y;
	center = (isNaN(center)) ? 0:1;
	
	if (center) {
		
    	if (document.getElementById)
    	    var xMax = screen.width, yMax = screen.height;
    	else
    	    if (document.layers)
    	        var xMax = window.outerWidth, yMax = window.outerHeight;
    	    else
    	        var xMax = 640, yMax=480;
				
    	var xOffset = (xMax - x)/2, yOffset = (yMax - y)/2;
		if(popUpWin!=true){
			popUpWin = window.open(page,'w2','width=' + x + ',height=' + 
			y + ',screenX='+xOffset+',screenY='+yOffset+',top='+yOffset+',left='+xOffset+',toolbar=0,menubar=0,resizable=yes,status=0,scrollbars=' + scroll );
		}
		
	}else {
		if(popUpWin!=true){popUpWin = window.open(page,'w2','width=' + x + ',height=' + y + ',toolbar=0,menubar=0,resizable=yes,status=0,scrollbars=' + scroll + ',left=100,top=50');}
	}
	
	setTimeout("popUpWin.focus()",200);
}



//center a pop up window
function centerWindow(page,x,y) {
    if (document.all)
        var xMax = screen.width, yMax = screen.height;
    else
        if (document.layers)
            var xMax = window.outerWidth, yMax = window.outerHeight;
        else
            var xMax = 640, yMax=480;

    var xOffset = (xMax - x)/2, yOffset = (yMax - y)/2;

    window.open(page,'myExample7','width='+x+',height='+y+',screenX='+xOffset+',screenY='+yOffset+',top='+yOffset+',left='+xOffset+'');
}



function checkTop() {
  if(window.parent != self) {
    window.top.location = self.location;
  }
}

function getRadioValue(formName,elementName) {
	var m;
	radioArray = eval("document." + formName + "." + elementName );
	for(m=0; m<radioArray.length; m++) {
		if(radioArray[m].checked) {
			return radioArray[m].value
		}
	}
	return "";
}

function getSelectValue(formName,elementName) {
	var k;
	selectObj = eval("document." + formName + "." + elementName );
	k = selectObj.selectedIndex
	return selectObj.options[k].value
}

//-----------------------------------------------------------------------------------
// Form Validation routines.
// In you page create an array of validObj. One for each form element you want to validate.
// Currently all arguments are required
//

function validate(validArray) {
  var elemType;
  var i;
  for(i=0;i<validArray.length;i++) {
    var elem = eval("document." + validArray[i].formName + "." + validArray[i].elementName);
    var elemType = elem.type;
    //alert(elemType + "'" + elem.value + "'");

	if (elemType != "file") {
	    if (elemType == "text" || elemType == "textarea") {
	      if(elem.value == validArray[i].notEqualVal) {
	        alert("You must enter a value for '" + validArray[i].niceName + "'.");
	        elem.focus();
	        return false;
	      }
	    }
	
	    if (elemType == "select-one") {
	      if(getSelectValue(validArray[i].formName,validArray[i].elementName) == validArray[i].notEqualVal) {
	        alert("You must enter a value for '" + validArray[i].niceName + "'.");
	        elem.focus();
	        return false;
	      }
	    }
	}
  }
  return true;
}

function validObj(formName,elementName,niceName,notEqualVal) {
  this.formName = formName;
  this.elementName = elementName;
  this.niceName = niceName;
  this.notEqualVal = notEqualVal;
}

//-----------------------------------------------------------------------------------
// Form Submission for on_keydown event
// called with: onkeydown=" return on_keydown(event);" in the text form element.
// use "return" so that the return keydown doesn't auto submit the form.
// This calls the doSubmit() function of the particular page.
//-----------------------------------------------------------------------------------

function on_keydown(formInfo,e,action)
{
	var keyCode = document.layers ? e.which : e.keyCode;
	if (keyCode == 13)
	{
		validatelogin (formInfo);
		return false;
	}

	return true;
}




function replaceStr(sourceStr, searchStr, replaceStr) {
  while (sourceStr.indexOf(searchStr)!= -1){
    firstStr = sourceStr.slice(0,sourceStr.indexOf(searchStr));
    //alert("firstStr=" + firstStr + "!");
    secondStr = sourceStr.slice(firstStr.length + searchStr.length, sourceStr.length);
    //alert("secondStr=" + secondStr + "!");
    sourceStr = firstStr + replaceStr + secondStr;
  }
    return sourceStr;
}


function parseQueryString (str) {
  str = str ? str : location.search;
  var query = str.charAt(0) == '?' ? str.substring(1) : str;
  var args = new Object();
  if (query) {
    var fields = query.split('&');
    for (var f = 0; f < fields.length; f++) {
      var field = fields[f].split('=');
      args[unescape(field[0].replace(/\+/g, ' '))] = unescape(field[1].replace(/\+/g, ' '));
    }
  }
  return args;
}

//Example of how to use the parseQueryString function
//var args = parseQueryString ();
//for (var arg in args) {
//  document.write(arg + ': ' + args[arg] + '<BR>');
//}


function WriteLayer(ID,parentID,sText) {
	if (document.layers) {
   		var oLayer;
   		if(parentID){
     		oLayer = eval('document.' + parentID + '.document.' + ID + '.document');
   		}else{
     		oLayer = document.layers[ID].document;
   		}
   		oLayer.open();
   		oLayer.write(sText);
   		oLayer.close();
 	} else if (parseInt(navigator.appVersion)>=5&&navigator.appName=="Netscape") {
   		document.getElementById(ID).innerHTML = sText;
 	} else if (document.all) 
		document.all[ID].innerHTML = sText
} 


function hideObject(id) {
  if (ns4) {
     eval ("document." + id + ".visibility = 'hide'");
  }
  else if (ie4) {
     document.all[id].style.visibility = "hidden";
  }
  else if (nn6) {
     document.getElementById(id).style.visibility = "hidden";
  }
}


function showObject(id) {
  if (ns4) {
     eval ("document." + id + ".visibility = 'show'");
  }
  else if (ie4) {
     document.all[id].style.visibility = "visible";
  }
  else if (nn6) {
     document.getElementById(id).style.visibility = "visible";
  }
}


/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;
/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
    if (currentColor.indexOf("rgb") >= 0) 
    {
        var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
                                     currentColor.indexOf(')'));
        var rgbValues = rgbStr.split(",");
        currentColor = "#";
        var hexChars = "0123456789ABCDEF";
        for (var i = 0; i < 3; i++)
        {
            var v = rgbValues[i].valueOf();
            currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
        }
    }

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function
