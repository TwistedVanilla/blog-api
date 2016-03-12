<?php
    class BlogPost {
        private $title;
        private $post;
        private $dateMade;
        private $timeMade;
        
        public function __construct($title, $post, $dateMade, $timeMade) {
            $this->title = $title;
            $this->post = $post;
            $this->dateMade = $dateMade;
            $this->timeMade = $timeMade;
        }
        
        public function getTitle() {
            return $this->title;
        }
        
        public function getPost() {
            return $this->post;
        }
        
        public function getDateMade() {
            return $this->dateMade;
        }
        
        public function getTimeMade() {
            return $this->timeMade;
        }
    }
?>