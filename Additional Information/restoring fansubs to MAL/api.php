<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
if(!isset($_GET["id"])) die("bye");

$con = new mysqli("localhost", "user", "password", "database");
if(!$con) die("db error");

$id = mysqli_real_escape_string($con, $_GET["id"]);

$stmt = $con->prepare("SELECT * FROM shows WHERE showid = ? ORDER BY approve DESC");
$stmt->bind_param("s", $id);
$stmt->execute();

$shows = $stmt->get_result();
if($shows->num_rows === 0) exit('No subs available for this show.');

while($show = $shows->fetch_assoc()) {
	$stmt = $con->prepare("SELECT * FROM groups WHERE groupid = ?");
	$stmt->bind_param("s", $show['groupid']);
	$stmt->execute();

	$group = $stmt->get_result()->fetch_assoc();

	$approve_line = $show['approve_line'];
	$groupid = $show['groupid'];
	$showid = $show['showid'];

	$group_name = $group["groupname"];
	$group_shortname = $group["shortname"];
	$group_language = $group["language"];

	if($group_language === "English") 
		echo "<a href='https://www.google.com/search?q=anidb+$group_name' target='_blank'>$group_name</a> [$group_shortname] <span class='lightLink'>$approve_line</span>";
	else
		echo "<a href='https://www.google.com/search?q=anidb+$group_name' target='_blank'>$group_name</a> [$group_shortname] ($group_language) <span class='lightLink'>$approve_line</span>";

	$stmt = $con->prepare("SELECT * FROM comments WHERE groupid = ? AND showid = ? ORDER BY id");
	$stmt->bind_param("ss", $groupid, $showid);
	$stmt->execute();

	$comments = $stmt->get_result();

	if($comments->num_rows === 0) echo "<br><br>";
	else {
		echo " <a href='javascript:void(0)' class='commentToggle' id='$groupid'>" . $comments->num_rows . " comments</a><br><br><div id='comments$groupid' style='display: none;'>";

		while($comment = $comments->fetch_assoc()) {
			if($comment["color"] === "+")
				echo "<div class='bgColor1 spaceit'>" . $comment["comment"] . "</div>";
			else
				echo "<div class='bgColor1 spaceit' style='background-color: #f7e0e0;'>" . $comment["comment"] . "</div>";
		}

		echo "<br></div>";
	}
}

$stmt->close();
$con->close();