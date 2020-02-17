# Programming assignment

Challenges:
1. No framework, only packages allowed
2. Object relation modeling
3. JSON REST API
4. Frontend to use the APIs
5. Time constrained
6. Optional: redis and unit tests
7. As instructed "Validate request before calling the controller"

## Requirements met

* [x] When creating a subscriber email must be in valid format and host domain must be active

`app/Requests/CreateSubscriberRequest.php`
```php
// check is email is valid
$emailValidator = new EmailValidator();
if (!$emailValidator->isValid(
    $this->getParam('email'),
    new MultipleValidationWithAnd(
        [
            new RFCValidation(),
            new DNSCheckValidation(),
            new SpoofCheckValidation(),
        ]
    )
)) {
    throw new ClientSideException('Please enter a valid email address');
}
```

* [x] No framework but you can use packages
```json
"require": {
    "symfony/dotenv": "^5.0",
    "illuminate/database": "^6.15",
    "egulias/email-validator": "^2.1",
    "ext-json": "*"
}
```

* [x] HTTP JSON API
* [x] MySQL
* [x] Use of relationships
```php
/**
 * The subscriber's fields
 * @return HasMany
 */
public function fields()
{
    return $this->hasMany(Field::class, 'subscriber_id', 'id');
}
```

* [x] Validate request before calling the controller
```php
Route::post('/^\/api\/field/', function (Request $request) {
    $controller = App::container(FieldController::class);
    $createFieldRequest = new CreateFieldRequest($request);
    $result = $createFieldRequest->validate(); // as instructed validate before sending to controller

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->create($createFieldRequest);
});
```
* [x] Instructions how to run a project on local environment

Check the [deplpoyment repo](https://github.com/acfabro/assignment2-deployment) for instructions.

* [x] PSR-12 compliant source code
* [x] Optional: Redis for caching

```php
// check the cache and return the result if in cache
$cacheKey = "subscriber-{$id}";
$data = RedisCache::instance()->get($cacheKey);
if (!empty($data)) {
    return new Response(200, null, unserialize($data));
}

```

* [x] Optional: Write some tests

Check `tests/` directory.

## Tasks

**Prep:**

* [x] Strategy
* [X] Data modeling

**Backend:**

* [x] Bootstrapping
* [x] Entities
  * [x] Fields
  * [x] Subscribers
  * [x] Entity relationship problem
* [x] Use Cases - Fields
  * [x] Create field
  * [x] Read field
  * [x] Update field
  * [x] Delete field
* [x] Use Cases - Subscribers
  * [x] Create subscriber
  * [x] Read subscriber
  * [x] Update subscriber
  * [x] Delete subscriber
* [x] Use Cases - management
  * [x] Subscriber adds field
  * [x] Subscriber removes field
  
**Optionals:**

* [x] Unit Tests
* [x] Add Redis to repositories
* [x] Dockerize the test app

## Data model

Subscriber
- id
- email
- name
- state

Field
- id
- subscriber id
- title
- type
- value

## Strategy

1. do not use a framework, as instructed
2. READABILITY is key
3. avoid framework http classes, need to write my own
4. just use eloquent for database make it easy to read
5. keep packages to a minimum

## Differences of output vs. actual commercial work

1. Framework will be used, any
2. Logging
3. Clean architecture
4. routes file will be divided into groups
5. will be using more validation rules