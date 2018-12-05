# Todo list:

## Layout
1. Front-end
* Landing page
    - [ ] Video streaming
    - [ ] Login page
    - [ ] Subscribe page
    - [ ] iFrame embeded schedule form
    - [ ] Announcement table
* Showcase
    - [ ] Photo table
    - [ ] Inspect detail

2. Back-end
    - [ ] Viewer template
    - [ ] Create and edit pages
    - [ ] (?) Embeded outlook calendar
## Third party services
- [ ] Airtable API
- [ ] Youtube video streaming
- [ ] Outlook API(calendar and email service)
- [ ] Sending Email via Google account and upload image on googledrive

## Back-end
- [x] Wrap up all APIs and check user session before request to airtable
- [ ] Link all data into front end
- [ ] Send an email to subscribers when a stuff post a new announcement
- [x] Encrypt session
- [ ] Exception/Error handle


---
## API Doc
### Current tables and schema on Airtable
* users
    * username
    * account
    * password
    * sess
    * last_login_time
    * user_phone
* events
    * event_name
    * event_date
    * event_type
    * event_topic
    * event_description
* videos
    * video_title
    * video_url
    * video_time
* showcase
    * showcase_title
    * showcase_author
    * showcase_description
    * showcase_time
    * showcase_imageurl
* subscribers
    * subscriber_name
    * subscriber_email
    * subscriber_preference
    * subscriber_isActive
* devices
    * device_name
    * device_isWorking
    * device_isAvailable
* logs
    * user_id
    * user_name
    * working_machine
    * start_time
    * end_time
    * timestamp

### How to use:

## **URL = baseurl + table name + fields(or parameters) + sess**
- **baseurl:** localhost/isd_final/connection/index.php

- **fields(optional, provided by airtable):**
    - **fields(string array):** to filter return data with certain column
    - **maxRecord(number):** The maximum total number of records that will be returned in your requests. If this value is larger than pageSize (which is 100 by default), you may have to load multiple pages to reach this total. See the Pagination section below for more.
    - **pageSize(number):** The number of records returned in each request. Must be less than or equal to 100. Default is 100. See the Pagination section below for more.
    - **offset(string):** If there are more records, the response will contain an offset. To fetch the next page of records, include offset in the next request's parameters.
- **sess(must):** Return from server when user login.


---

#### Example:
-- Get user list(method: GET):
http://localhost/isd_final/connection/index.php/users

-- Get one specific user data(method: GET):
http://localhost/isd_final/connection/index.php/users/rec0eMTQiJn7JxDHn

-- POST a new date(method: POST):
http://localhost/isd_final/connection/index.php/users/
parameters in body with json format:
```
{
    "username": "Eden",
    "account": "cas386@pitt.edu",
    "password": "1234",
    "user_phone": "122312312"
}
```

-- UPDATE data(method: PUT):
http://localhost/isd_final/connection/index.php/users/rec0eMTQiJn7JxDHn
parameters in body with json format:
```
{
    "username": "Adam"
    "user_phone": "122312312"
}
```
-- DELETE data(method: DELETE):
http://localhost/isd_final/connection/index.php/users/rec0eMTQiJn7JxDHn


---

#### Response:
- Request succeeded:
```
{
    "code":200
    "data": {
        "sess": "wjfiowqjfiojfioqw1232",
        "username": "Eden"
    }
}
```

- Request failed:
```
{
    "code":404
    "msg": "Something wrong!"
}
```

---
#### Login API
url: http://localhost/isd_final/connection/index.php/users/login?account=demo@pitt.edu&password=1234

response:
```
{
    "code":200,
    "data": {
             "sess":"rFIAeA83nEiBOMHCLY3zvRNJq0P8gLb8XXhYWg1oGSyutWVVYagLFO6Uooy8LhJrmhh7sIYRYqwPz9sMQpcLNg==",
             "username":"staffA",
             "id":"recKxzLdiLvhgga16"
             }
}
```
