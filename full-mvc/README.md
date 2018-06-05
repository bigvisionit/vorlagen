# Very Simple Full MVC

This is a simple MVC structure using in a small social application, to show how it works (for webprojects etc.).

### Version
1.0.0

### Structure


app

config controllers helpers libraries models views

and

bootstrap.php: includes config/config.php, helpers and libraries


public

index.php

index.php: includes bootstrap.php and calls the core class to build the application


### Example code to show a post

	URL: http://localhost/full-mvc/posts/show/{id}

	// Show Single Post
	// app/controllers/Posts.php
    public function show($id) {
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);

      $data = [
        'post' => $post, 
        'user' => $user
      ];

      $this->view($data);
    }
	
	// Get Post By ID
	// app/models/Post.php
	public function getPostById($id) {
      $row = $this->db->selectOne("* FROM posts WHERE id = :id", [ 'id' =>  $id]);
      return $row;
    }
	
	// Get User By ID
	// app/models/User.php
    public function getUserById($id) {
      $row = $this->db->selectOne("* FROM users WHERE id = :id", [ 'id' => $id ]);
      return $row;
    }
	
	// calls the view template with two parameters post and user
	// in app/views/skins/default/posts/show.php you can access the data with the $data array like this: $data['post'] and $data['user']
	$data = [
		'post' => $post, 
		'user' => $user
	];

	// show view and pass the data
	$this->view($data);