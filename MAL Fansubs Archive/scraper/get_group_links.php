<?php

require 'simple_html_dom.php';

$con = mysqli_connect("localhost", "root", "", "_mal_fansubs");    
$result = $con->query("SELECT * FROM 1_index WHERE status = 0");
while ($links[] = mysqli_fetch_array($result));

foreach ($links as $link) {
	$count = 0;

	if($link["link"] == NULL) continue;
    $letter = substr($link["link"], strpos($link["link"], "=") + 1);

    $response = file_get_contents($link["link"]);
    if($response === FALSE) continue;

    $html = (new simple_html_dom())->load($response);
    $rows = $html->find('table tr');

    foreach ($rows as $row) {
	    $name = htmlspecialchars_decode(trim($row->find('td')[0]->plaintext));
	    $shortname =  htmlspecialchars_decode(trim($row->find('td')[1]->plaintext));

	    if($name === "Name" && $shortname === "Short Name") continue;

	    $grouplink = trim($row->find('td a')[0]->href);
	    $groupid = substr($grouplink, strpos($grouplink, "=") + 1);

	    // $title = $html->find('span[itemprop=name]', 0)->plaintext;
	    // $category = htmlspecialchars_decode($html->find('div[id=pd-crumb-nav]', 0)->plaintext);
	    // $brand = $html->find('span[itemprop=brand]', 0)->plaintext;
	    // $brandURL = $html->find('div[id=pd-item-id] a img', 0)->src;
	    // $descText = $html->find('div[class=primaryProductDescription] p', 0)->plaintext;
	    // $descHTML = $html->find('div[class=primaryProductDescription] p', 0);

		mysqli_query($con, "SET NAMES utf8");
	    $con->query("INSERT INTO 2_group_links VALUES(NULL, '$letter', '$name', '$shortname', '$groupid', 0)");
	    $count++;
    }

	$con->query("UPDATE 1_index SET status = 1 WHERE id='" . $link["id"] . "'");
	echo "success ($count) : " . $letter . PHP_EOL;
}