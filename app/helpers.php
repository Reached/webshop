<?php

// Get the amount from a larger amount
function getAmount($amount) {
    return $amount / 100;
}

// Check if the current url is the active one
// then set the class of active if thats true, otherwise set nothing
function isActive($url) {
    return Request::is($url) ? 'active' : '';
}

/**
 * @param $amount
 * @return string
 */
function getRoundedValue($amount) {
    return number_format($amount / 100, 0, ',', '.') . ' kr';
}


