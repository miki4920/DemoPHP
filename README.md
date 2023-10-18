# PHP Demo

## Requirements

* PHP (Tested with 8.2)
* MySQL Server
* Composer - Dependency Management (https://getcomposer.org/)

## Installation & Configuration

Follow these steps to get your development environment set up:

1. Clone the repository:

```bash
git clone https://github.com/miki4920/DemoPHP.git
```

2. Navigate to the project folder:

```bash
cd DemoPHP
```

3. Update the `secret.php` file with your database information. You will need to provide:
   - `host` - Your database's hostname and port
   - `db_name` - The name of your database schema

4. Ensure that the PDO extension is enabled in your PHP environment. If it's not, you will need to add the following line to your `php.ini` file (this file is typically located in the PHP compiler folder):

```ini
extension=php_pdo_mysql.dll
```

5. Use Composer to install dependencies and autoload your classes:

```bash
composer dump-autoload
```

6. Navigate to the Public directory of the project:

```bash
cd Public
```

7. Start the PHP server:

```bash
php -S localhost:8000
```

## Usage

After following the installation steps, your project should now be running on [http://localhost:8000](http://localhost:8000). From here, you can interact with your application through your web browser.
