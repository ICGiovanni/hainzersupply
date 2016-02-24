<?php

$cmd = "bash /kunden/homepages/32/d613844801/htdocs/hainzersupply/.git/hooks/post-receive";
exec($cmd. " > /dev/null &");

echo "test auto pull server";
