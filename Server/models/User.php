<?php
require_once(__DIR__ . "/Model.php");


class User extends Model {
    protected static  $table = "users";

    private ?int $id;            
    private string $name;     
    private string $email;       
    private string $password;  
    private ?string $created_at; 

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
    }


}
?>
