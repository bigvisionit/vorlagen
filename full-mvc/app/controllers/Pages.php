<?php
  class Pages extends Controller {
    public function __construct() {
      parent::__construct();
    }
    
    public function index() {
      $data = [
        'title' => APP_NAME,
        'description' => 'Test description'
      ];
      $this->view($data);
    }

    public function about() {
      $data = [
        'version' => '1.0.0'
      ];
      $this->view($data);
    }
  }