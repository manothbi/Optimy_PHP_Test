<?php
namespace App\Utils;

use App\Utils\DB;
use App\Utils\CommentManager;
use App\Class\News;

class NewsManager
{
	private static $instance = null;


	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	/**
	* list all news
	*/
	public function listNews()
	{
		$db = DB::getInstance();
		$rows = $db->Select("Select * from news");

		$news = [];
		foreach($rows as $row) {
			$n = new News();
			$news[] = $n->setId($row['id'])
			  ->setTitle($row['title'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at']);
		}

		return $news;
	}

	/**
	* add a record in news table
	*/
	public function Insert($title, $body)
	{
		$db = DB::getInstance();

		$id = $db->Insert("Insert into `news`( `title` , `body`, `created_at`) values ( :title , :body, :created_at )", [
        ':title' => $title,
        ':body' => $body,
				'created_at' => date('Y-m-d')
    ]);
	}

	/**
	* deletes a news, and also linked comments
	*/
	public function remove($id)
	{
		$comments = CommentManager::getInstance()->listComments();
		$idsToDelete = [];

		foreach ($comments as $comment) {
			if ($comment->getNewsId() == $id) {
				$idsToDelete[] = $comment->getId();
			}
		}

		foreach($idsToDelete as $id) {
			CommentManager::getInstance()->remove($id);
		}

		$db = DB::getInstance();
		$db->Remove("Delete from news where id = :id",[
        'id' => $id
    ]);
	}
}
