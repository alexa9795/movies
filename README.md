* store data from "https://mgtechtest.blob.core.windows.net/files/showcase.json" into a json file, movie.json, in public folder

* edit DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name" from .env file to configure database;
set db_user to root, db_password to admin, db_name to movies and serverVersion=5.7;

* access localhost:8000;
  - if no data was save in db, this will read json file, store data in db, and redirect to list page
  - if some data exists in db, prevent adding duplicate entities (movieId is unique), store data in db if any and redirect to list page
  - if any new movie was added to json file, it will be add to db and then user will be redirected to list page

* list page shows some basic info about every movie (Headline, Directors, Cast, Year,	Cert, Duration, Genres, ReviewAuthor, Rating) and a "More info" button;

* "More info" redirects to http://localhost:8000/list/{movieId} and shows all data about specific movie;
