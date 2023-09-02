<?php

return [
    'version' => explode('@', \Composer\InstalledVersions::getVersion('tannhatcms/image-resizes') ?? 0)[0],
    'driver' => 'gd',
    'sizes' => [
        'thumb' => [215, 320],
        'poster' => [0, 0],
        'thumbnail' => [150, 150], 
        'medium' => [400, 400],
        'larage' => [600, 600],
        '215x320' => [215, 320],
        '180x260' => [180, 260],//width="180" height="260"
        '55x85' => [55, 85],
    ], 
];
