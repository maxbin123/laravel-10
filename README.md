## Real-time Stock Price Aggregator

## Getting started

- Clone the repo
- copy `env.example` to `.env`
- set the environment variables in `.env`
- `composer install`
- migrate and seed the database with `php artisan migrate`
- `npm install`
- `npm run dev`
- run `php artisan schedule:run`, `php artisan websockets:serve`, `php artisan queue:work` and `php artisan serve`

## Decisions
- To build real-time reporting we brought the broadcasting with websockets Laravel feature.
- Redis with standard Laravel caching facade used to cache price values.
- A batch of jobs running every minute for each symbol is used to update all the data. 


## TODO: 
- The frontend is not finished
