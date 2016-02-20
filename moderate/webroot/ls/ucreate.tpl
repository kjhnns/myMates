{if $smarty.get.save == 'true'}
<div class="info"><h1>Success</h1>user password: {$pw}<br/>you need to note down this pw for the user who wants to login</div>
{/if}
<form action="?action=create&amp;save=true" method="post">
<h1>create new user</h1>
Email: <input type="text" name="email" /><br>
Name: <input type="text" name="name" /><br>
<input type="submit" value="Save" /><br>
</form>