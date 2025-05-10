# Payroll Calculator App
## Get Started
- Run `composer install`
- Copy `.env.example` to `.env`
  - Change `SESSION_DRIVER` to `file` - a database isn't needed for this project
- Run `./vendor/bin/sail up -d` to start the docker container
- Run `./vendor/bin/sail artisan key:generate` to generate an application key
- Run `npm install`, then `npm build` to build the JS assets
- View application in your browser - http://127.0.0.1 or http://localhost

## Unit Tests
- Run `./vendor/bin/sail test` to run test suite

## Notes
This application was built using Laravel purely as it was needed to be delivered under time constraints. It's incredible feature heavy given the limited nature of the task but it got it moving quickly.

I chose to use VueJS simply as I'd worked with it before, although a little rusty.

I used an AI prompt to bounce solutions off - I knew a pattern would keep the code extensible and testable and on first pass it was adament that just a Strategy pattern was fine. Amending the date using a Decorator felt more suitable to the challenge, though.

This is something I do a lot day to day, as well as things like prototype building. It's become hard to ignore the tooling ...

Note the missing JS and E2E tests - I ran out of time, but happy to discuss their merits and place in the SDLC. 