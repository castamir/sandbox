sandbox
=======
Original nette/sandbox: https://github.com/nette/sandbox

Main differences:
- Admin & Front modules by default (including routes)
- custom ErrorPresenter for each module (including nested modules) - here should be name of a nice guy, who send me this addon, but i have fotgot his name =(
- composer and robotloader are now more synced
  - changed composer vendor dir to libs/composer
  - netterobots.txt disallows libs/composer
- app dir reorganized
  - app/config => app/setup
  - app/modules for custom app modules
  - app/services containf all services defined in config.neon