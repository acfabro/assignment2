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
* [ ] Use Cases - Fields
  * [ ] Create field
  * [ ] Read field
  * [ ] Update field
  * [ ] Delete field
* [ ] Use Cases - Subscribers
  * [x] Create subscriber
  * [x] Read subscriber
  * [ ] Update subscriber
  * [ ] Delete subscriber
* [ ] Use Cases - management
  * [ ] Subscriber adds field
  * [ ] Subscriber removes field
  
**Frontend:**

* [ ] Manage fields
  * [ ] Create field
  * [ ] Read field
  * [ ] Update field
  * [ ] Delete field
* [ ] Manage subscribers
  * [ ] Create field
  * [ ] Read field
  * [ ] Update field
  * [ ] Delete field

**Optionals:**

* [ ] Unit Tests
* [ ] Add Redis to repositories
* [ ] Dockerize the test app

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

## Differences from actual commercial work

1. Framework will be used, any
2. Logging
3. Clean architecture
4. routes file will be divided into groups
