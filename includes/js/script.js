// JavaScript Document

//GLOBAL VARIABLES
var mainContent = "content";

/* ########### */
/*    ajax    */
/* ########## */

function getSSContent(element, action, params)
{
    $(element).innerHTML = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr><td><img src=\"./images/spinner.gif\"></td></tr></table>";

    reportError = function(){
        $(element).innerHTML = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr><td>An error has occurred!</td></tr></table>";
    };

    var myAjax = new Ajax.Updater(
    {
        success: element
    },
    './process.php',
    {
        method: 'post',
        parameters: 'action=' + action + '&' + params,
        evalScripts: true,
        onFailure: reportError
    });
}


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
} // Ends the "getSelectedCheckbox" function

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
} // Ends the "getSelectedCheckBoxValue" function

function changeNav(navToChange)
{
    var childElements = $(nav).childElements();

    for(var i=0;i<childElements.length;i++)
    {
        childElements[i].className = '';
    }

    $(navToChange).className = 'current_page_item';
}

function toggleItem(item)
{
    if($(item).visible())
    {
        $(item).hide();
    }
    else
    {
        $(item).show();
    }
}

function convertAmpersand(text)
{
    text.replace("&", "amp;");
}

function checkSubmitLogin(e)
{
    if(checkEnterPressed(e))
    {
        login('txtUsername', 'txtPassword');
    }
    else if(checkEscapePressed(e))
    {
        $('txtUsername').value = "";
        $('txtPassword').value = "";

        $('txtUsername').focus();
    }
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

/* ############# */
/*  application  */
/* ############# */

function generateStructure()
{
    var directory = $F('txt_directory');
    var host = $F('txt_host');
    var url = $F('txt_url');
    var database = $F('txt_db_name');
    var user = $F('txt_user');
    var password = $F('txt_password');

    var params = "directory=" + directory + "&host=" + host + "&url=" + url + "&database=" + database + "&user=" + user + "&password=" + password;

    getSSContent(mainContent, "generateStructure", params);
}