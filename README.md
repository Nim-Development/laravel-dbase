# laravel-dbase
A laravel gui tool for quickly making and migrating database migrations.

**1.Install:**
`composer require nimdevelopment/laravel-dbase`

**2. Add Serviceprovider:**
`NimDevelopment\DBase\DBaseServiceProvider::class,`

**3. Add Facade:**
`'DBase' => NimDevelopment\DBase\Facades\DBase::class,`

**4.Publish:**
`php artisan vendor:publish`


**You will find the GUI tool under route /DBase:**

![Alt text](https://project6.nimdevelopment.com/storage/upload/Screen%20Shot%202019-03-27%20at%201.15.18%20PM.png "Test")
