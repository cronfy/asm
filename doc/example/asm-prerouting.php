<?php

// Include application aliases: we need to know where to search apps' configs
require __DIR__ . "/apps/common/config/_aliases.php";
// Run prerouting. It will either process the request, or return (sometimes both).
\common\components\Prerouting::route();

// if we are here, then yii2 has nothing to do with the request (or request was partially processed by yii2).
// Continue with legacy code.
