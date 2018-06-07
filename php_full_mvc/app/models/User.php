<?php
  class User {
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    // Add User / Register
    public function register($data) {
      $inserted = $this->db->insertInto('users (name, email,password) 
      VALUES (:name, :email, :password)', [ 'name' => $data['name'], 'email' => $data['email'], 'password' => $data['password'] ]);
      return $inserted;
    }

    // Find USer BY Email
    public function findUserByEmail($email) {
      $row = $this->db->selectOne("* FROM users WHERE email = :email", [ 'email' => $email ]);
      if($this->db->count() > 0) {
        return true;
      } else {
        return false;
      }
    }

    // Login / Authenticate User
    public function login($email, $password) {
      $row = $this->db->selectOne("* FROM users WHERE email = :email", [ 'email' => $email ]);
      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)) {
        return $row;
      } else {
        return false;
      }
    }

    // Find User By ID
    public function getUserById($id) {
      $row = $this->db->selectOne("* FROM users WHERE id = :id", [ 'id' => $id ]);
      return $row;
    }
  }