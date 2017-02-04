function showError(message)
{
    $("#validate-info").addClass("alert alert-danger").html(message);
}

function showWarning(message)
{
    $("#validate-info").addClass("alert alert-warning").html(message);
}

function hideError()
{
    $("#validate-info").removeClass("alert alert-danger").html("");
}

function hideWarning()
{
    $("#validate-info").removeClass("alert alert-warning").html("");
}

function roundTwoDecimals(numberToRound)
{
    var roundedNumber = 0;
    
    roundedNumber = Math.round(numberToRound * 100) / 100

    return roundedNumber;
}