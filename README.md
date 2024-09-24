<h3>REST API (CRUD) - with the ability to do a string search as well</h3>
Design Pattern: MVC (Model, View, Controller)<br/>
Author: Brian Ravn Pedersen<br/>
Created: 2024-09-18<br/>
Files: index.php, Database.php, Model.php, Controller.php<br/>
Languages used: PHP, SQL (ANSI)<br/>
Repository: github.com/brp-labs/rest-api<br/>

<hr/>

<h3>How to use the REST API with e.g. Postman API Platform</h3>

<b>CREATE:</b> Use HTTP method POST to create a new post.<br/>
    Submit body in JSON-format with at leats the required keys (username, email):<br/>
      e.g. <code>{ "username": "John Doe", "email": "john&#64;<!-- -->doe&#46;com", "entity": "Business Intelligence" }</code><br/>
<br/>
<b>READ:</b> Use HTTP method GET to read or search for a post. Response is returned in JSON-format.<br/>
    <b>Read single post</b> (with id=23):<br/>
    e.g. <code>../index.php?id=23</code><br/>
    <b>Read all posts</b>:<br/>
      e.g. <code>../index.php</code><br/>
    <b>Search</b> for posts with q-key:<br/>
      e.g. <code>../index.php?q=<querystring\></code> (fields queried: username, email)<br/>
      The contains-method is beeing used i SQL, ie. LIKE '%<querystring\>%'<br/>
<br/>
<b>UPDATE:</b> Use HTTP method POST to update a post.<br/>
    Send body in JSON-format with the fields that need to be changed.<br/>
    Required keys must not be emptied. Use the id-key in the body in order<br/>
    to identify the post to update. The id-key is mandatory.<br/>
      e.g. <code>{ "id": 23, "entity": "Development Division" }</code><br/>
<br/>
<b>DELETE:</b> Use HTTP method GET to delete a post.<br/>
    Delete post (with id=23):<br/>
      e.g. <code>../index.php?id=23</code><br/>
<br/>
<hr/>

