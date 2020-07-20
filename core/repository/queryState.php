<?php

/**
 * Query STATE
 * Indicates state of querying
 */
abstract class QueryState
{
    const SELECT = 0;
    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;
}

?>