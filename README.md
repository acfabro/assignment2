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
  * [ ] Create subscriber
  * [ ] Read subscriber
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

1. avoid using framework HTTP classes
2. just use eloquent for database
3. keep packages to a minimum
