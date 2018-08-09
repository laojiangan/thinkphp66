<?php

function md_crypt($str){
	 return md5(crypt($str,config('pwdstring')));
}


?>