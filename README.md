## Getting Started

### Install Steps

Clone repository to the common place:

```bash
git clone https://github.com/igarek644/MyEzJob.git
```

 Build application image

```bash
make build
```

Start application

Finally start project using command as follows:

```bash
make up
```
Create .env
```bash
cp .env.dist .env
```
Install dependencies:

```bash
make install
```

Run migrations:
```
docker exec -it myezjob_app_1 php bin/console doctrine:migrations:migrate

```
Populate elastic:
```
docker exec -it myezjob_app_1 php bin/console fos:elastica:populate
```


### Examples:

Create article 
```bash
curl -X POST "127.0.0.1:81/api/v1/articles" -d '{"title":"1", "description":"description"}' -H 'Content-Type: application/json'
```

Get articles collection
```
curl -X GET "127.0.0.1:81/api/v1/articles?q=test"  -H 'Content-Type: application/json'
```

Edit article
```
curl -X PUT "127.0.0.1:81/api/v1/articles/1" -d '{"title":"new_title","description":"new_description"}'  -H 'Content-Type: application/json'
```
Create tag
```
curl -X POST "127.0.0.1:81/api/v1/tags" -d '{"name":"tag_name"}'  -H 'Content-Type: application/json'

```
Get tag by name
```
curl -X GET "127.0.0.1:81/api/v1/tags/tagname" -H 'Content-Type: application/json'
```
Add article tag
```
curl -X POST "127.0.0.1:81/api/v1/articles/1/tags" -d '{"tag_id":1}' -H 'Content-Type: application/json'
```
Remove article tag
```
curl -X POST "127.0.0.1:81/api/v1/articles/1/tags" -d '{"tag_id":1}' -H 'Content-Type: application/json'```