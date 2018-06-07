<?php
  class Post {
    private $db;
    
    public function __construct() {
      $this->db = new Database;
    }

    // Get All Posts
    public function getPosts() {
      $results = $this->db->select("*, 
                        posts.id as postId, 
                        users.id as userId
                        FROM posts 
                        INNER JOIN users 
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC;");
      return $results;
    }

    // Get Post By ID
    public function getPostById($id) {
      $row = $this->db->selectOne("* FROM posts WHERE id = :id", [ 'id' =>  $id]);
      return $row;
    }

    // Add Post
    public function addPost($data) {
      $inserted = $this->db->insertInto('posts (title, user_id, body) 
      VALUES (:title, :user_id, :body)', [ 'title' => $data['title'], 'user_id' => $data['user_id'], 'body' => $data['body'] ]);
      return $inserted;
    }

    // Update Post
    public function updatePost($data) {
      $updated = $this->db->update('posts SET title = :title, body = :body WHERE id = :id', [ 'title' => $data['title'], 'body' => $data['body'], 'id' => $data['id'] ]);
      return $updated;
    }

    // Delete Post
    public function deletePost($id) {
      $deleted = $this->db->deleteFrom('posts WHERE id = :id', [ 'id' => $id ]);
      return $deleted;
    }
  }