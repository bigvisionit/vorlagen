# Simple Database Class (PHP)

This is a small database class (using PDO).

### Version
1.0.0


### Example usages


$db = new Database;

// SELECT

$results = $db->select("* FROM user");

// SELECT ONE

$row = $db->selectOne("* FROM user WHERE id = :id", [ 'id' =>  $id]);

// INSERT

$inserted = $db->insertInto('user (name, email) VALUES (:name, :email)', [ 'name' => $name, 'email' => $email ]);


// UPDATE

$updated = $db->update('user SET name = :name, email = :email WHERE id = :id', [ 'name' => $name, 'email' => $email, 'id' => $id ]);


// DELETE

$deleted = $db->deleteFrom('user WHERE id = :id', [ 'id' => $id ]);