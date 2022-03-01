# Blog

## Docker

### Build my application
```
docker build -t p5 .
```


### Build and run the application
```
docker run -d -p 80:80 -v ${pwd}:/var/www/html p5
```

### Docker-compose
```
docker-compose up -d
```