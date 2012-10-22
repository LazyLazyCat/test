<?php 
function __autoload($class_name) 
{
        $filename = strtolower($class_name) . '.php';
        if (file_exists($filename) == false) 
		{
                return false;
        }
        else include ($filename);
}
$Representative = new  Representative;
$user = Singleton::getInstance()->createAllUsers();
if(isset($_GET['id']) && $_GET['id']>0 && $_GET['id']<21)
{
	$user = Singleton::getInstance()->getUserById($_GET['id']);
}
?>
<html>
<head>
<link rel="stylesheet" href="main.css" type="text/css"" />
</head>
<body>
    
    <?php 
	if(isset($user))
	{
		echo '<div id="you">';
		$Representative->describeUserInHTML($user);
		echo '</div>';
		?>
    	<div id="body">
        <div id="left">
        <h1>DirectFriends</h1>
            <?php
			$DirectFriends = $user->getDirectFriends();
			if($DirectFriends != NULL)
			{
				foreach($DirectFriends as $DF)
				{
					$Representative->describeUserInHTML($DF);
				} 
			}
			?>
        </div>
        <div id="center">
        <h1> Suggested friends </h1>
			<?php
			$SuggestetFriends = $user->getSuggestedFriends();
			if($SuggestetFriends != NULL)
			{
				foreach($SuggestetFriends as $DF)
				{
					$Representative->describeUserInHTML($DF);
				}
			} 
			?>
        </div>
        <div id="right">
        <h1>Friends of friends </h1>
        	<?php
			$FriendsofFriends = $user->getFriendsofFriends();
			if($FriendsofFriends != NULL)
			{
				foreach($FriendsofFriends as $DF)
				{
					$Representative->describeUserInHTML($DF);
				} 
			}
			?>
        </div>
    <?php 
	} 
	else
	{
		$users = Singleton::getInstance()->getAllUsers();
		foreach($users as $user)
		{
			$Representative->describeUserInHTML($user);
		} 
	}
	?>
    </div>
</body>
</html>