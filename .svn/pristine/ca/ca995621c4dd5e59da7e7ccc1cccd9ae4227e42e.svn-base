function getSelectedCheckbox(checkBoxName)
{
    var selected = new Array();
    var checkBoxes = $("input[name=" + checkBoxName + "]");

    $.each(checkBoxes, function()
    {
        if ($(this).is(':checked'))
        {
            selected[selected.length] = $(this).val();
        }

    });

    return selected;
}

function setText(txt, con)
{
    txt = txt.replace("<br />", "\\n");

    $("#" + con).val(txt);
}

function getCurrentUserTime()
{
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = currentDate.getMonth() + 1;
    var day = currentDate.getDate();
    var hour = currentDate.getHours();
    var minute = currentDate.getMinutes();
    var second = currentDate.getSeconds();

    return day + "-" + month + "-" + year + "-" + hour + "-" + minute + "-" + second;
}