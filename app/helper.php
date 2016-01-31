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
?>