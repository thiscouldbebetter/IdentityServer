<?php

class Notification
{
	public $notificationID;
	public $addressee;
	public $subject;
	public $body;
	public $timeCreated;
	public $timeSent;

	public function __construct($notificationID, $addressee, $subject, $body, $timeCreated, $timeSent)
	{
		$this->notificationID = $notificationID;
		$this->addressee = $addressee;
		$this->subject = $subject;
		$this->body = $body;
		$this->timeCreated = $timeCreated;
		$this->timeSent = $timeSent;
	}

	public function sendAsEmail($persistenceClient)
	{
		$configuration = $_SESSION["Configuration"];
		$isEmailEnabled = $configuration->emailEnabled;
		if ($isEmailEnabled == true)
		{
			$emailAddressNotify = $configuration->emailAddressNotify;
			$fromAsHeaders = "From: " . $emailAddressNotify;
			mail($this->addressee, $this->subject, $this->body, $fromAsHeaders);
			$now = new DateTime();
			$this->timeSent = $now;
			$persistenceClient->notificationSave($this);
		}
	}
}

?>
