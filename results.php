<?php

// Save in file dbcon.ini:
// [roster_connection]
// thishost = "host_name"
// db_title = "database_name"
// db_table = "table_name"
// user = "user"
// pass = "pass"

$dbcon = parse_ini_file('conf/dbcon.ini');

$sort = "page";
$sort_criteria = "page";
$search_criteria = array();
$searchterm_exists = false;
$sort_exists = false;
$nothing_to_search = false;
$message = "";
$no_results = false;
$max_per_page = 20;
$max_rows = 1000;
$start = 1;
$end = $start + ($max_per_page - 1);
$prev_start = 1;
$next_start = $start + $max_per_page;
$num_rows = array();

require 'paginator.class.php';

if (!empty($_POST['searchterm']) || !empty($_GET['searchterm'])) {
	$searchterm_exists = true;
	$searchterm = !empty($_POST['searchterm']) ? substr($_POST['searchterm'],0,50) : substr($_GET['searchterm'],0,50);
	if (preg_match('/[^a-zA-Z0-9 ]/', $searchterm)) { exit; }
	//$searchterm_criterion = "text LIKE '%" . $searchterm . "%'";
	
	//array_push($search_criteria, $searchterm_criterion);
}

if (!empty($_POST['start']) || !empty($_GET['start'])) {
	$start = !empty($_POST['start']) ? substr($_POST['start'],0,10) : substr($_GET['start'],0,10);
	if (preg_match('/[^\d]/', $start)) { exit; }
} 

if (!$searchterm_exists) { 
	$nothing_to_search = true;
	$message = "Need something to search";
}

//$statement = "SELECT * FROM " . $db_table . " WHERE ";

// select count(*), match(text) against('williamson') as score from roster where match(text) against('williamson')
$statement = "SELECT *, MATCH(pagetext) AGAINST ('" . $searchterm . "' IN BOOLEAN MODE) AS score FROM " . $dbcon['db_table'] . " WHERE MATCH(pagetext) AGAINST('" . $searchterm . "' IN BOOLEAN MODE)";
$pages = new Paginator;
$criteria_total = count($search_criteria);
if (!$nothing_to_search) {
	
	$count_statement = preg_replace('/\*/','count(*)',$statement);
	try {
		
		$db = new PDO('mysql:host='.$dbcon['thishost'].';dbname='.$dbcon['db_title'].';charset=utf8', $dbcon['user'], $dbcon['pass']);  
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$num_rows[0] = $db->query($count_statement)->fetchColumn();
		if ($num_rows[0] < 1) { $no_results = true; }
		$pages->items_total = $num_rows[0];
		$pages->mid_range = 5;
		$pages->paginate();
		
		//$statement .= " ORDER BY " . $sort_criteria . " " . $pages->limit;
		$statement .= " " . $pages->limit;
		
		$db = new PDO('mysql:host='.$dbcon['thishost'].';dbname='.$dbcon['db_title'].';charset=utf8', $dbcon['user'],  $dbcon['pass']);
		$results = $db->query($statement);
		$db = null;
		
	} catch(PDOException $e) {  
		print($e->getMessage());
		die();
	}
	
}

?>

<!doctype html public 
  "-//w3c//dtd html 4.01 transitional//en"
  "http://www.w3.org/tr/1999/rec-html401-19991224/loose.dtd">
<html>
<head>
<title>Hayes Diary Search Results</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/json2/20121008/json2.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jStorage/0.3.0/jstorage.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.6.0/jquery.selectBoxIt.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.6.0/jquery.selectBoxIt.min.js"></script>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.js"></script>

<script type="text/javascript" src="formly/formly.js"></script>
<link rel="stylesheet" href="formly/formly.css" type="text/css" />

<style type="text/css">

body {
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
}

.paging-section {
	text-align:center;
	padding:6px;
	height: 30px;
}
	
.paginate {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
}

a.paginate {
	border: 1px solid #000080;
	padding: 2px 6px 2px 6px;
	text-decoration: none;
	color: #000080;
}

a.paginate:hover {
	background-color: #000080;
	color: #FFF;
	text-decoration: underline;
}

a.current {
	border: 1px solid #000080;
	font: bold .7em Arial,Helvetica,sans-serif;
	padding: 2px 6px 2px 6px;
	cursor: default;
	background:#000080;
	color: #FFF;
	text-decoration: none;
}

span.inactive {
	border: 1px solid #999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	padding: 2px 6px 2px 6px;
	color: #999;
	cursor: default;
}

a.navlinks {
	text-decoration:none;
}
a.navlinks:hover {
	color: red;
	text-decoration: underline;
}

div.jGrowl div.resultsAlerts {
	background-color: #808080;
	width: 200px;
	min-height: 0px;
	border: 1px solid #000;
}

</style>

<script type="text/javascript">	
	$(document).ready(function() {
		$('#searchResults').formly(); 		
	});	
</script>

	
</head>
<body>

<div style="text-align:center;padding:20px;">
	<a class="navlinks" href="index.php">Hayes Diary Search Home</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a class="navlinks" href="http://www.ohiohistory.org/collections--archives/archives-library">Library/Archives Home</a>
</div>
 	
<div class="paging-section">
	<?php echo $pages->display_pages(); ?>
</div>

<br/>

<?php
	echo( '<div style="width:100%">' );
	echo( '<form id="searchResults">' );
	//echo( '<br/>' );
	if ($nothing_to_search) {
		echo("<p>".$message."</p>");
	} else if ($no_results) { 
		echo("<p>No results.</p>");
	} else {
		
		while($row = $results->fetch(PDO::FETCH_ASSOC)) {
			$volume_text = $row['volumetext'];
			$chapter_text = $row['chaptertext'];
			$page_html = $row['pagetext'];
			$searchterms = explode(" ", $searchterm);
			
			foreach ($searchterms as $st) {
				//echo("-- " .$st . " " . "<b>".$st."</b> --");
				if (preg_match('/'.$st.'/si',$page_html, $matches) < 1) { continue; };
				$page_html = preg_replace('/'.$st.'/si','<span style="color:#cc0000;font-weight:bold">'.$matches[0].'</span>',$page_html);
			}
			//echo( '<label for="result-'.$row['page'].'">' . $row['page'] );
			//echo( '<span style="white-space: normal; font-size:80%">' );

			//echo( (trim($page_html) != "") ? $page_html : "n/a" );
			echo( $volume_text . ", " . $chapter_text );
			echo( "<pre>" );
			echo( $page_html );
			echo( "</pre>" );
			
			echo( "</span>" );
			//echo( '</label><br/>' );
			echo( '<hr style="height:4px;background-color:#999999;color:#999999">' );
			
		}
		
	}
	echo( '</form>' );
	echo( '<form id="searchVals" action="results.php" method="post">' );
	echo( '<input type="hidden" name="searchterm" value="'.($searchterm_exists ? $searchterm : "").'">' );
	echo( '<input type="hidden" name="sort" value="'.($sort_exists ? $sort : "").'">' );
	echo( '<input type="hidden" name="start" value="'.$start.'">' );
	echo( '</form>' );
	echo( '</div>' );	
?>

<div style="text-align:center;padding:6px; height: 30px;margin-top:10px;">
   	<?php echo $pages->display_pages(); ?>
    <br/>&nbsp;<br/><a href="index.php">Hayes Diary Search Home</a><br/>
</div> 
	
  </body>
</html>

