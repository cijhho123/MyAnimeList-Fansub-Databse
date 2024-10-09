<?php

error_reporting(0);
require 'simple_html_dom.php';

$con = mysqli_connect("localhost", "root", "", "_mal_fansubs");    
$result = $con->query("SELECT * FROM 2_group_links");
while ($links[] = mysqli_fetch_array($result));
$records = count($links) - 1;
$counter = 1;

foreach ($links as $link) {
	if($link == NULL) continue;
    $letter = $link["letter"];
    $groupid = $link["groupid"];

	echo "($counter/$records) $letter $groupid \n";
	$counter++;

    $response = file_get_contents("pages/" . $link["groupid"] . ".html");
    // $response = file_get_contents("https://myanimelist.net/fansub-groups.php?id=" . $groupid);
    // if($response === FALSE) continue;
    // file_put_contents("pages/" . $link["groupid"] . ".html", $response);


    $html = (new simple_html_dom())->load($response);
    $metadata = $html->find('table tbody tr td');
    $shows = $html->find('table tbody tr td div[style="border-width: 0; margin: 12px 0 0 0;"]');

    $stuff = trim(preg_replace('/\t+/', '', $metadata[0]->plaintext));
    $lines = explode("\n", $stuff);
    $votes = explode(' ', $lines[8]);

    $groupname = $link["name"];
    $shortname = $link["shortname"];
    $IRC = trim(str_replace("IRC", "", $lines[4]));
    $lang = trim(str_replace("Primary Language", "", $lines[6]));
    $approve = $votes[8];
    $disapprove = $votes[14];
    $total = $approve + $disapprove;
    $shows_subbed = count($shows);

    // echo " g_id: " . $groupid . PHP_EOL;
    // echo " name: " . $groupname . PHP_EOL;
    // echo "sname: " . $shortname . PHP_EOL;
    // echo "  IRC: " . $IRC . PHP_EOL;
    // echo " lang: " . $lang . PHP_EOL;
    // echo "shows: " . $shows_subbed . PHP_EOL . PHP_EOL;
    // echo "   approve: " . $approve . PHP_EOL;
    // echo "disapprove: " . $disapprove . PHP_EOL;
    // echo "     total: " . $total . PHP_EOL . PHP_EOL;

    $groupid  = mysqli_real_escape_string($con, $groupid);
    $groupname  = mysqli_real_escape_string($con, $groupname);
    $shortname  = mysqli_real_escape_string($con, $shortname);
    $IRC  = mysqli_real_escape_string($con, $IRC);
    $lang  = mysqli_real_escape_string($con, $lang);
    $total  = mysqli_real_escape_string($con, $total);
    $approve  = mysqli_real_escape_string($con, $approve);
    $disapprove  = mysqli_real_escape_string($con, $disapprove);
    $shows_subbed  = mysqli_real_escape_string($con, $shows_subbed);
    
    $sql = "INSERT INTO groups VALUES(NULL, '$groupid', '$groupname', '$shortname', '$IRC', '$lang', '$total', '$approve', '$disapprove', '$shows_subbed')";
	mysqli_query($con, "SET NAMES utf8");
    $con->query($sql);
    
    foreach ($shows as $show) {
		$showid = str_replace("/anime/", "", $show->children(0)->href);
		$showname = $show->children(0)->children(0)->plaintext;
		$details = $show->children(1)->children(0)->plaintext;	
		$show_approve = trim(explode(',', $show->children(2)->plaintext)[0]);	
        $total_users = explode(" of ", str_replace(" users approve", "", $show_approve))[1];
        $approve_users = explode(" of ", str_replace(" users approve", "", $show_approve))[0];
        $num_comments = str_replace(" comments", "", trim(explode(',', $show->children(2)->plaintext)[1]));	
		$comments = (new simple_html_dom())->load($show->children(3));	
			
        if($num_comments === "") $num_comments = "0";

    	// echo "   s_id: " . $showid . "\n";
    	// echo "   name: " . $showname . "\n";
    	// echo "details: " . $details . "\n";
     //    echo "appdump: " . $show_approve . "\n";
     //    echo "t_users: " . $total_users . "\n";
    	// echo "approve: " . $approve_users . "\n";
    	// echo "coments: " . $num_comments . "\n";

        $showid  = mysqli_real_escape_string($con, $showid);
        $showname  = mysqli_real_escape_string($con, $showname);
        $details  = mysqli_real_escape_string($con, $details);
        $approve_line  = mysqli_real_escape_string($con, $show_approve);
        $total_users  = mysqli_real_escape_string($con, $total_users);
        $approve_users  = mysqli_real_escape_string($con, $approve_users);
        $num_comments  = mysqli_real_escape_string($con, $num_comments);

	    $sql = "INSERT INTO shows VALUES(NULL, '$groupid', '$showid', '$showname', '$details', '$approve_line', '$total_users', '$approve_users', '$num_comments')";
		mysqli_query($con, "SET NAMES utf8");
	    $con->query($sql);

    	foreach ($comments->find('div.spaceit') as $comment) {
    		$show_comment = str_replace("&#039;", "'", $comment->plaintext);
    		$mood = $comment->style === "background-color: #f7e0e0;" ? "-" : "+";

	    	// echo "\tcomment: " . $show_comment . "\n";
	    	// echo "\tis ngtv: " . $mood . "\n";

            $show_comment  = mysqli_real_escape_string($con, $show_comment);
            $mood  = mysqli_real_escape_string($con, $mood);

            $sql = "INSERT INTO comments VALUES(NULL, '$groupid', '$showid', '$show_comment', '$mood')";
            mysqli_query($con, "SET NAMES utf8");
            $con->query($sql);
    	}
    
    	// echo "\n";
    }
}