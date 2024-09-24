<h3>REST API (CRUD) - with the ability to do a string search as well</h3>
Design Pattern: MVC (Model, View, Controller)<br/>
Author: Brian Ravn Pedersen<br/>
Created: 2024-09-18<br/>
Files: index.php, Database.php, Model.php, Controller.php<br/>
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
    <b>Read single</b> post (with <code>id</code>=23):<br/>
    <i>e.g.</i> <code>../index.php?id=23</code><br/>
    <b>Read all</b> posts:<br/>
      <i>e.g.</i> <code>../index.php</code><br/>
    <b>Search</b> for posts with q-key and a specified query string:<br/>
      <i>e.g.</i> <code>../index.php?q=john@</code><br/>
      The queried fields are: username, email. The contains-method is beeing used in SQL, ie. LIKE '%<querystring\>%'<br/>
<br/>
<b>UPDATE:</b> Use HTTP method PUT to update a post in the database.<br/>
    Submit body in JSON format with the keys that need to be changed. Required keys must not be empty (see below). Use the mandatory <code>id</code>-key in the body to identify the post to update.<br/>
      <i>e.g.</i> <code>{ "id": 23, "entity": "Development Division" }</code><br/>
<br/>
<b>DELETE:</b> Use HTTP method DELETE to delete a post in the database. Use the mandatory <code>id</code> to identify the post to delete.<br/>
    Delete post (with <code>id</code>=23):<br/>
      <i>e.g.</i> <code>../index.php?id=23</code><br/>
<br/>

<b>Keys, Reqiured Keys, Unique Keys</b><br/>
<br/>
You can modify the suite of keys to your needs.
<hr/>

