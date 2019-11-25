# Hagrid

Simplified integration with AWS Secrets Manager.

## Getting Started

The purpose of this package is to simplify integration with AWS Secrets Manager. So your responsibility goes to data recovery. 
The use of recovered data will depend on the structure of each application.

### Prerequisites

```
* PHP >= 7.1;
* JSON PHP Extension;
* Composer
```

### Installing

Download the package using composer.

``` 
composer require madeiramadeirabr/hagrid
```

## Basic Usage

Integration can be accomplished in two ways.

### First Method

Instantiating the SecretsManager class and calling the setters.

```
$secretsManager = new SecretsManager();

$secretsManager->setId($myAwsId)
    ->setKey($myAwsKey)
    ->setRegion($awsRegion)
    ->setSecretName($secretName);
```

### Second Method

Instantiating the SecretsManager with AWS data.

```
$secretsManager = (new SecretsManager($myAwsId, $myAwsKey, $awsRegion, $secretName));
```

### And Finally

After using either of the above two methods, call the method that performs data recovery.

```
$secretsManager->getSecretValue();
```

### Response

The response of the method 'getSecretValue' will be something like this.

```
{
    "info1": "abc",
    "info2": "xyz"
}
```

## Authors

* **Lucas Praxedes** - *Initial work* - [Lucas Praxedes](https://github.com/kumasekuraprax)

See also the list of [contributors](https://github.com/madeiramadeirabr/hagrid/graphs/contributors) who participated in this project.
