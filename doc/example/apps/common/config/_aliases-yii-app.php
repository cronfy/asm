<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 17.03.17
 * Time: 12:54
 */

// Yii initializes some aliases at the time of instantiating Application,
// i.e:
//      new yii\console\Application($config);
// or
//      new yii\web\Application($config);

// Known aliases: @runtime, @webroot

// If these aliases were set earlier, they will be reset.

// Thus, these aliases should be confgured in application config.

return [
    '@runtime' => '@tmp/runtime'
];