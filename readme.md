## WeatherTrack Application

---
 
---
### Getting Started

Perform the following steps to get started with the coding simulation.

- Install Docker Desktop from https://www.docker.com/products/docker-desktop
- Clone this repo onto your development machine.
- Setup your working environment by executing the following commands

```
cd <wthr repo directory>
git submodule update --init --recursive
cp laradock-env laradock/.env
cp createdb.sql laradock/mariadb/docker-entrypoint-initdb.d/. 
cd laradock
docker-compose build --no-cache nginx workspace mariadb
docker-compose up -d nginx mariadb workspace
docker-compose exec workspace composer install
docker-compose exec workspace npm install
docker-compose exec workspace php artisan migrate
``` 

If You have any issues with python libraries (on MacOS M1 computers) before `npm install` run:
```
docker-compose exec workspace apt-get update
docker-compose exec workspace apt-get install python
```

At this point you can open http://localhost:8888/ and start using the mock-API backed application. As a first step, you
should click ‘Register’ in the upper right to create an account and enter the application. 

Should you make changes to
any of the JS files, such as /resources/assets/js/wthrAPI.js, you can run the following in order to compile your changes
```
cd <wthr repo directory>/laradock
docker-compose exec workspace npm run dev 
```
Or to watch for any JS changes you can run
```
cd <wthr repo directory>/laradock
docker-compose exec workspace npm run watch 
```

Commit your changes locally and when finished, publish your repo on your public bitbucket or github account.

**GOOD LUCK!**
