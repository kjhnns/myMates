
<h1><img src="{$_tpl}misc/favorites.png" alt="" border=0 /> {lng k='editFavs' d='profile'}</h1>
<div class="box_n">
<form action="./myAccount.php?action=editFavs&amp;edit=true" method="post">
<table cellpadding=2 cellspacing=1 border=0 style="width: 95%;">
<tr><td style="width: 25%;">{lng k='movie' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favMovie" type="text" value="{$user.favMovie}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='music' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favMusic" type="text" value="{$user.favMusic}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='food' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favFood" type="text" value="{$user.favFood}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='place' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favPlace" type="text" value="{$user.favPlace}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='car' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favCar" type="text" value="{$user.favCar}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='sports' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favSports" type="text" value="{$user.favSports}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='sportsclub' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favSportsclub" type="text" value="{$user.favSportsclub}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='hp1' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favHp1" type="text" value="{$user.favHp1}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='hp2' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favHp2" type="text" value="{$user.favHp2}" style="width: 100%;"></td></td></tr>
<tr><td style="width: 25%;">{lng k='hp3' d='profile'}:</td>
<td style="width: 75%;"><input class="inputBig" name="favHp3" type="text" value="{$user.favHp3}" style="width: 100%;"></td></td></tr>

</table>
<br>

<center>
<input type="submit" value="{lng k='submit'}" />
<input type="reset" value="{lng k='reset'}" />
</center>
</form>
<br>
</div>