# Hagrid

Simplified integration with AWS Secrets Manager.

## Getting Started

The purpose of this package is to simplify integration with AWS Secrets Manager, providing an easy way to retrive data
stored.

All helpers considers that you have an role in EC2. This role must be allowed to access secrets manager. If EC2 don't have
role to access SM, you need to create you own helpers using qws id and key to authenticate. All methods are explained here.

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
{"APP_NAME": "My App Name", "APP_ENV": "production"}
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

This method don't have any response.

## Authors

* **Lucas Praxedes** - *Initial work* - [Lucas Praxedes](https://github.com/kumasekuraprax)

See also the list of [contributors](https://github.com/madeiramadeirabr/hagrid/graphs/contributors) who participated in this project.
