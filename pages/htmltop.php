<!-- ##################################### -->
<!-- ##   Groot Inlogsysteem versie 2   ## -->
<!-- ##     Copyright Jorik Berkepas    ## -->
<!-- ## Meer info? helpdesk90@gmail.com ## -->
<!-- ##################################### -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title><?= $sitenaam ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css" />

<script language="JavaScript" type="text/javascript">
<!--
function confirmLink(link, text) {
    if (typeof(window.opera) != 'undefined') {
        return true;
    }
    var is_confirmed = confirm(text);
    if (is_confirmed) {
        location.href = link;
    }
    return is_confirmed;
}

function addtext(veld, text) {
    text += ' ';
    if (document.form.elements[veld].createTextRange) {
        document.form.elements[veld].focus();
        document.selection.createRange().duplicate().text = text;
    } else {
        document.form.elements[veld].focus();
        document.form.elements[veld].value += text;
    }
}

//-->
</script>

</head>
<body>
