<h3>REST API (CRUD) - with the ability to perform string searches as well</h3>
<b>Design Pattern:</b> MVC (Model, View, Controller)<br/>
<b>Author:</b> Brian Ravn Pedersen, Data Engineer and Software Developer<br/>
<b>Created:</b> 2024-09-18<br/>
<b>Files:</b> index.php, schema.sql, Database.php, Model.php, Controller.php, README.md. LICENSE.txt<br/>
<b>Languages used:</b> PHP, SQL<br/>
<b>GitHub Repository:</b> https://github.com/brp-labs/rest-api<br/>
<br/>
The REST API has been tested with <b>Postman API Platform</b> (desktop) against a MySQL database (MariaDB) running on a local server (Apache/XAMPP).

<hr/>

<h3>How to use the REST API with e.g., Postman API Platform</h3>

<b>CREATE:</b> Use the HTTP method POST to create a new post in the database.<br/>
    Submit the body in JSON format with at least the required keys (see below):<br/>
      <i>e.g.,</i> <code>{ "username": "John Doe", "email": "john&#64;<!-- -->doe&#46;com", "entity": "Business Intelligence" }</code><br/>
<br/>
<b>READ:</b> Use the HTTP method GET to read or search for a post in the database. The response is returned in JSON format.<br/>
    <b>Read a single</b> post (use the <code>id</code> key):<br/>
    <i>e.g.,</i> <code>../index.php?id=23</code><br/>
    <b>Read all</b> posts:<br/>
      <i>e.g.,</i> <code>../index.php</code><br/>
    <b>Search</b> for posts using the <code>q</code> key and a specified query string:<br/>
      <i>e.g.,</i> <code>../index.php?q=john</code><br/>
      The queried table fields are: username, email. The contains method is being used in SQL, ie., LIKE '%<querystring\>%'<br/>
<br/>
<b>UPDATE:</b> Use the HTTP method PUT to update a post in the database.<br/>
    Submit the body in JSON format with the keys that need to be changed. Required keys must not be empty (see below). Use the mandatory <code>id</code> key in the body to identify the post to update.<br/>
      <i>e.g.,</i> <code>{ "id": 23, "entity": "Development Division" }</code><br/>
<br/>
<b>DELETE:</b> Use the HTTP method DELETE to delete a post in the database. Use the mandatory <code>id</code> key to identify the post to delete.<br/>
    Delete post (with <code>id</code>=23):<br/>
      <i>e.g.,</i> <code>../index.php?id=23</code>

<h3>Keys, Required Keys, Unique Keys, Queried Keys</h3>
The keys, required keys, and unique keys, all declared in the <b>Controller Class</b>, are specified in order to uphold functional logic in the database.<br/> 

<br/>
<b>Keys:</b> The keys refer to the columns in the table <code>users</code> (cf. the file: <code>schema.sql</code>). The keys are: <code>id</code>, <code>user_id</code>, <code>username</code>, <code>email</code>, <code>entity</code>, <code>entitycode</code>. The <code>id</code>, however, is the primary key and is used for auto-incrementing by the database.<br/>

<br/>
<b>Required Keys:</b> The required keys are those that must be declared when creating a new post in the <code>users</code> table. The required keys cannot be empty (<i>i.e.,</i> NULL). Some content for these keys is mandatory. The required keys are: <code>username</code>, <code>email</code>.<br/>

<br/>
<b>Unique Keys:</b> The unique keys do not need to be declared when a new post is created. Their default value on table creation is NULL. However, if a unique key is used, the key must have its own content (value). Two different posts are not allowed to have the same unique key with identical content (value). In that sense, a unique key must have unique content (value). However, multiple posts can have the same unique key's content set to NULL without violating the uniqueness rule. The unique keys are:  <code>user_id</code>, <code>username</code>, <code>email</code>.<br/>

<br/> 
<b>Queried Keys:</b> When using the search functionality, the queried keys are <code>username</code> and <code>email</code>. The keys used for quering can be changed with some minor modifications to the SQL code in the <b>Model Class</b> file. If needed, go to the search function in the Model Class file and alter the <code>$sql</code> variable as well as the value bindings.

<br/>
<h3>Database Configuration</h3>
The database configuration is shown in the <b>Database Class</b> file. The file <code>schema.sql</code> contains the sequence of SQL code used to create the database and the table, including its columns and specifications.

<br/>
<h3>Metadata</h3>
Whenever a dataset is returned from the database as a result of reading a single post, reading all posts, or searching for one or more posts, a separate array is inserted right before the dataset array. This separate array at the very top, called <code>Info</code>, gives a timestamp and the number of posts returned from the database. The timezone used is set at the top of the <b>Controller Class</b> and is default set to 'Europe/Copenhagen'. And, of course, the timezone should be adjusted if the application runs in a different timezone. The array containing the dataset, by the way, is called <code>Data</code>. 


<br/>
<h3>License</h3>
Anyone who would like to use this REST API can do so and, of course, modify the code, the database configuration, and the list of different keys as well, in order to adapt it to one's actual needs - in compliance with the content of the attached LICENSE file.

<br/>
<hr/>
 

