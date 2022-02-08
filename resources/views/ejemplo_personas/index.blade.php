<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Personas</h1>
    <a href="creaw" >Crear pesona</a>
    
    <table>
        <thead>
            <tr>
                <th>
                    id
                </th>
                <th>
                    nombre
                </th>
                <th>
                    apellido
                </th>
                <th>
                    documento
                </th>
            </tr>
        </thead>
       <tbody>
            @foreach($ejemplo_personas as $persona)
            <tr>
                <th>
                    {{$persona->id}}
                </th>
                <th>
                    {{$persona->nombre}}
                </th>
                <th>
                    {{$persona->apellido}}
                </th>
                <th>
                    {{$persona->numero_documento}}
                </th>
            </tr>
            @endforeach
       </tbody>
    </table>
</body>
</html>