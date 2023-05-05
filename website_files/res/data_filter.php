<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file creates a data filter class that has properties for constructing a data filter. Data filters
are used to filter out tables. Essentially, they can change the select query in a data_table object 
(which is defined in data_table.php). For example, if you wanted to search by the maximum price 
of a room, then you could use a data_filter to acommplish that. Multiple examples of how to use 
the data_filter class are shown in bookings.php.

----------------------------------------------------------------------------------------------->

<?php
/**
 * A Data Filter Class that holds information for restricting a select query in a data_table
 */
class data_filter {

    public $div_name; 
    public $table_name;
    public $cond_name_start; 
    public $cond_op; 
    public $cond_name_end; 
    public $cond_type; 
    public $cond_label; 
    public $default_value;
/**
 * Initializes a filter object with its properties
 *
 * @param string $div_name ID of filter
 * @param string $table_name ID of table
 * @param string $cond_name_start Starting string of the condition to filter by
 * @param string $cond_op The operation used in the filter ocondition
 * @param string $cond_name_end Ending string of the condition to filter by
 * @param string $cond_type The type of value we are checking in the filter condition
 * @param string $cond_label The text label given to the filter
 * @param string $default_value The default value in the filter element
 */
public function __construct($div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label, $default_value) {
        $this -> div_name = $div_name; 
        $this -> table_name = $table_name;
        $this -> cond_name_start = $cond_name_start; 
        $this -> cond_op = $cond_op; 
        $this -> cond_name_end = $cond_name_end; 
        $this -> cond_type = $cond_type; 
        $this -> cond_label = $cond_label; 
        $this -> default_value = $default_value;
}
}