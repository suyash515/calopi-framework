function getSSContent1(module, action, folder, container, params)
{
    var processUrl = "";

    if(folder != "")
    {
        processUrl = websiteUrl + folder + "/" + module + "/" + action;
    }
    else
    {
        processUrl = websiteUrl + module + "/" + action;
    }

    $("#" + container).load(processUrl, params);
}

function getSSContent(module, action, folder, container, params)
{
    var imageSrc = imageFolder + "loader.gif";

    $("#" + container).html("<div style='width: 100%;text-align: center;' id='loadingspin'><img src='" + imageSrc +"' title='loading' alt='loading' /></div>");

    var processUrl = "";

    if(folder != "")
    {
        processUrl = websiteUrl + folder + "/" + module + "/" + action;
    }
    else
    {
        processUrl = websiteUrl + module + "/" + action;
    }

    $("#" + container).load(processUrl, params);
}