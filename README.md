# Unoffical PHP SDK for Bale Messenger

PHP SDK and samples for [Bale bot messenger](https://developers.bale.ai).

## Getting Started

### Prerequisites

You'll need to create your bot by [@Bot_Father](https://web.bale.ai/). Bot_Father gives you a Token to start.

### Installing

#### Using Composer

```sh
composer require aliazizi/bale-bot-sdk
```

```php
require __DIR__.'/../vendor/autoload.php';

$api = new \BaleBot\Api('Your-Token');
```

#### I don't have Composer

You can download it [here](https://getcomposer.org/download/).
A step by step series of examples that tell you how to get a development env running


End with an example of getting some data out of the system or using it for a little demo

## Example
```php
$api->sendTextMessage('Message','to channel name without @')
$api->sendPhotoMessage('filepath,'to channel name without @','Caption')
$api->sendVideoMessage('filepath,'to channel name without @','Caption')
```

## Contributing

If you would like to contribute to this project, please feel free to submit a pull request.
Before you do, take a look at the [contributing guide](https://github.com/aliazizi/bale-bot-sdk/blob/master/CONTRIBUTING.md).

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Ali Akbar Azizi** - [aliazizi](https://github.com/aliazizi)

See also the list of [contributors](https://github.com/aliazizi/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

