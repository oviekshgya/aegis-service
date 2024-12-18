## About Author Oviek Shagya

I am a backend programmer with 4 years of experience with superior programming language skills, namely GO, Java, PHP, HTML, and Mongodb, mySql, Postgree databases with the Gin Gonic, Beego, Laravel, Echo Golang, Revel frameworks, and am able to Dockerize programs. go on the server using docker compose, applying the concepts of gRPC, redis, websocket, kafka and unit testing, Having leadership qualities and being able to manage a team and being able to work individually and in groups, quickly and precisely are my main principles

## How To Implement

```bash
# Contoh perintah instalasi
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```

## Authentication
| Key       | value                  | Type                 |
|-----------|----------------------- |----------------------|
| X-API-KEY | aegis-service-user001  | Header               |
| username  | gamecloud              | Basic Authentication |
| password  | shagya51               | Basic Authentication |


## Add Bonus API Access
```bash
curl --location 'http://localhost:8000/api/authbasic/users' \
--header 'X-API-KEY: aegis-service-user001'
```

```bash
curl --location 'http://localhost:8000/api/users' \
--header 'Content-Type: application/json' \
--header 'Authorization: Basic Z2FtZWNsb3VkOnNoYWd5YTUx' \
--header 'Cookie: XSRF-TOKEN=eyJpdiI6InZlTE9aVmcwcU5CclA3TkZrRG5DVXc9PSIsInZhbHVlIjoiaU8rL1lDN2FoSzRHNEZLa0toa2hMRGhKekNlcDd5QWFKVW5NNkpyQmFnZWhwNy8zUmJ2QXlTNCs2azN4V2d6Tm9sbC9xYzBiLzkrb1VOWkJFeS9XeWhRNWQwWHZiQTU2MDYxVU1ueVkwUG5LZHFJUWMwS3I0UzlLVHVaY2U1ci8iLCJtYWMiOiJkNzViZTlhM2M2OGMyODI3ZTAzYzk5ZjVlOTZkZmIyNmRkYzY0ZDVlNTU5MzAzNTQ1N2M1Y2YxNmUwYjMwMWNiIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6Imx2Vy93ZzhkQXJ1eE51RjQrUXJ5MUE9PSIsInZhbHVlIjoiNUljT1NJdXhIVTdDUXVDdDBjSFB0a3F0UXhJbHZnRmg2UVNsb0tGbHNpMGQ1dkRMMi9OU0R4ZVk3elJxczlEeVl3UnVzTkJmZ2VZQ1A1cmdsQlg0eERoU1UveitROTNLNFJwMVREcXAxZDg4cGFRMk0yei8relpHMUxaVnNYemIiLCJtYWMiOiJhNTc0MGJhNmFhMTA2NjJjOGIyZjZmNDQ3MmRkYjk3MjI5YjdhMWJlZjlkYzEwZTNmNDVjMjVlY2M3YmFhY2Y4IiwidGFnIjoiIn0%3D' \
--data-raw '{
    "email": "sasarnnda2106@gmail.com",
    "password": "password123",
    "name": "New User"
}
'
```

## Documentation

A. Postman
- (Postman Link) [https://documenter.getpostman.com/view/10214608/2sAYJ1m3Ag]
- Import Collections
```bash
curl --location 'http://localhost:8000/api/authbasic/users' \
--header 'X-API-KEY: aegis-service-user001'
```
