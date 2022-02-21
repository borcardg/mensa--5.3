**App Mensa API v1**
----
  Returns json data about today's menus or weekly menus.
  
  
### Get sites information
Returns json data about sites.

* **URL**

  /api/v1/sites?:lang

* **Method:**

  `GET`
  
*  **URL Params** 

   **Optional:**
 
   `lang=[default: fr|de]`

* **Success Response:**
  
  <_What should the status code be on success and is there any returned data? This is useful when people need to to know what their callbacks should expect!_>

  * **Code:** 200 <br />
    **Content:** 
    ```json
    {
      "error":false,
      "sites":[{
        "id":1,
        "isCafet":0,
        "created_at":"2017-04-27 13:14:06",
        "updated_at":"2017-05-15 11:58:58",
        "name":"Mensa Mis\u00e9ricorde fr",
        "address":"<p>address fr<\/p>"
      }],
      "status_code":200
    }
    ```
    
### Get a site information
Returns json data about specific site.

* **URL**

  /api/v1/sites/:id/?:lang

* **Method:**

  `GET`
  
*  **URL Params** 

   **Required:**
    
   `id=[integer]`

   **Optional:**
 
   `lang=[default: fr|de]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
    {
      "error":false,
      "site":{
        "id":1,
        "isCafet":0,
        "created_at":"2017-04-27 13:14:06",
        "updated_at":"2017-05-15 11:58:58",
        "name":"Mensa Mis\u00e9ricorde fr",
        "address":"<p>address fr<\/p>"
      },
      "status_code":200
    }
    ```

* **Error Response:**

  * **Code:** 404 <br />
    **Content:** `{ error : "Site doesn't exist" }`


### Get menus of the day
Returns json data about menus of the day for a specific site that is not a cafeteria.

* **URL**

  /api/v1/menus/?:id_site&:lang&:period&:limit

* **Method:**

  `GET`
  
*  **URL Params** 

   **Required:**
    
   `id_site=[integer]`

   **Optional:**
 
   `lang=[default: fr|de]` <br/>
   `period=[default: 1|0]` (1 = noon, 0 = evening)<br/>
   `limit=[default: 2|integer]` (allows to limit the number of menus to show for a site)

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    
    In case there is no menus and notices today:
    ```json
    {
      "error":false,
      "site":{
        "id":1,
        "isCafet":0,
        "menus": null,
        "notices": null,
        "created_at":"2017-04-27 13:14:06",
        "updated_at":"2017-05-15 11:58:58",
        "name":"Mensa Mis\u00e9ricorde fr",
        "address":"<p>address fr<\/p>"
      },
      "status_code":200
    }
    ```
    
    In case there are menus and notices today:
    ```json
    {
      "error":false,
      "site":{
        "id":1,
        "isCafet":0,
        "created_at":"2017-04-27 13:14:06",
        "updated_at":"2017-05-15 11:58:58",
        "menus":[
          {
            "id":26,
            "date_start":"2017-05-03",
            "date_end":"2017-05-05",
            "period":1,
            "title":"ASDasd",
            "accompaniment":"<p>asd-asd-asd<\/p>",
            "label":"Menu 1",
            "price":"9.60",
            "order":100
          }
        ],
        "notices":[
          {
            "id":4,
            "title":"Notice titel fr",
            "content":"<p>asdasd<\/p>",
            "isImportant":0
          }
        ],
        "name":"Mensa Mis\u00e9ricorde fr",
        "address":"<p>address fr<\/p>"
      },
      "date":"2017-05-03",
      "status_code":200
    }
    ```

* **Error Response:**

  * **Code:** 404 <br />
    **Content:** `{ error : "Site doesn't exist" }`
    
  * **Code:** 404 <br />
    **Content:** `{ error : "The site is a cafeteria, no menus to show" }`

* **Notes:**

  If the specified date is a saturday or sunday, the "today" menus of next monday will be shown.



### Get menus of the week
Returns json data about menus of the week for a specific day for each site that is not a cafeteria. Several calls have to be made (one for each day of the week) to obtain the complete list of weekly menus for each site.

* **URL**

  /api/v1/weekly-menus/?:lang&:date

* **Method:**

  `GET`
  
*  **URL Params** 

   **Optional:**
 
   `lang=[default: fr|de]` <br/>
   `date=[default: today]` (format: yyyy-mm-dd, ex: 2017-05-26)

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
    {
      "error":false,
      "sites":[
        {
          "id":1,
          "name":"Mensa Mis\u00e9ricorde fr",
          "menus":[
            {
              "id":26,
              "date_start":"2017-05-03",
              "date_end":"2017-05-05",
              "period":1,
              "title":"ASDasd",
              "accompaniment":"<p>asd-asd-asd<\/p>",
              "label":"Menu 1",
              "price":"9.60",
              "order":100
            },
            {
              "id":31,
                "date_start":"2017-05-03",
                "date_end":"2017-05-03",
                "period":0,
                "title":"ASDasd",
                "accompaniment":"asd-asd-asd",
                "label":"Menu 1",
                "price":"9.60",
                "order":100
            }
          ],
          "notices":[
            {
              "id":4,
              "title":"Notice titel fr",
              "content":"<p>asdasd<\/p>",
              "isImportant":0
            }
          ],
          "address":"<p>address fr<\/p>"
        },
        {
          "id":3,
          "name":"Mens P\u00e9rolles fr",
          "menus":null,
          "notices":null,
          "address":"<p>asdasd<\/p>"
        }
      ],
      "startOfWeek":"01.05.2017",
      "endOfWeek":"07.05.2017",
      "status_code":200
    }
    ```

* **Notes:**

  If the specified date is a saturday or sunday, the weekly menus of next week will be shown. 