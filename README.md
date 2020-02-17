# Programming assignment

Challenges:
1. No framework, only packages allowed
2. Object relation modeling
3. JSON REST API
4. Frontend to use the APIs
5. Time constrained
6. Optional: redis and unit tests
7. As instructed "Validate request before calling the controller"

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