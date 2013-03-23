<?php
class FBIgnitedException extends Exception {

	public function __construct($message = null, Exception $previous = null, $error_log = true) {
		if ($message != null) {
			// check if the message is set and use that as message
			$this->message = $message;
		}
		if ($previous instanceof Exception) {
			// if the $previous variable is an instance of Exception class use the details from it.
			if ($message == null) {
				// If they do not set a message use the $previous message
				$this->message = $previous->getMessage();
			}
			// Use the original error code passed
			$this->code = $previous->getCode();
		}

		// make sure that we log the issue if the setting is true.
		if ($error_log === true) {
			error_log("FBIgnitedException: ".$this->message);
		}

		// make sure to include/inherit the previous/parent's values
		parent::__construct($this->message, $this->code);
	}

	public function __toString() {
		// custom string representation of object
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}
