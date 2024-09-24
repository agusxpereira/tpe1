# TPE

## ruteo (A)
| accion            | metodo    | url                          | 
|:-----------------:|:---------:|:----------------------------:|
| home              | get       | /listar/categoria            | 
| listarCategoria   | get       | /listar/categoria:id         | 
|----------------- -|------     |                ------        |
| editarCategoria   | post      | /editar/item:id              |
| eliminarCategoria | post      | /eliminar/item:id            | 
| agregar           | post      | /agregar/categoria           |
| login             | -         | /login                       | 

## Ruteo (B)

| accion       | metodo    | url                   | 
|:------------:|:---------:|:---------------------:|
| listarItems  | get       | /listar/items         | 
| listarItem   | get       | /listar/items:id      | 
|-------       |------     |:---------------------:|
| agregarItem  | post      | /agregar/item         | 
| editarItem   | post      | /editar/item:id       |
| eliminarItem | post      | /eliminar/item:id     | 
| logout       | -         | /logout               |


> Llamar al controlador


> home: muestra todos los libros

> agregar: redirije a un formulario, este formulario redirije al home una vez insertado el elemento.

 