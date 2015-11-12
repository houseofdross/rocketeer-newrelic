# Newrelic Rocketeer Plugin

This plugin allows you to configure a deployment to a specific target to notify a NewRelic account that you have just
completed a deployment. This can be a handy tool for tracking your deployments and updating your monitoring systems
so you can see performance metrics before and after.

## Install

To setup add this to your `composer.json` and update :

```json
"hod/rocketeer-newrelic": "dev-master"
```

In your applications .rocketeer/config.php, add `Rocketeer\Plugins\Newrelic\RocketeerNewrelic` to the plugin array.

Fill out the configuration as outlined in Usage below and you are ready to go.

## Usage

- To insert configuration into userland, run `rocketeer plugin:config hod/rocketeer-newrelic`
- Add at a minimum your API key, and the Newrelic application ID (or ID's in case you are deploying 2 or more applications at once) you wish to notify upon deploy
- Define the environment target it should run on. This matches your --on='env' tag when you deploy.
- Add optional extras like user, description of release and the version. 

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.