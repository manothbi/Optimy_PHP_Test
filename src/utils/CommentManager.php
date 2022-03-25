<?php
namespace App\Utils;

use App\Utils\DB;
use App\Class\Comment;

class CommentManager
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

	public function listComments()
	{
		$db = DB::getInstance();
		$rows = $db->Select("Select * from comment");

		$comments = [];
		foreach($rows as $row) {
			$n = new Comment();
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at'])
			  ->setNewsId($row['news_id']);
		}

		return $comments;
	}

	public function Insert($body = 'dshfksdgbfdksj', $news_id = '1')
	{
		$db = DB::getInstance();

		$id = $db->Insert("Insert into `comment`( `body` , `created_at`, `news_id`) values ( :body , :created_at, :news_id )", [
			 ':body' => $body,
			 ':created_at' => date('Y-m-d'),
			 ':news_id' => $news_id
	 ]);
	}

	public function remove($id)
	{
		$db = DB::getInstance();
		$db->Remove("Delete from comment where id = :id",[
        'id' => $id
    ]);
	}
}
