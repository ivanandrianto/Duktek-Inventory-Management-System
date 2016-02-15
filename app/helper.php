<?php
// My common functions
function adminOnly()
{
	//$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
	//$output->writeln('call admin check');
	$result = 0;
    if (Auth::check()) {
	    if(Auth::user()->type == 'admin'){
	        $result = 1;
	    }
	}
	return $result;
}
function checkDateTime($data) {
    if (date('Y-m-d H:i:s', strtotime($data)) == $data) {
        return true;
    } else {
        return false;
    }
}
?>