<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

<page>
    <body>
        <h1 class="fs-5 bg-info text-center text-bold" >Bienvenidos a SENATI</h1>
        <h3 class="mt-3 mb-3 text-center text-italic">Desarrollado por <?= $desarrollador?></h3>
        <p class="mb-3 text-justify">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque porro sed optio sit molestiae aliquid, atque, eveniet laudantium non sint error vel veritatis officiis. Error officia minus reiciendis amet cumque.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque porro sed optio sit molestiae aliquid, atque, eveniet laudantium non sint error vel veritatis officiis. Error officia minus reiciendis amet cumque.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque porro sed optio sit molestiae aliquid, atque, eveniet laudantium non sint error vel veritatis officiis. Error officia minus reiciendis amet cumque.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque porro sed optio sit molestiae aliquid, atque, eveniet laudantium non sint error vel veritatis officiis. Error officia minus reiciendis amet cumque.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque porro sed optio sit molestiae aliquid, atque, eveniet laudantium non sint error vel veritatis officiis. Error officia minus reiciendis amet cumque.
        </p>
        <table class="bg-success">
            <colgroup>
                <col style="width: 50%;">
                <col style="width: 50%;">
            </colgroup>
            <thead>
                <tr>
                    <th>Sedes</th>
                    <th>Carreras</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataTable as $data):?>
                    <tr>
                        <td><?= $data["sede"]?></td>
                        <td><?= $data["carrera"]?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </page>
<page>
    <ul>
        <?php foreach($carreras as $carrera):?>
            <li><?= $carrera?></li>
        <?php endforeach;?>
    </ul>
    </body>
</page>
</html>