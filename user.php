<?php
class User
{
    private $Id;
	private $FirstName;
	private $SurName;
	private $Age;
	private $Gender;
	private $Friends;
    
	
	public function getId()
	{
		return $this->Id;
	}
	public function setId($Id)
	{
	   
        $Pattern = "(^[0-9]{1,5}$)";
        
        if ($this->checkIncomingValue($Id, $Pattern) == true) 
        {
            $this->Id = $Id;
        }
    }
	public function getFirstName()
	{
		return $this->FirstName;
	}
	public function setFirstName($FirstName)
	{
	   
        $Pattern = "(^[A-Za-z]{2,20}$)";
        
        if ($this->checkIncomingValue($FirstName, $Pattern) == true) 
        {
            $this->FirstName = $FirstName;
        }
    }
	public function getSurName()
	{
		return $this->SurName;
	}
	public function setSurName($SurName)
	{
	    $Pattern = "(^[A-Za-z]{1,20}$)";
        
        if ($this->checkIncomingValue($SurName, $Pattern) == true) 
        {
            $this->SurName = $SurName;
        }
		else $this->SurName = 'Unknown';
	}
	public function getAge()
	{
		return $this->Age;
	}
	public function setAge($Age)
	{
	    $Pattern = "(^[0-9]{1,3}$)";
        
        if ($this->checkIncomingValue($Age, $Pattern) == true)
        {
		  $this->Age = $Age;
        }
		else $this->Age = '';
	}
	public function getGender()
	{  
		return $this->Gender;
	}
	public function setGender($Gender)
	{
	   $Pattern = "(^[A-Za-z]{3,20}$)";
        
        if ($this->checkIncomingValue($Gender, $Pattern) == true)
        {
		  $this->Gender = $Gender;
        }
		else $this->Gender = '';
	}
	public function getFriends()
	{
		return $this->Friends;
	}
	public function setFriends($Friends)
	{
	   
	    $Pattern = "(^[0-9]{0,3}$)";

        foreach($Friends as $F)
        {
            if ($this->checkIncomingValue($F, $Pattern) == true)
            {
               $wFriends[] = $F;
            }
        }
        if(isset($wFriends))
        {
            $this->Friends = $wFriends;
        }
	}
	public function saveUser()
    {
        $MySQL = new MySQL;
		$MySQL->saveUser($this);
    }
	public function getDirectFriends()
	{
		$DirectFriends = $this->Friends;
		$DirectFriends = $this->deleteYouFromArray($DirectFriends);
		return $this->getObjectUsersArrayFromArray($DirectFriends);
	}
	public function getFriendsofFriends()
	{
		$myFriends = $this->Friends;
		$FriendsOfFriends = $this->getAllFriendsOfFriends();
		$FriendsOfFriends = array_unique($FriendsOfFriends);
		$FriendsOfFriends = array_diff($FriendsOfFriends, $myFriends);
		$FriendsOfFriends = $this->deleteYouFromArray($FriendsOfFriends);
		return $this->getObjectUsersArrayFromArray($FriendsOfFriends);
	}
	public function  getSuggestedFriends()
	{
		$myFriends = $this->Friends;
		$AllFriends = array();
		$returnSuggestedFriends = array();
		$FriendsOfFriends = $this->getAllFriendsOfFriends(Singleton::getInstance());
		$SuggestedFriends = array_diff($FriendsOfFriends, $myFriends);
		$SuggestedFriends =  array_count_values($SuggestedFriends);
		$SuggestedFriends = array_filter($SuggestedFriends, function ($v) { return $v >= 2; });
		foreach($SuggestedFriends as $key=>$S)
		{
			$returnSuggestedFriends[] = $key;
		}
		$returnSuggestedFriends = $this->deleteYouFromArray($returnSuggestedFriends);
		return $this->getObjectUsersArrayFromArray($returnSuggestedFriends);
	}
	private function getAllFriendsOfFriends()
	{
		$myFriends = $this->Friends;
		$FriendsOfFriends = array();
		foreach($myFriends as $F)
		{
			$user = Singleton::getInstance()->getUserById($F);
			$FriendsOfFriends = array_merge($FriendsOfFriends, $user->Friends);
		}
		return $FriendsOfFriends;
	}
	private function deleteYouFromArray($Array)
	{
		foreach($Array as $key=>$A)
		{
			if($A == $this->getId())
			{
				unset($Array[$key]);
			}
		}
		if(isset($Array))
		{
			return $Array;
		}
		else return NULL;
	}
    private function checkIncomingValue($Value, $Pattern)
    {
        if (preg_match($Pattern,$Value)) 
        {
		  return true;
        }
        else
        {
          return false;  
        } 
    }
	private function getObjectUsersArrayFromArray($Array)
	{
		foreach($Array as $F)
		{
			$DirectFriends[] = Singleton::getInstance()->getUserById($F);
		}
		if(isset($DirectFriends))
		{
			return $DirectFriends;
		}
		else return NULL;
	}
}