![image](https://user-images.githubusercontent.com/54909696/144947502-ef90f2a8-efcb-415d-b30d-5eba9d56fa65.png)
# <p align="center">🟣 Project 6 : Develop SnowTricks community site 🟣</p>
[![SymfonyInsight](https://insight.symfony.com/projects/2341af49-e3dc-413e-8baf-b4bbd849e522/big.svg)](https://insight.symfony.com/projects/2341af49-e3dc-413e-8baf-b4bbd849e522)

## 🧩 Prerequisites

The project use the Symfony 6 Framework and PHP 8.0 or higher.


## 📌️ Install steps

**1.** First you need to copy the repository by using `git clone https://github.com/ledukilian/LeduKilian_6_11122021`

**2.** Use `composer install` command to install required packages

**3.** Configure database link in the `.env` file located in the root folder

**4.** Start the server with `php bin/console server:start`

## ⚙️ Database

**1.** Create database with `php bin/console doctrine:database:create`

**2.** Update the database schema with `php bin/console doctrine:schema:update --force`

You can use intial fixtures dataset with : `php bin/console doctrine:fixtures:load`

    

## 🔐 First login
If you use the fixtures, you can use the admin account for the first login :

- [ ] **Email** : `admin@snowtricks.fr`
- [ ] **Password** : `snowtricks`

Or one of the 3 default user account :

- [ ] `judas.bricot@snowtricks.fr` | `snowtricks`
- [ ] `alonzo.ski@snowtricks.fr` | `snowtricks`
- [ ] `max.hymale@snowtricks.fr` | `snowtricks`