<?php

class Articles_Model
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
  
    public function get_all_articles()
    {
		$query = $this->db->query('SELECT * FROM articles');
		$all_articles = $query->fetchAll();
		return $all_articles;
    }

    public function get_article($slug)
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE slug = ?');
        $query->bindValue(1, $slug);
        $query->execute();
        $article = $query->fetch();
        return $article;
    }

    public function search($word)
    {
        $query = $this->db->query('SELECT * FROM articles WHERE title LIKE \'%'.$word.'%\';');
        $search = $query->fetchAll();
        return $search;
    }

    public function add_element(){
        $prepare = $pdo->prepare("INSERT INTO articles (title, preview, picture, slug, content) VALUES (:title, :preview, :picture, :slug, :content)");
        $prepare->bindValue(':title',$_POST['title']);
        $prepare->bindValue(':preview',$_POST['preview']);
        $prepare->bindValue(':picture',$_POST['picture']);
        $prepare->bindValue(':slug',$_POST['slug']);
        $prepare->bindValue(':content',$_POST['content']);
        $send = $prepare->execute();
    }

    public function update_element(){
        $prepare = $pdo->prepare("UPDATE `articles` SET `title`=:title,`preview`=:preview,`picture`=:picture,`slug`=:slug, `content`=:content WHERE 1");
        $prepare->bindValue(':title',$_POST['title']);
        $prepare->bindValue(':preview',$_POST['preview']);
        $prepare->bindValue(':picture',$_POST['picture']);
        $prepare->bindValue(':slug',$_POST['slug']);
        $prepare->bindValue(':content',$_POST['content']);
        $query = $prepare->execute();
    }

    public function delete_element(){
        $delete = $pdo->prepare('DELETE FROM articles WHERE `id`=:id');
        $delete->bindValue(':id',$_POST['deleteelement']);
        $delete->execute();
    }

}