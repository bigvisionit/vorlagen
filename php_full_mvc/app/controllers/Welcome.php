<?php
  class Welcome extends Controller {
    public function __construct() {
      parent::__construct();
      if(isset($_SESSION['user_id'])) {
        redirect('posts');
      }
    }

    public function index() {
      $this->view(['title' => 'Welcome'],[],'welcome');
    }
  }