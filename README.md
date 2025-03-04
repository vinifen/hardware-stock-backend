# Hardware-Stock Backend
#### v-alpha-1.0

Hardware stock is a web project where you can store, edit and delete hardwares, brands and categories. It was developed with the aim of improving web development skills.

This is the backend part of the project, here PHP was used with the Controller and Models pattern with FastRoute, to do the routing JWT tokens were used for authentication using the strategy with session and refresh tokens and for the database PostgreSQL was used. You can access the repository with the entire project below (in development):

- full project: https://github.com/vinifen/hardware-stock

## Installation:

For a complete and simplified installation, it is recommended to use the full version and follow the instructions in the corresponding repository.

### Clone the repository:

```bash
git clone https://github.com/vinifen/hardware-stock-backend.git
```

### Create the database:

After cloning the repository, you will find the hardware_stock_postgresql.sql file inside the db folder.
This project is using postgresql that you can install [here](https://www.postgresql.org/download/). 

On postgresql, open your database client, copy the commands from the SQL file, and execute them.


### Create .env

Create a `.env` file in the project's root directory for general configuration.
Follow the [.env.example](./.env.example) file structure.

### Install dependencies:

```bash
composer install
```

### Run the application:

```bash
php -S localhost:1122
```




