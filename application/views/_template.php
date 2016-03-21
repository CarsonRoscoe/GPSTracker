<!--
FILE: _template.php
 
DATE: March 10th, 2016
 
REVISIONS: March 20th, 2016: Commented

@programmer: Carson Roscoe

@designer: Carson Roscoe
 
NOTES: Our websites template. Every single page uses this as their packet.
The {tag}'s will be replaced with generated HTML from the proper controller.
-->
<!DOCTYPE html>
<html>
	<head>
		<title id="pageTitle">{pagetitle}</title>
		<meta charset="UTF-8" />
		<link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="header">
			<h1 id="pageHeader">{pageheader}</h1>		
		</div>	
		<div id="navigation">
			{navigation}
		</div>
		<div id="content">
			<table id="titleTable">
                            <tr>
                                <td><h1>{contentTitle} {dropdownlist}</h1></td>
                            </tr>
                        </table>
                        <div id="contentDiv">
                                {content} 
                        </div>
		</div>
	</body>
</html>