# JUDA PRIVACY

## Documentation

- commandes

```bash
symfony new juga_privacy
cd juga_privacy
symfony server:start
symfony server:run

rd /s /q node_modules
del package-lock.json
npx tailwindcss init -p

php bin/console cache:clear

php bin/console make:entity --regenerate App

php bin/console doctrine:fixtures:load

```

- Migrations

``bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

git add .
git commit -m "Commit 1.0.1"
git branch -M main
git remote add origin https://github.com/adamaniada/juga_privacy.git
git push -u origin main
