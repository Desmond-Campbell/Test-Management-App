<h1>{{$error['class']}}</h1>

<big><big>{{$error['description']}}</big></big>

<h3>URL:</h3>
<p>{{$error['url']}}</p>

<h3>IP:</h3>
<p>{{$error['ip']}}</p>

<h3>Host:</h3>
<p>{{gethostbyaddr($error['ip'])}}</p>

<h3>Browser:</h3>
<p>{{$error['browser']}}</p>

<h3>Trace:</h3>
<pre>{{$error['trace']}}</pre>

<div>
<pre>
	{{$error['string']}}
</pre>
</div>