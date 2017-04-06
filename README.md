# Read More textfield formatter (read_more_formatter)
Drupal 8 _'text_with_summary'_ field formatter. Renders 'Summary' field with _'Read more'_ and _'Read less'_ buttons. Clicking _'Read more'_ button will replace _summary_ text with that in the main field. Alternatively one can user ```<!--break-->``` delimiter in the main field in which case formatter will use text above the delimiter instead of that specified in _summary_ field.

## To install this module with composer

Add the following to your local compoaser.json file and run 'composer install' command.

```json
{
    "require": {
        "avblink/read_more_formatter": "dev-master"
    },
    "extra": {
        "installer-paths": {
            "modules/contrib/{$name}/": [
                "type:drupal-module"
            ]
        }
    },
    "repositories": {
        "avblink": {
            "type": "vcs",
            "url": "https://github.com/avblink/read_more_formatter.git"
        }
    }
}

```
