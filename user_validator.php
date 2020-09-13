<?php

// Create a user validator class to handle validation
// Constructor which takes in POST data from form
// Check required 'fields to check' are present in the data
// create methods to validate individual fields
// -- a method to validate a username 
// -- a method to validate an email
// return an error array once all checks are done

class UserValidator{
  private $data;

  // Array that holds all the errors with there difinitions
  private $errors = [];

  // Input fields data
  private static $field = ['username', 'email'];

  public function __construct($post_data){
    $this->data = $post_data;
  }

  public function validateForm(){
    // if any of the fields does not exists
    // aka: username or/and email not defined
    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("$field is not present in data");
        return;
      }
    }

    $this->validateUsername();
    $this->validateEmail();
    return $this->errors;

  }

  private function validateUsername(){
    $val = trim($this->data['username']);

    if(empty($val)){
      $this->addError('username','username cannot be empty');
    } else {
      // Adding the Regular Expression that $val should match to pass
      if(!preg_match('/*[a-zA-Z0-9]{6,12}$/', $val)){
        $this->addError('username' . 'username must be 6-12 chars and aphanumeric');
      }
    }
  }
  
  private function validateEmail(){
    $val = trim($this->data['email']);
    if(empty($val)){
      $this->addError('email','email cannot be empty');
    } else {
      // Checking the email format
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email' . 'Please checkout the email format');
      }
    }
  }

  private function addError($key, $val){
    $this->errors[$key] = $val;
  }


}

?>