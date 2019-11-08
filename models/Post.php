<?php
    class Post {
        private $conn;
        private $table = 'posts';

        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // constructor with db
        public function __construct($db) {
            $this->conn = $db;
        }

        // get posts
        public function read() {
            // query
            $query = 'SELECT c.name as category_name, 
            p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM ' . $this->table .' p 
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC';

            // prepared statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
        }  

        // get single post
        public function read_single() {
            $query = 'SELECT c.name as category_name, 
            p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM ' . $this->table .' p 
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE P.id = ?
            LIMIT 0,1';

            // prepared statement
            $stmt = $this->conn->prepare($query);

            //bind ID
            $stmt->bindParam(1, $this->id);

            // execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }
    }

?>