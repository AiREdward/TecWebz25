<?php
require_once 'models/User.php';

class AdminController {
    public function invoke() {
        $this->listUsers();
    }

    public function listUsers() {
        $users = User::getAllUsers();
        include 'test/admin.php';
    }
}
?>
