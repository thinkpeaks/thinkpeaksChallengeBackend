# Think Peaks Asteroid Challenge	
Hi !
Welcome to Think Peaks asteroid challenge.

## There is no such challenge without rules
- Explode Asteroids to gain points
- Points received depends on asteroid size (the smaller the higher)
- The person with the highest score will win the challenge 
- You have the right to cheat

# About the code source.

This is a simple Symfony V4 backend.

It is connected to a Mysql Server to log points.
A Node react frontend interact with this backend.
We use FOSRestBundle for the RestFullServer.
Browse the source code we hope you will learn a few things :)

* Code source of frontend is available here: https://github.com/thinkpeaks/thinkpeaksChallengeFrontend
* Code source of backend is available here: https://github.com/thinkpeaks/thinkpeaksChallengeBackend

### Development

Pull request are accepted for sure !

### Installation

With composer like a simple symfony project.

```
git clone https://github.com/thinkpeaks/thinkpeaksChallengeBackend
cd thinkpeaksChallengeBackend
mkdir src/AppBundle/Controller/
composer install
php bin/console doctrine:schema:update --force  --env=prod
```

Note that the frontend secret should be the same that in the Frontend sources.

#### Running the application
If you use PHP-FPM you can just run 
```
php bin/console server:start         
[OK] Server listening on http://127.0.0.1:8001     
```
Otherwise you will have to create a virtual server on your application server.

### Challenges

 - **Challenge A**: Hack the game and make the highest score here: https://challenge.thinkpeaks.com/
   * Done : [Hack3d](/challenge/step1-done.png)
 - **Challenge B**: Write Tests
   * Done (unit tests + some integration test -> /api/players/* routes)
 - **Challenge C**: Integrate PushBullet
 - **Challenge E**: Send an email to challenge@thinkpeaks.com each time a new email play the game
 - **Challenge F**: Publish RestFul Api Doc on backend api/doc endpoint
 - **Challenge G**: Develop an endpoint that lists game scores (and some info, like the last game played) per user
   * Done
 - **Challenge H**: Develop /admin/ban endpoint that allows to ban specific email address
 - **Challenge I**: Migrate to the last Symfony Version
   * Done : [06d9e16](https://github.com/david-vde/thinkpeaksChallengeBackend/commit/06d9e16c2fcac5b45a9eee308108354ebbc825f2)
 - **Challenge J**: Surprise us !


### Run tests

Make runtests bin executable 

```
chmod +x ./bin/runtests
```

Then run the tests: 

```
./bin/runtests
```

### Credits
Think Peaks 

License
----

CC0 1.0 Universal

