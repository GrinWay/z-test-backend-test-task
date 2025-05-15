### Description

[task](https://github.com/bigfootdary/z-test-backend)

### Installation

Make suer you have installed the following programms on your PC:
- [php](https://www.php.net/downloads.php)
- [composer](https://getcomposer.org/download/)
- [docker](https://www.docker.com/products/docker-desktop/)
- [git_bash](https://git-scm.com/downloads) `Can come in handy if you use Windows`

Open git_bash terminal on windows or native linux one and execute:

```console
git clone https://github.com/GrinWay/z-test-backend-test-task && cd z-test-backend-test-task && ./init.sh
```

Everything will be installed automatically ❤️

### Usage

First you need to create your access token to access the http://localhost/api

For this open [phpmyadmin](http://localhost:8080) and enter

| SERVER      | USER   | PASSWORD |
|-------------|--------|----------|
| `z_task_db` | `root` | `root`   |

Create a new user and then a new api_token (connected with user, token equals 123 for instance) via [phpmyadmin](http://localhost:8080)

Access the http://localhost/api?access_token=123

Then you can import fake data from `test_task_data.csv` into `Tender` table using the following command:
```console
php bin/console app:mysql:import_csv tender
```

There are three `Tender` operations accessible:
- Get Tender - To get a certain tender
- GetCollection - To get a collection of tenders
- Post - To create a new Tender

Enjoy 😘
