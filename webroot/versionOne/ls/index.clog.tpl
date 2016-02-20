<h1><img src="{$_tpl}misc/clog.png" border=0 alt=""/> {lng k='changelog'}</h1>
<center>
{assign var="archive" value=1}
{include file="misc/clog.tpl"}
<br/>
{pagination url=$p_url act_page=$p_act per_page=$p_epp count=$p_cou var="page"}
</center>
