#!/bin/bash
if [ $2 != '' ];then php think make:control $2/$1;fi
if [ $2 != '' ];then php think make:action $2/$1;fi
if [ $2 != '' ];then php think make:verify $2/$1;fi

php think make:subaction $1;
php think make:task $1;
php think make:mode $1;



