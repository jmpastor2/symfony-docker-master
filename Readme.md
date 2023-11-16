
# SESAME BACK PROJECT

Primero de todo comentaros que he disfrutado instalando Dockers levantando contenedores, buscando medios por internet que tuvieran implementado estos servicios solicitados.


## Servicios implementados

- Mysql
- PhpMyadmin
- Php
- Nginx


## Instalación

To deploy this project: primero clona el repo =D

```bash
  docker compose up -d
  and run composer install to install dependencies from /var/www/symfony folder.
```


## Partes del proyecto solicitado

He desarrollado desde cero, un proyecto en Symfony 6.2.11 donde albergo dos entidades solicitadas con sus relaciones, se genera la estructura basada en una arquitectura Hexagonal, DDD y principios SOLID.


```bash
 - src
  - Application
    - User
      - CreateUser
      - UpdateUser
      - DeleteUser
      - GetUserById
      - GetAllUsers
    - WorkEntry
      - CreateWorkEntry
      - UpdateWorkEntry
      - DeleteWorkEntry
      - GetWorkEntryById
      - GetWorkEntriesByUserId
  - Domain
    - Model
      - User
      - WorkEntry
    - Repository
      - UserRepositoryInterface
      - WorkEntryRepositoryInterface
  - Infrastructure
    - Persistence
      - Repository
        - UserRepository
        - WorkEntryRepository
  - Presentation
    - Controller
      - UserController
      - WorkEntryController
  - Resources
    - config
    - ...
- tests
- var
- ...
```
## Despliegue de entidades

Para el proyecto solicitado, he utilizado comandos como [make], para una api visual http://localhost/api/graphql para el generador de entidades Doctrine, para la fase de test [PhpUnit] 


## Siguientes pasos

Para la parte visual se puede instalar el uso de plantillas de twig para general formularios (CRUD) he tenido algún error con el tema de trabajar directamente sobre el docker, ya que estoy aconstumbrado a trabajar en PhPstorm, y con VisualStudio he tenido que modificar algún plugin para hacerlo.

Realmente solo he implementado funcionalidades y estructura pero se puede mejorar mucho más y desplegar más test, y llamadas de API. 
## Datos Utilizados

he utlizado distintas web de información.

