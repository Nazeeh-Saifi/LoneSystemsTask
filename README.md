<p align="center"><a href="http://www.l-one.de/" target="_blank"><img src="./lone.png" width="400"></a></p>

## LONE SYSTEMS TASK

#### in order to run this project please follow the instructions:

1.  running the backend(lOneSystemsApp):

    - copy (.env.example) file and rename it (.env)

    - insert your database credentials and mail configuration ( I've used mailtrap to test sending emails )

    - open terminal and navigate to lOneSystemsApp directory

    - run the following commands:

      - composer install
      - php artisan key:generate <b>(important step for encryption)</b>
      - php artisan migrate
      - php run serve

    - the backend should be Up & Running!

2.  running the frontend(vue_frontend):

    - open terminal and navigate to vue_frontend directory

    - run the following commands:

      - npm install
      - npm run serve

    - the frontend should be Up & Running!

#### <b> Note: </b> please make sure that the backend api is running on this address: http://127.0.0.1:8000 otherwise you need specify the address in vue_frontend/src/main.js
