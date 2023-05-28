<?php

class Book
{
    // connection
    private $conn;
    //Table
    private $db_table = "book";

    // columns
    public $id;
    public $name;
    public $author;
    public $pages;
    public $copies;


    // database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // get All book
    public function getBook()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $st = $this->conn->prepare($sqlQuery);
        $st->execute();
        echo "test";
        return $st;
    }


    ///////////////////////
    //REDE single
    public function getSingleBook($id)
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "WHERE id =?";
        $st = $this->conn->prepare($sqlQuery);
        $st->bind_param("i", $id);
        $st->execute();
        $result = $st->get_result();
        $book = $result->fetch_assoc();
        return $book;
    }

    ////////////////////////////
    //CREAT

    public function creatBook($name, $author, $pages, $copies)
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "(name, author, pages,copies) VALUES (?, ?, ?, ?) ";
        $st = $this->conn->prepare($sqlQuery);

        // sanitize data
        $name = htmlspecialchars(strip_tags($name));
        $author = htmlspecialchars(strip_tags($author));
        $pages = htmlspecialchars(strip_tags($pages));
        $copies = htmlspecialchars(strip_tags($copies));


        // bind data    
        $st->bind_param(
            "ssii",
            $name,
            $author,
            $pages,
            $copies
        );
        if ($st->execute()) {
            return true;
        } else {
            return false;
        }
    }



    //////////////////////////
    // UPDATE
    public function updateBook($id, $name, $author, $pages, $copies)
    {
        $sqlQuery = "UPDATE " . $this->db_table . "SET
       name = ?, author = ?, pages = ?, copies = ?
       WHERE id = ? ";

        $st = $this->conn->prepare($sqlQuery);
        // sanitize data
        $name = htmlspecialchars(strip_tags($name));
        $author = htmlspecialchars(strip_tags($author));
        $pages = htmlspecialchars(strip_tags($pages));
        $copies = htmlspecialchars(strip_tags($copies));

        // bind data    
        $st->bind_param(
            "ssii",
            $name,
            $author,
            $pages,
            $copies,
            $id
        );
        if ($st->execute()) {
            return true;
        } else {
            return false;
        }
    }
    /////////////////////
    //DELETE
    public function deleteBook($id)
    {
        $sqlQuery = "DELETE " . $this->db_table . "WHERE id = ?";
        $st = $this->conn->prepare($sqlQuery);
        // sanitize data
        $id = htmlspecialchars(strip_tags($id));
        $st->bind_param("i", $id);

        if ($st->execute()) {
            return true;
        } else {
            return false;
        }
    }
}