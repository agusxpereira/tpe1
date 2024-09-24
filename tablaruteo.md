# TPE

## ruteo (B)
| accion            | metodo    | url                      | 
|:-----------------:|:---------:|:------------------------:|
| home              | get       | /listar/categoria        | 
| listarCategoria   | get       | /listar/categoria:id     | 
|-------------------|-----------|    ------------------    |
| editarCategoria   | post      | /editar/categoria:id     |
| eliminarCategoria | post      | /eliminar/categoria:id   | 
| agregar           | post      | /agregar/categoria       |
| login             | -         | /login                   | 

## Ruteo (A)

| accion       | metodo    | url                   | 
|:------------:|:---------:|:---------------------:|
| listarItems  | get       | /listar/items         | 
| listarItem   | get       | /listar/items:id      | 
|-------       |------     |:---------------------:|
| agregarItem  | post      | /agregar/item         | 
| editarItem   | post      | /editar/item:id       |
| eliminarItem | post      | /eliminar/item:id     | 
| logout       | -         | /logout               |


- router llama al controlador


-  home: muestra todos los libros

- agregar: redirije a un formulario, este formulario redirije al home una vez insertado el elemento.

-  El listar de categorias usa el listar de items? En que caso se puede usar el listar items?

 > Como manejamos la sesion? Guardamos al administrador de manera local o en la base de datos?

 > preguntar si está bien la tabla de ruteo.
 > Preguntar si más adelante se puede agregar la tabla puntuacion