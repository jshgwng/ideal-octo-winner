<?php

class User 
{
    private $db;
    private $payload;
    private $validator;
    private $obj;

    public function __construct($db, $payload, $validator, $obj)
    {
        $this->db = $db;
        $this->payload = $payload;
        $this->validator = $validator;
        $this->obj = $obj;
    }

    /**
     * Example API: login a user
     * @return json
     */
    public function login_user()
    {
        /**
         * validate json payload
         */
        $validation = $this->validator->make($this->payload, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            echo json_encode($errors->firstOfAll(), JSON_PRETTY_PRINT);
            exit();
        }

        /**
         * check if user exists in user table
         */
        $email = $this->payload["email"];
        $user = $this->db->where("email", $email)->getOne("example-user-table");
        if (!$user) {
            $this->obj->status = 0;
            $this->obj->response = "User doesnot exist";
            echo json_encode($this->obj, JSON_PRETTY_PRINT);
            return;
        }
        ;

        /**
         * check if passwords match
         */
        if ($this->db->count > 0) {
            if (password_verify($this->payload["password"], $user["password"])) {
                $this->obj->status = 1;
                $this->obj->response = "Login successful";
                echo json_encode($this->obj, JSON_PRETTY_PRINT);
                return;
            } else {
                $this->obj->status = 0;
                $this->obj->response = "Invalid Password";
                echo json_encode($this->obj, JSON_PRETTY_PRINT);
                return;
            }
        }
    }

    /**
     * Example API: register a user
     * @return json
     */
    public function register_user()
    {
        /**
         * validate json payload
         */
        $validation = $this->validator->make($this->payload, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'repeat_password' => 'required',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            echo json_encode($errors->firstOfAll(), JSON_PRETTY_PRINT);
            exit();
        }

        /**
         * check if user exists in user table
         */
        $email = $this->payload["email"];
        $user = $this->db->where("email", $email)->getOne("example-user-table");
        if ($user) {
            $this->obj->status = 0;
            $this->obj->response = "User already exists";
            echo json_encode($this->obj, JSON_PRETTY_PRINT);
            return;
        }

        /**
         * check if passwords match
         */
        if ($this->payload["password"] != $this->payload["repeat_password"]) {
            $this->obj->status = 0;
            $this->obj->response = "Passwords do not match";
            echo json_encode($this->obj, JSON_PRETTY_PRINT);
            return;
        }

        /**
         * hash password
         */

        $this->payload["password"] = password_hash($this->payload["password"], PASSWORD_DEFAULT);

        /**
         * insert user into user table
         */

        $id = $this->db->insert("example-user-table", $this->payload);

        if ($id) {
            $this->obj->status = 1;
            $this->obj->response = "User created successfully";
            echo json_encode($this->obj, JSON_PRETTY_PRINT);
            return;
        } else {
            $this->obj->status = 0;
            $this->obj->response = "User creation failed";
            echo json_encode($this->obj, JSON_PRETTY_PRINT);
            return;
        }

    }
}