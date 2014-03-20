var websiteAddress = "";

/* ########### */
/*    ajax    */
/* ########## */

function getSSContent(action, container, params)
{
    var imageSrc = imageFolder + "spinner.gif";

    $("#" + container).html("<div style='width: 100%;text-align: center;' id='loadingspin'><img src='" + imageSrc +
	    "' title='loading' alt='loading' /></div>");

    var processUrl = websiteUrl + "process.php?action=" + action;

    $("#" + container).load(processUrl, params);
}


function getSSContent2(element, action, params)
{
    // $(element).innerHTML = "<img src=\"" + imageFolder + "spinner.gif\">";
    $(element).innerHTML = "<img src=\"images/spinner.gif\">";

    reportError = function() {
	$(element).innerHTML = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr><td>An error has occurred! Please try again.</td></tr></table>";
    };

    var myAjax = new Ajax.Updater(
	    {
		success: element
	    },
    websiteAddress + 'process.php',
	    {
		method: 'post',
		parameters: 'action=' + action + '&' + params,
		evalScripts: true,
		onFailure: reportError
	    });
}

function getPeriodUpdateForClass(element, action, params, freq)
{
    $(element).innerHTML = "<img src=\"" + imageFolder + "class_loader.gif\">";

    reportError = function() {
	$(element).innerHTML = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr><td>An error has occurred!.</td></tr></table>";
    };

    var myAjax = new Ajax.PeriodicalUpdater(
	    {
		success: element
	    },
    websiteAddress + 'process.php',
	    {
		method: 'post',
		parameters: 'action=' + action + '&' + params + "&date=" + $("txt_hid_class_date").value,
		evalScripts: true,
		onFailure: reportError,
		frequency: freq,
		onsuccess: function(response) {
		    addClassMessageNode(response.responseText);
		}

	    });
}
