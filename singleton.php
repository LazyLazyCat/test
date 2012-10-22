<?php

class Singleton {

  protected static $instance;
  private $Users;
  
  private function __construct() {}
  private function __clone() {}

  public static function getInstance() 
  {
  	return (self::$instance === null) ? 
  	self::$instance = new self():
  	self::$instance;
  }  
  private function craeteUser($Id, $FirstName, $SurName, $Age, $Gender, $Friends)
  {
        $NewUser = new User;
		$NewUser->setId($Id);
        $NewUser->setFirstName($FirstName);
        $NewUser->setSurName($SurName);
        $NewUser->setAge($Age);
        $NewUser->setGender($Gender);
        $NewUser->setFriends($Friends);
        
        $this->Users[$Id] = $NewUser;
    }
	public function createAllUsers()
	{
			$MySQL = new MySQL;
			$users = $MySQL->getAllUsers();

			foreach($users as $user)
			{
				Singleton::getInstance()->craeteUser($user['id'], $user['firstName'], $user['surname'], $user['age'], $user['gender'], $user['friends']);
			}
	} 
    public function getAllUsers()
    {
        return $this->Users;
    }
    public function getUserById($Id)
    {
        if(isset($this->Users[$Id]))
        {
            return $this->Users[$Id];
        }
        else
        {
            return NULL;
        } 
    }
        
}