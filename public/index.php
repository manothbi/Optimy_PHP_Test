<?php

echo "<pre>";

if(file_exists($autoload = __DIR__.'/../vendor/autoload.php')){
	require_once($autoload);
}

use App\Utils\CommentManager, App\Utils\NewsManager;


CommentManager::getInstance()->remove(18);

foreach (NewsManager::getInstance()->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach (CommentManager::getInstance()->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}

$commentManager = CommentManager::getInstance();
$c = $commentManager->listComments();
