<?php
    class BlogGenerator {
        private $blogName;
        private $db;
        
        public function __construct($blogName, $database) {
            if (is_a($database, "PDO")) {
                $db = $database;
            }
            else {
                throw new InvalidPDODatabaseException("Please use a valid PDO database.");
            }
        }
        
        public function printAllPosts() {
            $rows = $this->getPosts();
            foreach ($row in $rows) {
                printPostSection($row['postID']);
            }
        }
        
        public function printPostSection($postID) {
            print("<section class='post'>");
            print("<h1>title</h1>");
            print("<h2>time: date</h2>");
            print("<p>description</p>");
            print("</section>");
        }
        
        public function printCreatePostSection() {
            generateEditPostSection("Create");
        }
        
        public function validateCreatePostSection() {
            
        }
        
        public function printEditPostSection() {
            $this->generateEditPostSection("Edit");
        }
        
        private function getPost($postID) {
            return $db->query("SELECT * FROM Posts WHERE postID='$postID'");
        }
        
        private function getPosts() {
            return $db->query("SELECT * FROM Posts");
        }
        
        private function generateEditPostSection($title) {
            $postTitle = "$title"."_post";
            print("<section class="$title_post">);
        }
    }
?>