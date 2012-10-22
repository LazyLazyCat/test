<?php

class Representative
{
	public function  describeUserInHTML($user)
	{
		echo '<a href="index.php?id='.$user->getId().'">';
		echo '<div class="pull-quote">';
		echo 'Name: '.$user->getFirstName()."<br/>";
		echo 'SurName: '.$user->getSurName()."<br/>";
		echo 'Age: '.$user->getAge()."<br/>";
		echo 'Gender: '.$user->getGender()."<br/>";
		echo '</div>';
		echo '</a>';
	}
}