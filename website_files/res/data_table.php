<?php
/**
 * A Data Table Class that holds information useful for sending to the database
 */
class data_table {

    public $parent_div; 
    public $table_name;
    public $table_query_name; 
    public $query; 
    public $max_width; 
    public $table_field_types; 
    public $table_opts; 

    /**
     * Initializes the data table with its properties
     *
     * @param string $parent_div id of parent div
     * @param string $table_name id of table element
     * @param string $table_query_name Name of table to be used in query
     * @param string $query Specific select query used to get data from MySQL database
     * @param string $max_width Max width of the table (or infinity if no width constraintE)
     * @param string[] $table_field_types The types of data in each column (ignoring the ID column)
     * @param string[] $table_opts Other table options
     */
    public function __construct($parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts) {
        $this -> parent_div = $parent_div; 
        $this -> table_name = $table_name;
        $this -> table_query_name = $table_query_name; 
        $this -> query = $query; 
        $this -> max_width = $max_width; 
        $this -> table_field_types = $table_field_types; 
        $this -> table_opts = $table_opts; 
    }
}

?>