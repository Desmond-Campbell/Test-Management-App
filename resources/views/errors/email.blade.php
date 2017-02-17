<h1>{{$error['class']}}</h1>

<big><big>{{$error['description']}}</big></big>

<h3>URL:</h3>
<p>{{$error_details['url']}}</p>

<h3>IP:</h3>
<p>{{$error_details['ip']}}</p>

<h3>Host:</h3>
<p>{{gethostbyaddr($error_details['ip'])}}</p>

<h3>Browser:</h3>
<p>{{$error_details['browser']}}</p>

<h3>Trace:</h3>
<pre>{{$error_details['trace']}}</pre>
