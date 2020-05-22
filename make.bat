if not '%2' == '' ( php think make:control %2/%1 )
if not '%2' == '' (php think make:action %2/%1)
if not '%2' == '' (php think make:verify %2/%1)
php think make:subaction %1
php think make:task %1
php think make:mode %1
