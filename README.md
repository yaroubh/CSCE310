# CSCE310
# Note: Each person needs to use an index and use a view
Guide:

- Make sure to put this folder in the httdocs folder of your XAAMP Installation. Make sure to activate Apache and MySQL in XAAMP. Next, go to localhost/phpymyadmin. Make sure to import test.sql.

- Then create a folder for your desired functionality. Next, to create make sure to include the path to "res/head.php". You can then make viewable tables and editable tables. Feel free to make your own functionality as well.

```php
# Makes a non-editable table view of the Hotel table from the database, putting it under the div named 'hotels-div' and assigns it a div of 'b-rv-hotels'.
$gtv_hotels = generate_table_view("hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf");
echo $gtv_hotels;    

# Makes an editable table view of the Room table from the database, putting it under the div named 'rooms-div' and assigns it a div of 'b-rv-rooms'.
$gte_rooms = generate_table_editable("rooms-div", "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_ID ASC", "Inf");
echo $gte_rooms;
```