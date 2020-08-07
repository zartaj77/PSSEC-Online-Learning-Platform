	<input type="text" name="src" id="src" value=""  style="font-size: 10px; width: 100%;" readonly><!--hidden-->

<?php
/********************************************************************
 * openImageLibrary addon Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 ********************************************************************/

require('config.inc.php');
error_reporting(0);
// get the identifier of the editor
$wysiwyg = $_GET['wysiwyg']; 
// set image dir
$leadon = $rootdir.$imagebasedir;

if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

// validate the directory
$_GET['dir'] = $_POST['dir'] ? $_POST['dir'] : $_GET['dir'];
if($_GET['dir']) {
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}
	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
	}
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}

	if($_GET['dir'] == $leadon) {
		$dirok = false;
	}
	
	if($dirok) {
		$leadon = $_GET['dir'];
	}
}

// upload file
if($allowuploads && $_FILES['file']) {
    
		
	$upload = true;
	if(!$overwrite) {
	    $randomNo = substr(md5(time().$session_name),5);
	    $target_file = $leadon . "$session_name"."$randomNo".basename($_FILES['file']['name']);
		if(file_exists($target_file)) {
			$upload = false;
		}
	}
	$ext = strtolower(substr($target_file, strrpos($target_file, '.')+1));
	if(!in_array($ext, $supportedextentions)) {
		$upload = false;
	}
	if($upload) {
		move_uploaded_file($_FILES['file']['tmp_name'],$target_file);
		?>
		<script>
		    document.getElementById('src').value = '<?echo substr($target_file,6)?>'
		</script>
		<?
	}
}

if($allowuploads) {
	$phpallowuploads = (bool) ini_get('file_uploads');		
	$phpmaxsize = ini_get('upload_max_filesize');
	$phpmaxsize = trim($phpmaxsize);
	$last = strtolower($phpmaxsize{strlen($phpmaxsize)-1});
	switch($last) {
		case 'g':
			$phpmaxsize *= 1024;
		case 'm':
			$phpmaxsize *= 1024;
	}
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Insert Image</title>

<script type="text/javascript" src="../../scripts/wysiwyg-popup.js"></script>
<script language="JavaScript" type="text/javascript">

/* ---------------------------------------------------------------------- *\
  Function    : insertImage()
  Description : Inserts image into the WYSIWYG.
\* ---------------------------------------------------------------------- */
function insertImage() {
	var n = WYSIWYG_Popup.getParam('wysiwyg');
	
	// get values from form fields
	var src = document.getElementById('src').value;
	var alt = 'image';
	var width = '400'
	var height = '400'
	var border = ''
	var align = 'Middle'
	var vspace = ''
	var hspace = ''
	
	// insert image
	WYSIWYG.insertImage(src, width, height, align, border, alt, hspace, vspace, n);
  	window.close();
}

/* ---------------------------------------------------------------------- *\
  Function    : loadImage()
  Description : load the settings of a selected image into the form fields
\* ---------------------------------------------------------------------- */
function loadImage() {
	var n = WYSIWYG_Popup.getParam('wysiwyg');
	
	// get selection and range
	var sel = WYSIWYG.getSelection(n);
	var range = WYSIWYG.getRange(sel);
	
	// the current tag of range
	var img = WYSIWYG.findParent("img", range);
	
	// if no image is defined then return
	if(img == null) return;
		
	// assign the values to the form elements
	for(var i = 0;i < img.attributes.length;i++) {
		var attr = img.attributes[i].name.toLowerCase();
		var value = img.attributes[i].value;
		//alert(attr + " = " + value);
		if(attr && value && value != "null") {
			switch(attr) {
				case "src": 
					// strip off urls on IE
					if(WYSIWYG_Core.isMSIE) value = WYSIWYG.stripURLPath(n, value, false);
					document.getElementById('src').value = value.substring(2);
				break;
				case "alt":
					document.getElementById('alt').value = value;
				break;
				case "align":
					selectItemByValue(document.getElementById('align'), value);
				break;
				case "border":
					document.getElementById('border').value = value;
				break;
				case "hspace":
					document.getElementById('hspace').value = value;
				break;
				case "vspace":
					document.getElementById('vspace').value = value;
				break;
				case "width":
					document.getElementById('width').value = value;
				break;
				case "height":
					document.getElementById('height').value = value;
				break;				
			}
		}
	}
	
	// get width and height from style attribute in none IE browsers
	if(!WYSIWYG_Core.isMSIE && document.getElementById('width').value == "" && document.getElementById('width').value == "") {
		document.getElementById('width').value = img.style.width.replace(/px/, "");
		document.getElementById('height').value = img.style.height.replace(/px/, "");
	}
}

/* ---------------------------------------------------------------------- *\
  Function    : selectItem()
  Description : Select an item of an select box element by value.
\* ---------------------------------------------------------------------- */
function selectItemByValue(element, value) {
	if(element.options.length) {
		for(var i=0;i<element.options.length;i++) {
			if(element.options[i].value == value) {
				element.options[i].selected = true;
			}
		}
	}
}

</script>
</head>
<body bgcolor="#EEEEEE" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" onLoad="loadImage();">
<table border="0" cellpadding="0" cellspacing="0" style="padding: 10px;">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?wysiwyg=<?php echo $wysiwyg; ?>" enctype="multipart/form-data">
<input type="hidden" id="dir" name="dir" value="">
<tr>
<td style="vertical-align:top;">
<span style="font-family: arial, verdana, helvetica; font-size: 11px; font-weight: bold;">Insert Image:</span>
<table width="380" border="0" cellpadding="0" cellspacing="0" style="background-color: #F7F7F7; border: 2px solid #FFFFFF; padding: 5px;">
	<?php
	if($allowuploads) {
		if($phpallowuploads) {
		
	?>
		<tr>
			<td style="padding-top: 0px;padding-bottom: 0px; font-family: arial, verdana, helvetica; font-size: 11px;width:80px;">Upload:</td>
			<td style="padding-top: 0px;padding-bottom: 0px;width:300px;"><input type="file" name="file" size="30" style="font-size: 10px; width: 100%;" /></td>
		</tr>
		<tr>
			<td style="padding-top: 0px;padding-bottom: 2px;font-family: tahoma; font-size: 9px;">&nbsp;</td>
			<td style="padding-top: 0px;padding-bottom: 2px;font-family: tahoma; font-size: 9px;">(Max Filesize: <?php echo $phpmaxsize; ?>KB)</td>
		</tr>
	<?php
		}
		else {
	?>
		
	<?php
		}
	}
	?>
	
</table>
	

</td>

</tr>
<tr>
	<td colspan="2" align="right" style="padding-top: 5px;">
		<input type="submit" value="  Submit  " onclick="insertImage();return false;" style="font-size: 12px;">
		<?php if ( $allowuploads ) { ?> 
			<input type="submit" value="  Upload  " style="font-size: 12px;">
		<?php } ?> 		
		<input type="button" value="  Cancel  " onclick="window.close();" style="font-size: 12px;">	
	</td>
</tr>
</form>
</table>
</body>
</html>
