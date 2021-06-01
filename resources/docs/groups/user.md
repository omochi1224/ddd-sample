# User


## ユーザの登録




> Example request:

```bash
curl -X POST \
    "http://localhost/api/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"testName","email":"example@example.com","password":"Passw0rd!","password_confirmation":"Passw0rd!"}'

```

```javascript
const url = new URL(
    "http://localhost/api/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "testName",
    "email": "example@example.com",
    "password": "Passw0rd!",
    "password_confirmation": "Passw0rd!"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "id": "UUID",
    "name": "TestName",
    "email": "test@example.com"
}
```
> Example response (422, Validation error):

```json
{
    "errors": {
        "name": [
            "The name field is required.",
            "The name may not be greater than 255 characters."
        ],
        "email": [
            "The email field is required.",
            "The email must be a valid email address.",
            "The name may not be greater than 255 characters."
        ],
        "password": [
            "The name field is required.",
            "The password must be at least 8 characters.",
            "The password confirmation does not match."
        ]
    }
}
```
<div id="execution-results-POSTapi-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users"></code></pre>
</div>
<div id="execution-error-POSTapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users"></code></pre>
</div>
<form id="form-POSTapi-users" data-method="POST" data-path="api/users" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-users" onclick="tryItOut('POSTapi-users');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-users" onclick="cancelTryOut('POSTapi-users');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-users" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>users</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="users" data-endpoint="POSTapi-users" data-component="url"  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
名前
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
メールアドレス
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
パスワード
</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="password" name="password_confirmation" data-endpoint="POSTapi-users" data-component="body"  hidden>
<br>
確認用パスワード
</p>

</form>


## 　ユーザ検索




> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/users?id=91849582-bdf9-11eb-8529-0242ac130003&name=TestName&email=test%40example.com" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"id":"fuga","name":"laudantium","email":"bwolf@example.org"}'

```

```javascript
const url = new URL(
    "http://localhost/api/users"
);

let params = {
    "id": "91849582-bdf9-11eb-8529-0242ac130003",
    "name": "TestName",
    "email": "test@example.com",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "id": "fuga",
    "name": "laudantium",
    "email": "bwolf@example.org"
}

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "id": "UUID",
    "name": "TestName",
    "email": "test@example.com"
}
```
<div id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"></code></pre>
</div>
<div id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users"></code></pre>
</div>
<form id="form-GETapi-users" data-method="GET" data-path="api/users" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users" onclick="tryItOut('GETapi-users');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users" onclick="cancelTryOut('GETapi-users');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>users</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="users" data-endpoint="GETapi-users" data-component="url"  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users" data-component="query"  hidden>
<br>
ユーザID
</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="GETapi-users" data-component="query"  hidden>
<br>
ユーザ名
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="GETapi-users" data-component="query"  hidden>
<br>
メールアドレス
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="GETapi-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="email" data-endpoint="GETapi-users" data-component="body"  hidden>
<br>
The value must be a valid email address.
</p>

</form>



