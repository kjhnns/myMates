<?php
/*
 * Created on 14.04.2008
 *
 * (c) by Johannes Klumpe | joh.klumpe@gmail.com
 */

 /*
  * TPL FUNCTIONS
  *
  * {months k=%UNIXTIMESTAMP%} - gibt en aktuellen monatsnamen zurueck
  * {online id=%UID%} - gibt nen html bild code zurueck ob ID online ist
  * {lng k=%KEY% d=%DIM%} - returned das wort in der sprache ;)
  * {pagination url=a count=b act_page=c per_page=d var=e} - pagination
  * {uencode url=%URL%} - urlencode()
  * {avatar k=%UID%} - gibt die bildadresse des jeweiligen avatars
  * {uInfo id=%UID% f=%field%} gibt die jeweiligen daten aus der user db
  * {uName id=%UID% slim=true} gibt den usernamen zurueck
  * {comments cat=%CATEGORY% item=%CATID% layout=%URL%} Kommentar funktion
  * {uposts id=%UID%} gibt die user posts im forum zurueck
