# PDOCRUD
PDO CRUD functions
------------------
db_insert($tbl, $h);
* creates a new row in table. returns last insert id or false
* $tbl = string, table name to insert data into
* $h = array, key=>value to be inserted

db_read($tbl, $k, $id, $sort);
* reads entries from table returns entries or false
* $tbl = string, table name
* $k = string, table columns to be returned
* $id = number, ID of row if only 1
* $sort = string, column to sort by

db_update($tbl, $h, $id);
* updates row from table. returns true or false
* $tbl = string, table name
* $h = array, columns to be updated
* $id = number, id of row

db_delete($tbl, $id)
* deletes row from table. returns true or false
* $tbl = string, table name
* $id = number, id of row
