<?php
    /* Authors: TwistedVanilla */
    class BlogGenerator {
        private $db;
        private $postCreationError;
        private $blogID;
        private $title;
        private $description;
        private $dateMade;
        
        public function __construct($database) {
            if ($database instanceof PDO) {
                $db = $database;
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            else {
                throw new Exception("Please use a PDO database.");
            }
        }
        
        public function printAllPosts() {
            $rows = $this->getPosts();
            foreach ($rows as $row) {
                printPostSection($row['postID']);
            }
        }
        
        public function printPostSection($postID) {
            print("<section class='post'>");
            print("<h1>$title</h1>");
            print("<p>$dateMade</p>");
            print("<p>$description</p>");
            print("</section>");
        }
        
        public function printMostRecentPostSection() {
            $rows = $db->query("SELECT blogID, blogTitle, blogDescription, blogDateMade FROM `BlogPost` ORDER BY `BlogPost`.`blogDateMade` DESC");
            foreach ($rows as $row) {
                $this->title = $row['blogTitle'];
                $this->description = $row['description'];
                $this->dateMade = $row['blogDateMade'];
                
                $this->printPostSection($row['blogID']);
                break;
            }
        }
        
        public function printCreatePostSection() {
            $this->generateEditPostSection("Create");
        }
        
        public function validateCreatePostSection() {
            if (isset($_POST["submitted"])) {
                $titleError = "Please enter a title.";
                $postError = "Please enter a blog post.";
                $errorFound = false;
                $error = "";
                
                $title = $this->processUserInputtedText($_POST["title"]);
                $post = $this->processUserInputtedText($_POST["post"]);
                $dateMade = date("Y-m-d H:i:s");
                
                if (!empty($post)) {
                    $errorFound = true;
                    $error = $postError;
                }
                
                if (!empty($title)) {
                    $errorFound = true;
                    $error = $titleError;
                }
        
                if ($errorFound == false) {
                    if (postNewBlogPost($title, $description, $dateMade, $_SESSION['username'])) {
                        redirect("index.php");
                    }
                    else {
                        print("Blog post failed to be saved. Please try again later.");
                    }
                }
            }
        }
        
        public function printEditPostSection() {
            $this->generateEditPostSection("Edit");
        }
        
        private function getPost($postID) {
            return $db->query("SELECT * FROM BlogPost WHERE postID='$postID'");
        }
        
        private function getPosts() {
            return $db->query("SELECT * FROM BlogPost");
        }
        
        private function generateEditPostSection($title) {
            $postTitle = "$title"."_post";
            print("<section class='$title_post'>");
            print("<h1>$title a new blog post!</h1>");
            print('<form method="post" '); 
            print("action=".htmlspecialchars("$_SERVER[PHP_SELF]"));
            print('>');
            print("<label>Title: <input type='text' name='title' value='$this->title'/></label>");
            print("<label>Description: <textArea name='post' row=50 col=50>".$this->description."</textArea></label>");
            print("<label class='err'>".$this->error."</label>");
            print("<input type='submit'/>");
            print("<input type='hidden' name='submitted' value='true'/></form></section>");
        }
        
        private function postNewBlogPost($title, $description, $date, $creatorID) {
            $db->exec("INSERT INTO BlogPost(title, description, dateMade, creatorID) VALUES ($title, $description, $date, $creatorID)");
        }
        
        private function processUserInputtedText($text) {
            $text = trim($text);
            $text = htmlspecialchars($text);
            return $text;
        }
    }
?>