# Hagrid

Simplified integration with AWS Secrets Manager.

## Getting Started

The purpose of this package is to simplify integration with AWS Secrets Manager, providing an easy way to retrive stored data.

All helpers considers that you have an role in EC2. This role must be allowed to access secrets manager. If EC2 doesn't has
role to access SM, you need to create you own helpers using aws id and key to authenticate. All methods are explained here.

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

Basic integration can be accomplished in three ways.

### First Method: Raw Data Retrive

This way retrive the raw json from secrets manager. This is useful if you application need to manipulate environment variables
before save it.

To do that, call secrets manager helper, as in the example below:

```
$rawData = secrets_manager($secretId);
```

The response will be something like that:

```
{
    "APP_NAME": "My App Name", 
    "APP_ENV": "production"
}
```

### Second Method: Create .env File

This method will verify if .env file exists, if it don't, it will be created from data retrived from secrets manager.

```
$fileCreated = create_env_file($directory, $secretId);
```

The response will be TRUE, if the file was created, and FALSE, if don't.

### Third Method: Save data on environment

This method will read data from secrets manager and save using putenv.

```
add_env_vars($secretId);
```

This method doesn't have any response.

## Use without helpers

If EC2 doesn't have role, you can instatiate SecretsManager and pass the the credentials to authenticate.

### First Method

Instantiating the SecretsManager class and calling the setters.

```
$secretsManager = new SecretsManager();

$secretsManager->setSecretId($secretId)
    ->setRegion($awsRegion)
    ->setId($myAwsId)
    ->setKey($myAwsKey);
```

### Second Method

Instantiating the SecretsManager with AWS credentials.

```
$secretsManager = new SecretsManager($secretId, $awsRegion, $myAwsId, $myAwsKey);
```

### And Finally

After using either of the two methods above, call the method that performs data recovery.

```
$secretValue = $secretsManager->getSecretValue();
```

### Response

The response of the method 'getSecretValue' will be something like this.

```
{
    "APP_NAME": "My App Name", 
    "APP_ENV": "production"
}
```

## Authors

* **Lucas Praxedes** - *Initial work* - [Lucas Praxedes](https://github.com/lpraxedes)

See also the list of [contributors](https://github.com/madeiramadeirabr/hagrid/graphs/contributors) who participated in this project.
