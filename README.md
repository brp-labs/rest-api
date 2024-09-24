<h3>REST API (CRUD) - with the ability to do a string search as well</h3>
Design Pattern: MVC (Model, View, Controller)<br/>
Author: Brian Ravn Pedersen.<br/>
Created: 2024-09-18<br/>
Files: index.php, Database.php, Model.php, Controller.php<br/>
Languages used: PHP, SQL (ANSI)<br/>
Repository: github.com/brp-labs/rest-api<br/>

<hr/>

<h4>How to use the REST API with e.g. Postman API Platform</h4>

<b>CREATE:</b> Use HTTP method: POST<br/>
    Send body in JSON-format with at leats the required keys (username, email):<br/>
      e.g. <code>{ "username": "John Doe", "email": "`john@doe.com`", "entity": "Business Intelligence" }</code><br/>
<br/>
<b>READ:</b> Use HTTP method: GET. Response is returned in JSON-format<br/>
    Read single post (with id=23):<br/>
      e.g. <code>../index.php?id=23</code><br/>
    Read all posts:<br/>
      e.g. <code>../index.php</code><br/>
    Search for posts with q-key:<br/>
      e.g. <code>../index.php?q=<querystring\></code> (fields queried: username, email)<br/>
      The contains-method is beeing used i SQL, ie. LIKE '%<querystring\>%'<br/>
<br/>
<b>UPDATE:</b> Use HTTP method: POST<br/>
    Send body in JSON-format with the fields that need to be changed.<br/>
    Required keys must not be emptied. Use the id-key in the body in order<br/>
    to identify the post to update. The id-key is mandatory.<br/>
      e.g. <code>{ "id": 23, "entity": "Development Division" }</code><br/>
<br/>
<b>DELETE:</b> Use HTTP method: GET<br/>
    Delete post (with id=23):<br/>
      e.g. <code>../index.php?id=23</code><br/>
<br/>
<hr/>

