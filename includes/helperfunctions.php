<?php

namespace XitesolutionBB;

/**
 * @param array      $array
 * @param int|string $position
 * @param mixed      $insert
 */
function array_insert(&$array, $insert, $position = 0, $offset = NULL )
{
    if (is_int( $position ) && $offset == NULL) {
        array_splice( $array, $position, 0, $insert );
    } else {
        $pos = array_search( $position, array_keys( $array ) );
        if ( $offset ) {
        	$array = array_merge(
        		array_slice( $array, 0, $offset ),
        		$insert,
        		array_slice( $array, $offset )
        	);
        } else {
	        $array = array_merge(
	            array_slice( $array, 0, $pos ),
	            $insert,
	            array_slice( $array, $pos )
	        );
    	}
    }
}
