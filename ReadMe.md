# Symfony movie api

## setup

```bash
docker-compose up -d
```

```bash
docker-compose exec php composer update 
```

```bash
docker-compose exec php composer install 
```

```bash
cp .env.example .env
````
define env variables

## Endpoints
____

### Request
`POST search/movie`

Search for movies.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `query`             | string  | yes       | Search term |
| `page`             | int     | no        | Page
| `language` | string  | no        | Language code, defaults to "en-US"
| `include_adult` | boolean | no        | If results should include adult content
____

### Request
`POST search/tv`

Search for tv shows.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `query`             | string  | yes       | Search term |
| `page`             | int     | no        | Page
| `language` | string  | no        | Language code, defaults to "en-US"
| `include_adult` | boolean | no        | If results should include adult content
____

### Request
`POST search/person`

Search for people.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `query`             | string  | yes       | Search term |
| `page`             | int     | no        | Page
| `language` | string  | no        | Language code, defaults to "en-US"
| `include_adult` | boolean | no        | If results should include adult content
____

### Request
`POST search/multi`

Searches movies, tv shows and people.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `query`             | string  | yes       | Search term |
| `page`             | int     | no        | Page
| `language` | string  | no        | Language code, defaults to "en-US"
| `include_adult` | boolean | no        | If results should include adult content
____

### Request
`GET movie/{id}`

Gets info and videos about movie.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `language` | string  | no        | Language code, defaults to "en-US"
____

### Request
`GET tv/{id}`

Gets info and videos about the tv show.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `language` | string  | no        | Language code, defaults to "en-US"
____

### Request
`GET person/{id}`

Gets info and videos about the person.

#### Request Headers
`Content-Type:application/json`

#### Request Body

| Object Field       | Type    | Required? | Description |
|--------------------|---------|-----------|-------------|
| `language` | string  | no        | Language code, defaults to "en-US"
____