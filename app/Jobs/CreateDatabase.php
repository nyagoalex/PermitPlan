<?php

   declare(strict_types=1);

    namespace App\Jobs;

    use App\Helpers\CPANEL;
    use Stancl\Tenancy\Database\DatabaseManager;
    use Stancl\Tenancy\Events\CreatingDatabase;
    use Stancl\Tenancy\Events\DatabaseCreated;
    use Stancl\Tenancy\Jobs\CreateDatabase as BaseCreateDatabase;

    class CreateDatabase extends BaseCreateDatabase
   {

       public function handle(DatabaseManager $databaseManager)
       {
           event(new CreatingDatabase($this->tenant));

           if ($this->tenant->getInternal('create_database') !== false) {
               $databaseManager->ensureTenantCanBeCreated($this->tenant);
               $this->createDBWithCpanel();

               event(new DatabaseCreated($this->tenant));
           }

       }

        protected function createDBWithCpanel()
        {
            // Instantiate the CPANEL object.
            $cpanel = new CPANEL();// Connect to cPanel - only do this once.

            $cpanel->uapi('Mysql', 'create_database',  ['name' => $this->tenant]);

             $cpanel->uapi(
                'Mysql', 'set_privileges_on_database',
                array(
                    'user'       => config('database.connections.mysql.username'),
                    'database'   => $this->tenant,
                    'privileges' => 'ALL PRIVILEGES',
                )
            );

            $cpanel->end(); // Disconnect from cPanel - only do this once.
        }
    }
