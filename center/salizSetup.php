<?php

include 'SalizDatabaseManager.php';

$db = new SalizDatabaseManager();

$category = $db->createCategoryTable();
$posts = $db->createPostsTable();
$times = $db->createOpenTimesTable();
$reserve = $db->createReserveTable();
$users = $db->createUserTable();
$services = $db->createServicesTable();
$banner = $db->createBannerTable();

echo $category;
echo "<br><br>";
echo $posts;
echo "<br><br>";
echo $times;
echo "<br><br>";
echo $reserve;
echo "<br><br>";
echo $users;
echo "<br><br>";
echo $services;
echo "<br><br>";
echo $banner;

