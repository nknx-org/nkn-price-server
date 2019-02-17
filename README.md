# NKN price-server
A little server for regularly querying the CMC API and providing a neat query interface for getting history data written in Laravel.

## Installation
1. Install the dependencies:
     ```
     composer install
     ```

2. Set up your environment file
3. Generate an app key:
     ```
     php artisan key:generate
     ```

4. Add the Variable ``CMC_API_KEY`` to your laravel ENV-file like this:
    ```
    CMC_API_KEY="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
    ```
5. Run migration:
    ```
    php artisan migrate
    ```

6. Done!


## Running the import script by hand
```
php artisan schedule:run
```
