<?php

return [

    // Define the parameters of your installation here


    'environment'   => 'prd',  // Which environment to deploy in
    'apiKey'        => '',     // Insert your api key to talk to newrelic
    'applicationIds' => [      // Can have more than one application ID as one deployment may cover many applications
        '',
    ],
    'user'          => null,   // Optional params to tell newrelic more info
    'description'   => null,
    'revision'      => null,

];
