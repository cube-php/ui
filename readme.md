# PHP Cube UI

This package, though usable, is still in testing phase.

- Install package:

```
composer require cube-php/ui
```

- After installing package, you will need to setup

```
php cube ui:setup
```

- Add `vite` function in functions array inside `config/view.php`

- Add `VITE_PORT=5173` in `env.dev` file to set vite port

- Run the command below for dev and production build

```
// dev build
npx vite

//production build
npx vite build
```

To use production build, set `env` to `production`
