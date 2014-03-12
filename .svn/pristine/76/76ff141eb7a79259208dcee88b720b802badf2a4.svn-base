var lastCtrlTime = 0;
var lastQTime = 0;
var isCtrl = false;
var isKeyQ = false;

/* ########### */
/*  utilities  */
/* ########### */

function getSelectedRadio(buttonGroup)
{
    // returns the array number of the selected radio button or -1 if no button is selected
    if (buttonGroup[0])
    { // if the button group is an array (one button is not an array)
        for (var i=0; i<buttonGroup.length; i++)
        {
            if (buttonGroup[i].checked)
            {
                return buttonGroup[i].value;
            }
        }
    }
    else
    {
        if (buttonGroup.checked)
        {
            return buttonGroup.value;
        } // if the one button is checked, return zero
    }
    // if we get to this point, no radio button is selected
    return -1;
} // Ends the "getSelectedRadio" function

function getSelectedCheckbox(buttonGroup)
{
    // Go through all the check boxes. return an array of all the ones
    // that are selected (their position numbers). if no boxes were checked,
    // returned array will be empty (length will be zero)
    var retArr = new Array();
    var lastElement = 0;

    if (buttonGroup[0])
    { // if the button group is an array (one check box is not an array)
        for (var i=0; i<buttonGroup.length; i++)
        {
            if (buttonGroup[i].checked)
            {
                retArr.length = lastElement;
                retArr[lastElement] = i;
                lastElement++;
            }
        }
    }
    else
    { // There is only one check box (it's not an array)
        if (buttonGroup.checked)
        { // if the one check box is checked
            retArr.length = lastElement;
            retArr[lastElement] = 0; // return zero as the only array value
        }
    }

    return retArr;
}

function getSelectedCheckboxValue(buttonGroup)
{
    // return an array of values selected in the check box group. if no boxes
    // were checked, returned array will be empty (length will be zero)
    var retArr = new Array(); // set up empty array for the return values
    var selectedItems = getSelectedCheckbox(buttonGroup);

    if (selectedItems.length != 0)
    { // if there was something selected
        retArr.length = selectedItems.length;

        for (var i=0; i<selectedItems.length; i++)
        {
            if (buttonGroup[selectedItems[i]])
            { // Make sure it's an array
                retArr[i] = buttonGroup[selectedItems[i]].value;
            }
            else
            { // It's not an array (there's just one check box and it's selected)
                retArr[i] = buttonGroup.value;// return that value
            }
        }
    }

    return retArr;
}

function uncheckAllCheckbox(elementName)
{
    buttonGroup = document.getElementsByName(elementName);

    if (buttonGroup[0])
    {
        for (var i=0; i<buttonGroup.length; i++)
        {
            buttonGroup[i].checked = false;
        }
    }
    else
    { // There is only one check box (it's not an array)
        buttonGroup.checked = false;
    }
}

function getComboVal(combo)
{
    return $(combo).options[$(combo).selectedIndex].value;
}

function loadExternalFile(fileName, fileType, fileId)
{
    var check = checkFileAlreadyLoaded(fileId);

    if(!check)
    {
        var fileRef;

        if (fileType == "js")//if filename is a external JavaScript file
        {
            fileRef = document.createElement('script');
            fileRef.setAttribute("type", "text/javascript");
            fileRef.setAttribute("src", fileName);
            fileRef.setAttribute("id", fileId);
        }
        else if (fileType == "css")//if filename is an external CSS file
        {
            fileRef = document.createElement("link");
            fileRef.setAttribute("rel", "stylesheet");
            fileRef.setAttribute("type", "text/css");
            fileRef.setAttribute("href", fileName);
            fileRef.setAttribute("id", fileId);
        }

        $('head').appendChild(fileRef);

        return true;
    }
    else
    {
        return false;
    }
}

function checkFileAlreadyLoaded(fileId)
{
    var child = $('head').childElements();
    var type;

    for(var i=0;i<child.length;i++)
    {
        type = child[i].readAttribute('type');

        if(type == "text/javascript")
        {
            if(child[i].readAttribute('id') == fileId)
            {
                return true;
            }
        }
        else if(type == "text/css")
        {
            if(child[i].readAttribute('id') == fileId)
            {
                return true;
            }
        }
    }

    return false;//if file is not loaded
}

function checkEnterPressed(e)
{
    if(window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }

    if(keynum == Event.KEY_RETURN)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function checkControlEnterPressed(e)
{
    var currentTime = new Date();
    var current = currentTime.getTime();

    if(window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }

    if(keynum == 17)
    {
        isCtrl = true;
        lastCtrlTime = current;
    }
    else if(keynum == Event.KEY_RETURN)
    {
        isKeyQ = true;
        lastQTime = current;
    }
    else
    {
        isCtrl = false;
        isKeyQ = false;
    }

    if(isCtrl && isKeyQ)
    {
        if((lastQTime > 0) && (lastCtrlTime > 0))
        {
            var difference = lastQTime - lastCtrlTime;

            if((difference < 1000) && (difference > 0))
            {
                return true;
            }
        }
    }

    return false;
}

function checkEscapePressed(e)
{
    if(window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }

    if(keynum == Event.KEY_ESC)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function e(s)
{
    return encodeURIComponent(s);
}

function d(s)
{
    return decodeURIComponent(s);
}

function loadToggle(con, action, params)
{
    if($(con).visible())
    {
        $(con).hide();
    }
    else
    {
        $(con).show();

        if($(con).innerHTML == '')
        {
            getSSContent(con, action, params);
        }
    }
}

function timeChooserAcco(hrComboId, minComboId)
{
    if(getComboVal(hrComboId) == "24")
    {
        $(minComboId).options[1].hide();
        $(minComboId).selectedIndex = 0;
    }
    else
    {
        $(minComboId).options[1].show();
    }
}

function replaceTextWithInput(conText, conInput)
{
    $(conText).hide();
    $(conInput).show();
    $(conInput).focus();
    $(conInput).select();
}

function replaceInputWithText(conText, conInput)
{
    $(conText).innerHTML = $F(conInput);
    $(conText).show();
    $(conInput).hide();
}

function pageRedi(link)
{
    window.location = link;
}

function showModal(link, w, h, modalTitle)
{
    Modalbox.show(link, {
        width: w,
        height: h,
        title: modalTitle
    });
}

function toggleSlide(con)
{
    if($(con).visible())
    {
        Effect.SlideUp(con);
    }
    else
    {
        Effect.SlideDown(con);
    }
}