<h3>REST API (CRUD) - with the ability to do a string search as well</h3>
Design Pattern: MVC (Model, View, Controller)<br/>
Author: Brian Ravn Pedersen<br/>
Created: 2024-09-18<br/>
Files: index.php, Database.php, Model.php, Controller.php, README.md<br/>
Languages used: PHP, SQL<br/>
Repository: github.com/brp-labs/rest-api<br/>
<br/>
The REST API has been tested with Postman API Platform (desktop) against a MySQL database (MariaDB) running on localhost (Apache/XAMPP).

<hr/>

<h3>How to use the REST API with e.g. Postman API Platform</h3>

<b>CREATE:</b> Use HTTP method POST to create a new post in the database.<br/>
    Submit body in JSON format with at leats the required keys (see below):<br/>
      <i>e.g.</i> <code>{ "username": "John Doe", "email": "john&#64;<!-- -->doe&#46;com", "entity": "Business Intelligence" }</code><br/>
<br/>
<b>READ:</b> Use HTTP method GET to read or search for a post in the database. Response is returned in JSON format.<br/>
    <b>Read single</b> post (use the <code>id</code>-key):<br/>
    <i>e.g.</i> <code>../index.php?id=23</code><br/>
    <b>Read all</b> posts:<br/>
      <i>e.g.</i> <code>../index.php</code><br/>
    <b>Search</b> for posts with the <code>q</code>-key and a specified query string:<br/>
      <i>e.g.</i> <code>../index.php?q=john</code><br/>
      The queried table fields are: username, email. The contains-method is beeing used in SQL, ie. LIKE '%<querystring\>%'<br/>
<br/>
<b>UPDATE:</b> Use HTTP method PUT to update a post in the database.<br/>
    Submit body in JSON format with the keys that need to be changed. Required keys must not be empty (see below). Use the mandatory <code>id</code>-key in the body to identify the post to update.<br/>
      <i>e.g.</i> <code>{ "id": 23, "entity": "Development Division" }</code><br/>
<br/>
<b>DELETE:</b> Use HTTP method DELETE to delete a post in the database. Use the mandatory <code>id</code> to identify the post to delete.<br/>
    Delete post (with <code>id</code>=23):<br/>
      <i>e.g.</i> <code>../index.php?id=23</code>

<br/>
<h3>Keys, Required Keys, Unique Keys, Queried Keys</h3>
The keys, required keys and unique keys, all declared in the Controller Class, are specified in order to uphold a functional logic in the database. 

<br/>
<b>Keys:</b> The keys simply refer to the columns in the table 'users' (cf. the file: schema.sql). The keys are: <code>id</code>, <code>user_id</code>, <code>username</code>, <code>email</code>, <code>entity</code>, <code>entitycode</code>. The <code>id</code>, however, is the primary key and used for auto-incrementing by the database.

<br/>
<b>Required Keys:</b> The required keys are the keys among the above mentioned that must be declared when creating a new post in the 'users' table. The required keys can not be empty (<i>i.e.</i> NULL). Some content for these keys are mandatory. The required keys are: <code>username</code>, <code>email</code>.

<br/>
<b>Unique Keys:</b> The unique keys are the keys among the above mentioned that do not have to be declared when a new post is created. Their default value on table creation are NULL. But if a unique key is being used the key must have a content (value) of its own. Two different posts are not allowed to have the same unique key having the very same content (value). In that sense a unique key must have its own unique content (value). However, several posts can have the same unique key's content set to NULL without violating the rule of uniqueness. The unique keys are:  <code>user_id</code>, <code>username</code>, <code>email</code>.

<br/> 
<b>Queried Keys:</b> When using the search funcionality the queried keys are <code>username</code> and <code>email</code>. The keys used for quering can be changed with some minor modifications of the SQL code in the Model Class file. If needed, go to the search-function in the Model Class file and alter the sql variable as well as the value bindings.

<br/>
<h3>Database Configuration</h3>
The database configuration is shown in the Database Class file.

<br/>
<h3>License</h3>
Anyone who would like to use this REST API can do so and of course modify the code, the database configuration, and the listed suite of different keys as well in order to adapt to the one's actual needs - in compliance with the content of the attached LICENSE file.

<br/>
<hr/>

