<!doctype html public 
  "-//w3c//dtd html 4.01 transitional//en"
  "http://www.w3.org/tr/1999/rec-html401-19991224/loose.dtd">
<html> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
<title>1812 War Roster Search</title>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.js"></script>

<script type="text/javascript" src="formly/formly.js"></script>
<link rel="stylesheet" href="formly/formly.css" type="text/css" />

<script type="text/javascript">
	
	$(document).ready(function() {		
		$('#searchform').formly(); 
	});
	
	function validateForm() {

		var searchtermExists = /[A-Na-n]/.test(document.forms["searchform"]["searchterm"].value);
		
		if (!searchtermExists) {
			$.jGrowl("Need something to search", { theme: 'validation', header: 'Search Error', live: 10000 });
			return false;
		}
		
	}
</script>
<style type="text/css">
body {
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
}
.heading {
	text-align:center;
	font-size:120%;padding:20px;
}
.backto {
	text-align:center;
	padding:10px;
}
a.navlinks {
	text-decoration: none;
}
a.navlinks:hover {
	color: red;
	text-decoration: underline;
}
div.jGrowl div.validation {
	background-color: #808080;
	width: 200px;
	min-height: 0px;
	border: 1px solid #000;
}

</style>
</head> 
<body>
		
	<div class="backto"><a class="navlinks" href="http://www.ohiohistory.org/collections--archives/archives-library">Library/Archives Home</a></div>
	<div class="heading">Hayes Diary Search</div>
	
	<div style="width:100%">
	
	<form id="searchform" name="searchform" action="results.php" method="POST" onsubmit="return validateForm()"  style="width: 500px;margin: 0 auto">
	
		<br/>Search a name or keyword: <input type="search" name="searchterm" size="25" maxsize="50">

		<br/><input type="submit" value="Search" />
		
	</form>

<div style="width:500px;margin: 0 auto;">
<p>Rutherford B. Hayes kept a diary from age twelve to his death at age
70 in 1893. He was one of only three presidents to keep a diary while in
office. The edited diaries and letters were published in 1922 as a set
of five volumes, <I>The Diary and Letters of Rutherford B. Hayes, Nineteenth
President of the United States,</I> edited by Charles Richard Williams
(Columbus, Ohio: Ohio State Archeological and Historical Society, 1922).
These 3000 pages of text have been digitized and are now available on the
Web for students, scholars, and anyone interested in Hayes and the social
and political history of his time period. Researchers can search by volume and keyword
or browse through the 5 volumes page by page. Please remember this digitized publication
is only a small part of what is available on President Hayes. Be sure to
contact the Hayes Presidential Library for additional information</p>

<div class="heading">Browse the Diary Volumes</div>

<A HREF="browse/volume01.html">Volume I</A> &nbsp;&nbsp;&nbsp;

<A HREF="browse/volume02.html">Volume II</A> &nbsp;&nbsp;&nbsp;

<A HREF="browse/volume03.html">Volume III</A> &nbsp;&nbsp;&nbsp;

<A HREF="browse/volume04.html">Volume IV</A> &nbsp;&nbsp;&nbsp;

<A HREF="browse/volume05.html">Volume V</A> 

<P><A HREF="quotes.html">Memorable quotes from the Diary and Letters</A></P>



		<P><A HREF="rdbltr.html">Importance of

		the Diary and Letters</A></P>



		<P><A HREF="more.html">How to find more of Hayes' diaries and letters</A></P>



		<P><A HREF="credits.html">Acknowledgments and credits</A></P>



		<P>Send an e-mail to the Hayes Presidential Library: <A HREF="mailto:hayeslib@rbhayes.org">hayeslib@rbhayes.org</A></P>


		<P>&nbsp;</P>



		<CENTER><P>This information may be used freely for educational purposes.</P></CENTER>



		<CENTER><P><B>[<A HREF="http://www.rbhayes.org/">Hayes Home</A> | <A HREF="http://www.rbhayes.org/hayes/museum">Museum</A>

| <A HREF="http://www.rbhayes.org/hayes/library">Library</A> | <A HREF="http://www.rbhayes.org/hayes/manuscripts/">Archives</A>

| <A HREF="http://www.rbhayes.org/hayes/president/">Biography</A>]</B></P></CENTER>



		<CENTER><P><B>[<A HREF="http://www.rbhayes.org/hayes/join/">Membership</A> | <A HREF="http://www.rbhayes.org/hayes/store">Store</A>

| <A HREF="http://www.rbhayes.org/hayes/happenings/">Calendar</A> ]</B></P></CENTER>



		<CENTER><P>return to <B><A HREF="http://www.rbhayes.org/">Home </A></B>page</P></CENTER>



		<CENTER><P>visit <A HREF="http://www.ohiohistory.org">The Ohio History Connection</A></P></CENTER>



		<CENTER><P>

		<HR WIDTH="97%"></P></CENTER>



		<CENTER><P><IMG SRC="images/logo.gif" NATURALSIZEFLAG="3" HEIGHT=154 WIDTH=245 ALIGN=BOTTOM></P></CENTER>



		<CENTER><P>Rutherford B. Hayes Presidential Center<BR>

		Spiegel Grove<BR>

		Fremont, Ohio, 43420<BR>

		USA </P></CENTER>

</div>

</div>


</body>
</html>