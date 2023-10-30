# DOCKER TUTORIAL

A docker environment is available with this project.

All the services configs are located in .env in DOCKER section.

It's highly recommended to override them by more secure values.

Once your values are updated, you can simply launch the app with `docker-compose up`

By default, the local server is available at http://localhost:8080/ and the database at 127.0.0.1:33016.

To access database, you will need a tool like TablePlus. (@todo add phpmyadmin in docker-compose ?)

For the rest, it's just like any of symfony project. You code as usual in `src/`, install composer dependencies with composer command and put your public files in public folder, all is handled by the apache conf of docker.
