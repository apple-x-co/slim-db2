# slim-application

db slim application

```bash
composer install
cp -ap config/.env.prod config/.env
```

```bash
composer dump-autoload
```

```bash
php vendor/bin/doctrine orm:convert:mapping --namespace="App\Entity\\" --from-database yml config/doctrine
php vendor/bin/doctrine orm:generate-entities src/Entity/
```

local site

`http://localhost/`

## library

Doctrine
https://www.doctrine-project.org/projects/doctrine-orm/en/latest/