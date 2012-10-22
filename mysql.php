<?php
final class MySQL
{
	function __construct()
	{
		try
		{
			$this->pdo = new PDO( 
    		'mysql:host=localhost;dbname=sn', 
    		'root', 
    		'1234', 
    		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}
		catch (Exception $e) 
		{
   		echo 'failed connection',  $e->getMessage(), "\n";
		}
	}
	public function getAllUsers()
	{
		$sth = $this->pdo->prepare("SELECT *  FROM users");
		$sth->execute();
		$users = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach($users as $key=>$user)
		{
			$key++;
			$sth2 = $this->pdo->prepare("SELECT friends_id as friends FROM `friends` WHERE users_id=:id ");
			$sth2->bindValue(':id', $key);
			$sth2->execute();
			$friends = $sth2->fetchAll(PDO::FETCH_ASSOC);
			foreach($friends as $friend)
			{
				$youfriends['friends'][] = $friend['friends'];
			}
			$AllUsers[] = array_merge($user, $youfriends);
			unset($youfriends);
		}
		return $AllUsers;
	}
	public function saveUser($user)
	{
		$id = $user->getId();
		$firstname = $user->getFirstName();
		$surname = $user->getSurName();
		$age = $user->getAge();
		$gender = $user->getGender();
		try
		{
			$sth = $this->pdo->prepare("INSERT INTO `sn`.`users` (`id`, `firstName`, `surname`, `age`, `gender`) VALUES (:id, :firstName, :surname, :age, :gender);");
			$sth->bindValue(':id',$id);
			$sth->bindValue(':firstName',$firstname);
			$sth->bindValue(':surname',$surname);
			$sth->bindValue(':age',$age);
			$sth->bindValue(':gender',$gender);
			$sth->execute();
			$sth2 = $this->pdo->prepare("INSERT INTO `sn`.`friends` (`users_id`, `friends_id`) VALUES (:users_id, :friends_id);");
			$friends = $user->getFriends();
			print_r($friends);
			foreach($friends as $friend)
			{
				$sth2->bindValue(':users_id',$id);
				$sth2->bindValue(':friends_id',$friend);
				$sth2->execute();
			}
			echo 'aleesgut';
		}
		catch(PDOException $e) 
		{
			echo 'Error : '.$e->getMessage();
		}
	}
	
}

?>