sandbox for nette 2.1
=======
Original nette/sandbox: https://github.com/nette/sandbox

Main differences
----
- Admin & Front modules by default (including routes)
- custom ErrorPresenter for each module (including nested modules)
- composer and robotloader are now more synced
  - changed composer vendor dir to libs/composer
  - netterobots.txt disallows libs/composer
- app dir reorganized
  - app/modules for custom app modules
  - app/services contains all services defined in config.neon
- custom dependencies
  - LeanMapper
  - Nextras
  - WebLoader
  - CssMin
  - dibi

Install
----
via Composer

    composer create-project castamir/sandbox sandbox

Licence
----
BSD-3-Clause, GPL-2.0, GPL-3.0 (see https://github.com/nette/sandbox)
