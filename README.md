# scandiweb-subscribersvalidator

Module functionality:      
- get all newsletter subscribers e-mail address
- validate e-mail addresses
- write validation failed e-mails to the log file

**Setup**

```php
composer require git-user-kriss/subscribersvalidator
bin/magento setup:upgrade
```

**How to use functionality**

run command

```php
bin/magento subscribers:validation
```

which will create a new log file at '/var/log/suspicious-emails.log' and store suspicious e-mail address
