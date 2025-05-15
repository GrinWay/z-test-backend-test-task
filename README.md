### What it for?

[Task](https://github.com/bigfootdary/z-test-backend)

Overall it's a docker based RESTful API application for `Tender`

Let's call it a microservice 😉

### Installation

Make sure you have installed the following programs on your PC:

- [php](https://www.php.net/downloads.php)
- [composer](https://getcomposer.org/download/)
- [docker](https://www.docker.com/products/docker-desktop/)
- [git_bash](https://git-scm.com/downloads) `If you use Windows`

Open `git_bash` on windows or a native linux terminal and execute:

```console
git clone https://github.com/GrinWay/z-test-backend-test-task && cd z-test-backend-test-task && ./init.sh
```

❤️ Everything will be installed automatically ❤️

### Usage

First you need to create your access token to access the [application](http://localhost/api)

For this open [phpmyadmin](http://localhost:8080) and enter

| SERVER      | USER   | PASSWORD |
|-------------|--------|----------|
| `z_task_db` | `root` | `root`   |

Create a new user and then a new api_token (connected with user, token equals 123 for instance)
via [phpmyadmin](http://localhost:8080)

Access the http://localhost/api?access_token=123

Then you can import fake data from `test_task_data.csv` into `Tender` table using the following command:

```console
php bin/console app:mysql:import_csv tender
```

There are three `Tender` operations accessible:

| OPERATION       | DESCRIPTION                      |
|-----------------|----------------------------------|
| `Get`           | To get a certain `Tender`        |
| `Post`          | To create a new `Tender`         |
| `GetCollection` | To get a collection of `Tender`s |

Done 👌 Enjoy 😘

### Advanced

You can enter the application docker container (by executing in the `z-test-backend-test-task` directory):

```console
docker exec -it z_app bash
```

Or even to stop the application (by executing in the `z-test-backend-test-task` directory):

```console
docker compose down
```
