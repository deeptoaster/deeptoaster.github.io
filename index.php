<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Deep Toaster</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="flaticon.css" type="text/css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Raleway:800|Titillium+Web:400,700" type="text/css" rel="stylesheet" />
		<style type="text/css">
			html {
				background-color: #161819;
			}
			body {
				margin: 0;
				font-size: 20px;
			}
			#header {
				position: fixed;
				z-index: 9;
				width: 100%;
				border-bottom: 1px solid #232627;
				background-color: #161819;
				background-color: rgba(22, 24, 25, 0.8);
			}
			h1, h3, .h1, .h3 {
				line-height: 1em;
				font-family: Raleway, sans-serif;
				text-transform: uppercase;
				letter-spacing: 0.2em;
			}
			h1, .h1 {
				font-size: 2em;
			}
			h3, .h3 {
				font-size: 1em;
			}
			#header .h1, #header .h3 {
				display: inline-block;
				margin: 0;
				color: #617078;
				text-decoration: none;
			}
			#header .h1 {
				padding: 0.5em;
			}
			#header .h3 {
				padding: 1.5em 1em;
			}
			.pull-right {
				float: right;
			}
			#breakout {
				padding-top: 4em;
				padding-bottom: 2em;
				font-size: 1.5em;
			}
			.breakout {
				position: relative;
				width: 24em;
				height: 12em;
				margin: auto;
				border: 1px solid #617078;
				padding: 0.1em;
				background-color: #232627;
			}
			.breakout ul {
				list-style-type: none;
				height: 1em;
				margin: 0;
				padding: 0.1em 0;
				line-height: 1em;
			}
			.breakout li {
				display: inline-block;
				position: relative;
				width: 2em;
				height: 1em;
			}
			.breakout .breakout-red li {
				background-color: #8f280d;
			}
			.breakout .breakout-orange li {
				background-color: #8f480d;
			}
			.breakout .breakout-yellow li {
				background-color: #8f5c0d;
			}
			.breakout .breakout-green li {
				background-color: #8f6b0d;
			}
			.breakout li::before, .breakout li::after {
				display: block;
				position: absolute;
				content: '';
				width: 0.1em;
				height: 1em;
				background-color: #232627;
			}
			.breakout li::after {
				right: 0;
			}
			.breakout .breakout-paddle {
				position: absolute;
				right: 0;
				bottom: 0;
				left: 0;
				overflow: auto;
			}
			.breakout .breakout-paddle span {
				display: block;
				width: 500%;
				height: 1px;
			}
			.breakout input {
				position: absolute;
			}
		</style>
	</head>
	<body>
		<div id="header">
			<div class="pull-right">
				<a class="h3" href="/blog/">Blog</a>
				<a class="h3" href="/resume/">Resume</a>
			</div>
			<a class="h1" href="/">Deep Toaster</a>
		</div>
		<div id="breakout" class="section">
			<div class="breakout">
				<ul class="breakout-red"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
				<ul class="breakout-orange"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
				<ul class="breakout-yellow"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
				<ul class="breakout-green"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
				<div class="breakout-paddle">
					<span />
				</div>
				<input type="radio" checked="checked" />
			</div>
		</div>
	</body>
</html>

