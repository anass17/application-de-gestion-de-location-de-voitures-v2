<?php

    class Validator {
        private $username;
        private $email;
        private $password;
        private $confirm_password;
        public $error;

        public function __construct($email, $password, $username = '', $confirm_password = '') {
            $this -> username = $username;
            $this -> email = $email;
            $this -> password = $password;
            $this -> confirm_password = $confirm_password;
            $this -> error = '';
        }

        public function isEmailValid($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            return true;
        }

        public function isPasswordValid($password) {
            if (!preg_match('/^.{8,}$/', $password)) {
                return false;
            }
            return true;
        }

        public function isUsernameValid($username) {
            if (!preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
                return false;
            }
            return true;
        }

        public function isPasswordConfirmed($pass, $pass_confirm) {
            if ($pass != $pass_confirm) {
                return false;
            }
            return true;
        }

        // Verify the data sent with Register form

        public function verifyRegister() {

            if (!$this -> isUsernameValid($this -> username)) {
                $this -> error = "Please enter a valid username";
                return false;
            }
            if (!$this -> isEmailValid($this -> email)) {
                $this -> error = "Please enter a valid email address";
                return false;
            }
            
            if (!$this -> isPasswordValid($this -> password)) {
                $this -> error = "Password must be at least 8 characters";
                return false;
            }

            if (!$this -> isPasswordConfirmed($this -> password, $this -> confirm_password)) {
                $this -> error = "The two passwords does not match";
                return false;
            }

            return true;
        }

        // Verify Login

        public function verifyLogin() {

            if (!$this -> isEmailValid($this -> email)) {
                $this -> error = "Incorrect email address or password";
                return false;
            }
            
            if (!$this -> isPasswordValid($this -> password)) {
                $this -> error = "Incorrect email address or password";
                return false;
            }

            return true;
        }
    }