<?php
    class Util {
        // Method for input value sanitization
        public function testInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = strip_tags($data);

            return $data;
        }
        // Method for displaying success and error messages
        public function showMessage($type, $message) {
            return '<div class="alert alert-'.$type.' alert-dismissible show" role="alert">
            <strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">X</button>
            </div>';
        }
    }