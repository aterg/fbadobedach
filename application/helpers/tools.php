<?php

function get_minvalue($value, $default = 0) {
	if( $default >= $value )
		return $value;
	if( $value >= $default)
		return $default;
}

function get_maxvalue($value, $default = 0) {
	if( $default <= $value )
		return $value;
	if( $value <= $default)
		return $default;
}