# Yii2 AWS S3

An Amazon S3 component for Yii2.

[![Latest Stable Version](https://img.shields.io/github/v/release/aklim/yii2-aws-s3?color=green)](https://github.com/aklim/yii2-aws-s3/)
[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/aklim/yii2-aws-s3/blob/2.x/LICENSE)

> This version requires PHP 8.x

## About this project

This project allow you to work with Amazon S3 service in Yii2 application.

## Installation

1. Run the [Composer](http://getcomposer.org/download/) command to install the latest version:

    ```bash
    composer require aklim/yii2-aws-s3 ~1.0
    ```

2. Add the component to `config/main.php`

    ```php
    'components' => [
        // ...
        'yii_s3' => [
            'class' => 'bpsys\yii2\aws\s3\Service',
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => 'my-key',
                'secret' => 'my-secret',
            ],
            'region' => 'my-region',
            'defaultBucket' => 'my-bucket',
            'defaultAcl' => 'public-read',
            'defaultPresignedExpiration' => '+1 hour',
        ],
        // ...
    ],
    ```

**Credentials parameter is optional**: if you plan to use IAM roles attached to your EC2 instance there is no need for
credentials. Just remove this parameter. Just be cautious if you need those credentials, this may cause errors during
execution.

## Basic usage

### Usage of the command factory and additional params

```php
/** @var \bpsys\yii2\aws\s3\Service $s3 */
$s3 = Yii::$app->get('yii_s3');

/** @var \Aws\ResultInterface $result */
$result = $s3->commands()->get('filename.ext')->saveAs('/path/to/local/file.ext')->execute();

$result = $s3->commands()->put('filename.ext', 'body')->withContentType('text/plain')->execute();

$result = $s3->commands()->delete('filename.ext')->execute();

$result = $s3->commands()->upload('filename.ext', '/path/to/local/file.ext')->withAcl('private')->execute();

$result = $s3->commands()->restore('filename.ext', $days = 7)->execute();

$result = $s3->commands()->list('path/')->execute();

/** @var bool $exist */
$exist = $s3->commands()->exist('filename.ext')->execute();

/** @var string $url */
$url = $s3->commands()->getUrl('filename.ext')->execute();

/** @var string $signedUrl */
$signedUrl = $s3->commands()->getPresignedUrl('filename.ext', '+2 days')->execute();
```

### Short syntax

```php
/** @var \bpsys\yii2\aws\s3\Service $s3 */
$s3 = Yii::$app->get('yii_s3');

/** @var \Aws\ResultInterface $result */
$result = $s3->get('filename.ext');

$result = $s3->put('filename.ext', 'body');

$result = $s3->delete('filename.ext');

$result = $s3->upload('filename.ext', '/path/to/local/file.ext');

$result = $s3->restore('filename.ext', $days = 7);

$result = $s3->list('path/');

/** @var bool $exist */
$exist = $s3->exist('filename.ext');

/** @var string $url */
$url = $s3->getUrl('filename.ext');

/** @var string $signedUrl */
$signedUrl = $s3->getPresignedUrl('filename.ext', '+2 days'); // Pass only one parameter to get expiration date from component defaults
```

[Read more...](/docs/basic-usage.md)

## Advanced usage

```php
/** @var \bpsys\yii2\aws\s3\interfaces\Service $s3 */
$s3 = Yii::$app->get('yii_s3');

/** @var \bpsys\yii2\aws\s3\commands\GetCommand $command */
$command = $s3->create(GetCommand::class);
$command->inBucket('my-another-bucket')->byFilename('filename.ext')->saveAs('/path/to/local/file.ext');

/** @var \Aws\ResultInterface $result */
$result = $s3->execute($command);

// or async
/** @var \GuzzleHttp\Promise\PromiseInterface $promise */
$promise = $s3->execute($command->async());
```

[Read more...](/docs/advanced-usage.md)

## Using Traits

Attach the Trait to the model with some media attribute that will be saved in S3:

```php
class Person extends \yii\db\ActiveRecord
{
    use \bpsys\yii2\aws\s3\traits\S3MediaTrait;
    
    // ...
}
```

```php
$image = \yii\web\UploadedFile::getInstance( $formModel, 'my_file_attribute' );
// Save image as my_image.png on S3 at //my_bucket/images/ path
// $model->image will hold "my_image.png" after this call finish with success
$model->saveUploadedFile( $image, 'image', 'my_image.png' );

// Get the URL to the image on S3
$model->getFileUrl( 'image' );
// Get the presigned URL to the image on S3
// The default duration is "+1 day"
$model->getFilePresignedUrl( 'image' );

// Remove the file with named saved on the image attribute
// Continuing the example, here "//my_bucket/images/my_image.png" will be deleted from S3
$model->removeFile( 'image' );

// Save my_image.* to S3 on //my_bucket/images/ path
// The extension of the file will be determined by the submitted file type
// This allows multiple file types upload (png,jpg,gif,...)
$model->saveUploadedFile( $image, 'image', 'my_image', true );
```

[Read more...](/docs/media-traits.md)

## License

Yii2 AWS S3 is licensed under the MIT License.

See the [LICENSE](LICENSE) file for more information.
